<?php

    /*

 Version: 2.0.0
 Name: Zipur CE Phoenix Upgrade Utility

 Author: Preston Lord
 	 phoenixaddons.com / @zipurman / plord@inetx.ca

 Released under the GNU General Public License

 Copyright (c) 2021: Preston Lord - @zipurman - Intricate Networks Inc.

  Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

  1. Re-distributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

  2. Re-distributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

  3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/

    $next_version = '';
    $max_version  = '';
    $num_versions = 0;

    if ( ! empty( $zipmigutil ) ) {

        require 'languages/english/primary.php';
        require_once 'functions/functions.php';
        zipurSessionStart();

        $inc_directory = dirname( __FILE__ );
        $save_changes  = 0;
        $require_step  = '0';
        $logout        = zipVarCheck( 'logout', 0, 'FILTER_VALIDATE_INT', 0 );

        if ( ! empty( $logout ) ) {
            $_SESSION = [];
            $cookie = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600, $cookie['path'], '', $cookie['secure'], true);
            session_destroy();
            header( "Location: index.php" );
            exit;
        }

        $step  = zipVarCheck( 'step', 0, 'FILTER_VALIDATE_INT', 0 );
        $ustep = zipVarCheck( 'ustep', 0, 'FILTER_VALIDATE_INT', 0 );

        $output_buffer = 1;
        if ( ! ini_get( 'output_buffering' ) && ! ob_get_level() ) {
            ob_start();
            if ( ob_get_level() ) {
                $output_buffer = 1;
            } else {
                $output_buffer = 0;
            }
            ob_end_flush();
        }


        //set unlimited memory
        ini_set( 'memory_limit', '-1' );
        ini_set( 'max_execution_time', 3600 ); //3600 seconds = 60 minutes
        if ( ! empty( $output_buffer ) ) {
//                ob_implicit_flush( true );
//                ob_end_flush();
        }

        //zipConfigFileSet();
        $zipFileVersion = zipGetFileVersion( basename( __FILE__ ) );

        require $inc_directory . '/config.php';

        $setup_password_too_short = false;
        if (empty($config['password']) && $step == 2) {
            if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
                $step = 1;
            } else {
                zipurRequireCsrf();
                $new_password = $_POST['zip_password'] ?? '';
                if (!is_string($new_password) || strlen($new_password) < 12) {
                    $setup_password_too_short = true;
                    $step = 1;
                } else {
                    $config['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                    zipurWriteConfig($config);
                    session_regenerate_id(true);
                    $_SESSION['zipur_authenticated'] = true;
                    $_SESSION['zipur_last_activity'] = time();
                    header('Location: index.php?step=3');
                    exit;
                }
            }
        }

        $login_failed = 0;
        if ( ! empty( $config['password'] ) ) {
            if ( $step == 999 && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' ) {
                zipurRequireCsrf();
                $zip_login_password = $_POST['zip_login_password'] ?? '';
                $stored_password = $config['password'];
                $valid_password = is_string($zip_login_password) &&
                    (password_verify($zip_login_password, $stored_password)
                    || hash_equals($stored_password, $zip_login_password));
                if ($valid_password) {
                    session_regenerate_id(true);
                    $_SESSION['zipur_authenticated'] = true;
                    $_SESSION['zipur_last_activity'] = time();
                    if (password_needs_rehash($stored_password, PASSWORD_DEFAULT)) {
                        $config['password'] = password_hash($zip_login_password, PASSWORD_DEFAULT);
                        zipurWriteConfig($config);
                    }
                    header('Location: index.php?step=3');
                    exit;
                }
                $login_failed = 1;
            }
            if ( !zipurIsAuthenticated() ) {
                $step = '999';
            } else if ( $step < 3 ) {
                $step = 3;
            }
            if ( zipurIsAuthenticated() && ! empty( $config['cep_files'] ) && ! empty( $config['cep_files']['root'] ) && file_exists( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php' ) ) {

                require( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php' );
                $cep_version = file_get_contents( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'version.php' );
                $cep_version = trim( $cep_version );

                require( 'inc/versions/controller.php' );
                //error_log('versions ' . print_r($versions, true));
                //error_log('config ' . print_r($config, true));
                /*error_log('cep_version ' . print_r($cep_version, true));
                error_log('compare result ' . version_compare( "{$config['next_version']}", "{$cep_version}" )); */

                if ( ! empty( $config['next_version'] ) && version_compare( "{$config['next_version']}", "{$cep_version}" ) > 0 && is_dir( __DIR__ . '/versions/' . $config['next_version'] )) {
                    $next_version = $config['next_version'];
                } else {
                    /* foreach ( $versions as $ver_check ) {
                        //error_log('checking version ' . $ver_check['version']);
                        if ( version_compare( "{$ver_check['version']}", "{$cep_version}" ) >= 1 ) {

                            $num_versions ++;
                            $max_version = $ver_check['version'];
                            if ( empty( $next_version ) ) {
                                $next_version = $ver_check['version'];
                            }

                        }
                    } */
                    if ( empty($next_version) || ! is_dir( __DIR__ . '/versions/' . $next_version ) ) {
                        list($next_version, $available_updates) = cartmartCheckVersion($cep_version);
                        //error_log('Cartmart check result: next_version=' . $next_version . ' available_updates=' . print_r($available_updates, true));
                        foreach ($available_updates as $update) {
                            if (! is_dir( __DIR__ . '/versions/' . $update['version'] ) ) {
                                mkdir( __DIR__ . '/versions/' . $update['version'], 0755 );
                            }
                        }
                    }
                }

                $admin_folder = str_replace( $config['cep_files']['root'] . '/', '', $config['cep_files']['admin'] );
            }
        } else if ( $step > 2 ) {
            header( "Location: index.php?logout=1" );
            exit;
        }

        header( 'Expires: Sun, 01 Jan 2014 00:00:00 GMT' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'Cache-Control: post-check=0, pre-check=0', false );
        header( 'Pragma: no-cache' );

        $stepnum  = $step;
        $nextstep = $step + 1;
        $laststep = $step - 1;
        $step     = str_pad( $step, 2, '0', STR_PAD_LEFT );

        $ustepnum = $ustep;
        $ustep    = str_pad( $ustep, 2, '0', STR_PAD_LEFT );

        ?>
        <!DOCTYPE html>
        <html dir="ltr" lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <script>window.zipurCsrfToken = <?= json_encode(zipurCsrfToken()) ?>;</script>
            <title>CE Phoenix Upgrader Utility</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
            <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css">
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"
                  integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
                  integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
                  crossorigin="anonymous"/>
            <style>
                .diff-container { font-family: Arial, sans-serif; margin: 20px; }
                .diff-container { display: flex; gap: 20px; }
                .diff-container .code-block { width: 100%; border: 1px solid #ccc; background: #fafafa; overflow-x: auto; padding: 10px; }
                .diff-container table { border-collapse: collapse; width: 100%; }
                .diff-container td.line-num { width: 40px; background: #f6f8fa; color: #999; text-align: right; padding: 0 5px; border-right: 1px solid #ddd; }
                .diff-container td.code { padding: 0 10px; white-space: pre; vertical-align: top; }
                .diff-container ins { background-color: #e6ffed; text-decoration: none; }
                .diff-container del { background-color: #ffeef0; text-decoration: none; }
                .diff-container pre { margin: 0; }
                .diff-container h2 { margin-bottom: 10px; }
                .diff-container button { padding: 8px 12px; margin-bottom: 15px; cursor: pointer; }
            </style>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
                    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
            <script
                    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                    crossorigin="anonymous"></script>
        </head>
    <body>
    <div class="container-fluid" style="max-width: 98%;">
        <div class="row">
        <div id="contentText" class="col p-2">
        <div class="row">
            <div class="col" style="text-align: left; padding: 0px 40px; margin-bottom: 10px;">
                Check out Preston's <a href="https://www.youtube.com/user/zipurman"
                                   target="_blank">YouTube Channel</a> for Instructions on this tool and more!
            </div>
            <div class="col" style="text-align: right; padding: 0px 40px; margin-bottom: 10px;">
                Created by @zipurman (<a href="https://PhoenixAddons.com" target="_blank">PhoenixAddons.com</a>)
                Now maintained by @BrockleyJohn (<a href="https://cartmart.uk" target="_blank">Cartmart.uk</a>)
            </div>
        </div>
        <div class="bg-dark text-light p-4 m-0 mw-100 rounded">
            <div class="row">
                <div class="col-sm">
                    <a href="https://cartmart.uk" target="_blank"><img
                                src="https://cartmart.uk/images/CE-Phoenix_Addons_cartmart_logo.png"
                                style="width: 220px;"></a>
                </div>
                <div class="col-sm text-center">
                    <h4 class="display-7 mb-2">CE Phoenix<br/>Upgrade Utility <?php
                            if ( ! empty( $cep_version ) ) {
                                echo '<br/><small>(Phoenix Version: ' . $cep_version . ')</small>';
                            }

                        ?> </h4>
                </div>
                <div class="col-sm text-center">
                    <small><?php echo $zipFileVersion; ?></small><br>
                <?php @include('inc/support.php'); ?>
                </div>
            </div>
        </div>
        <br/>
        <?php
            if ( ! empty( $login_failed ) ) {
                zipAlert( TEXT_LOGIN_FAILED );
            }
            if ($setup_password_too_short) {
                zipAlert(TEXT_PASSWORD_TOO_SHORT);
            }
            if ( zipurIsAuthenticated() ) {
                ?>
                <div class="navbar-light bg-light text-right">
                    <?php
                        $worklist = file_exists( $inc_directory . '/worklist.json' ) ? json_decode( file_get_contents( $inc_directory . '/worklist.json' ), true ) : [];

                        if (! empty( $worklist )  ) {
                            echo zipButton( TEXT_BUTTON_VIEW_WORKLIST, 'warning', 'view_worklist.php', 'fa-tasks', 'sm', 'worklist_button' );
                        }

                        /** @var int $laststep */
                        /** @var int $laststep */
                        echo zipButton( TEXT_BUTTON_LOGOUT, 'secondary', 'index.php?logout=1', 'fa-sign-out-alt', 'sm' );
                    ?>
                </div>
                <?php
            }
        ?>

        <hr/>

        <?php

        if ( empty( $output_buffer ) ) {
            zipAlert( 'php output_buffering should be enabled in php.ini' );
        }
        if ( version_compare( PHP_VERSION, '7.1.0' ) < 0 ) {
            zipAlert( 'PHP &gt;= 7.1.x is recommended. You have ' . PHP_VERSION . ' installed.' );
        }
        if ( ! extension_loaded( 'mysqli' ) ) {
            zipAlert( 'The php-mysqli extension is required but is not installed.' );
        }
        if ( ! ( extension_loaded( 'zip' ) || extension_loaded( 'Phar' ) )) {
            zipAlert( 'The php-zip or php-Phar extension is required but neither is installed.' );
        }
        if ( ! extension_loaded( 'curl' ) ) {
            zipAlert( 'The php-curl extension is required but is not installed.' );
        }
    }



