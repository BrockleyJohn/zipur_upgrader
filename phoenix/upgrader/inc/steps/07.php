<?php

    /*

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

    if ( ! empty( $inc_directory ) ) {

        $this_step_file = str_replace( '.php', '', basename( __FILE__ ) );

        if ( $require_step == $this_step_file || empty( $require_step ) ) {

            if ('getcore' === ($_POST['action'] ?? '')) {

                $okset = 1;

                zipDeleteDirectory( 'inc/clean_core/');

                //check core files
                //if ( ! file_exists( 'inc/clean_core/' . $cep_version ) ) {

                    if ( ! file_exists( 'inc/clean_core' ) ) {
                        if ( ! mkdir( 'inc/clean_core', 0700 ) ) {
                            echo '<span class="text-danger">' . TEXT_DIRECTORY_CREATE_ERROR . '</span>';
                            $okset = 0;
                        }
                    }

                    $extracted_folder = 'inc/clean_core/';

                    if ( ! empty( $okset ) ) {
                        $ziparch = class_exists('ZipArchive');

                        if ( version_compare( '1.0.8.0', trim( $cep_version ) ) <= 0 /*|| version_compare( '1.1.0.0', trim( $cep_version ) ) >= 0*/ ) {
                            //$newurl      = 'https://codeload.github.com/CE-PhoenixCart/PhoenixCart/zip/' . trim( $cep_version );
                            $newurl      = 'https://api.github.com/repos/CE-PhoenixCart/PhoenixCart/zipball/v' . trim( $cep_version );
                            $versionpath = 'CE-PhoenixCart-PhoenixCart-';

                        } else {
                            $newurl      = 'https://codeload.github.com/gburton/CE-Phoenix/zip/' . trim( $cep_version );
                            $versionpath = 'CE-Phoenix-';

                        }

                        $zipext = $ziparch ? '.zip' : '.tar.gz';
                        $newpath = 'inc/clean_core/' . trim( $cep_version ) . $zipext;
                        $fp      = fopen( $newpath, 'w+' );
                        $ch      = curl_init();
                        curl_setopt( $ch, CURLOPT_URL, $newurl );
                        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
                        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
                        curl_setopt( $ch, CURLOPT_USERAGENT, 'PhoenixUpgrader/' . $zipFileVersion );
                        curl_setopt( $ch, CURLOPT_FILE, $fp );
                        curl_exec( $ch );
                        $info = curl_getinfo($ch);
                        curl_close( $ch );
                        fclose( $fp );
                        error_log('Download info: ' . print_r($info, true));

                        if ( $info['http_code'] !== 200 && $info['http_code'] !== 302 || ! file_exists( $newpath ) ) {
                            echo '<span class="text-danger">' . ZIPUR_CODE_COMPARE_DOWNLOAD_ERROR . ' (' . $versionpath . trim( $cep_version ) . $zipext . ')</span>';
                            $okset = 0;
                        } else {
                            echo '<span class="text-success">' . ZIPUR_CODE_COMPARE_DOWNLOAD_SUCCESS . ' (' . $versionpath . trim( $cep_version ) . $zipext . ')</span>';
                            if ($ziparch) {
                                $zip = new ZipArchive;
                                $res = $zip->open( $newpath );
                                if ( $res === true ) {
                                    $zip->extractTo( 'inc/clean_core/' );
                                    $zip->close();
                                    echo '<br/><span class="text-success">' . ZIPUR_CODE_COMPARE_UNZIP_SUCCESS . '</span>';
                                    unlink( $newpath );//deletes downloaded zip
                                } else {
                                    echo '<br/><span class="text-danger">' . ZIPUR_CODE_COMPARE_UNZIP_FAILED . ' (' . $newpath . ')</span>';
                                    $okset = 0;
                                }
                            } else {
                                $gz_extract = new PharData( $newpath );
                                $gz_extract->decompress(); // creates files.tar
                                $tar_extract = new PharData( str_replace( '.gz', '', $newpath ) );
                                $tar_extract->extractTo( 'inc/clean_core/' );
                                unlink( str_replace( '.gz', '', $newpath ) );//deletes tar
                                unlink( $newpath );//deletes downloaded zip
                                echo '<br/><span class="text-success">' . ZIPUR_CODE_COMPARE_UNZIP_SUCCESS . '</span>';
                            }

                        }

                        $save_changes        = 1;
                        $config['core_downloaded'] = 1;
                        $config['limitstep'] = 7; 

                        echo '<br>' . zipButton( TEXT_BUTTON_NEXT, 'success', 'index.php?step=3', 'fa-chevron-right', 'sm' );
                    }

                //}

            } else {
            ?>

            <div class="w-75 m-auto">
                <p><?php echo TEXT_STEP_07_DESCRIPTION; ?></p>
                <div class="navbar-light bg-light text-right">
                    <?php
                        /** @var int $laststep */
                        echo zipButton( TEXT_BUTTON_BACK, 'secondary', 'index.php?step=3', 'fa-chevron-left', 'sm' );
                        echo '<form method="post" class="d-inline-block" id="getcoreform" action="index.php?step=7">';
                        echo '<input type="hidden" name="action" value="getcore">';
                        echo zipButton( TEXT_BUTTON_PROCEED, 'success', 'submit', 'fa-chevron-right', 'sm' );
                    ?>
                    </form>
                </div>
            </div>

            <?php

            }
        }
    }