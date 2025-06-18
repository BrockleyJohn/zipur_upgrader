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
            ?>

            <div class="w-75 m-auto">
                <p><?php echo TEXT_STEP_08_DESCRIPTION; ?></p>

                <?php

                    $okset = 1;

                    zipDeleteDirectory( 'inc/clean_core/');

                    //check core files
                    if ( ! file_exists( 'inc/clean_core/' . $cep_version ) ) {

                        if ( ! file_exists( 'inc/clean_core' ) ) {
                            if ( ! mkdir( 'inc/clean_core', 0700 ) ) {
                                echo '<span class="text-danger">' . TEXT_DIRECTORY_CREATE_ERROR . '</span>';
                                $okset = 0;
                            }
                        }

                        if ( ! empty( $okset ) ) {
                            $ziparch = class_exists('ZipArchive');

                            if ( version_compare( '1.0.8.0', trim( $cep_version ) ) <= 0 ) {
                                $newurl      = 'https://codeload.github.com/CE-PhoenixCart/PhoenixCart/zip/' . trim( $cep_version );
                                $versionpath = 'PhoenixCart-';

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
                            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
                            curl_setopt( $ch, CURLOPT_FILE, $fp );
                            curl_exec( $ch );
                            curl_close( $ch );
                            fclose( $fp );

                            if ( ! file_exists( $newpath ) ) {
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
                        }

                        $installedfiles    = [];
                        $cleancorefiles    = [];
                        $zip_added_files   = [];
                        $zip_altered_files = [];

                        //Start compare
                        $exclude1 = [
                            'images',
                            'imported',
                            'updates',
                            'old',
                            'install',
                            'clean_core',
                            'upgrader',
                            '.github/',
                            'zcache',
                            'xdebug',
                            'README',
                            'README.md',
                        ];

                        //setup array for existing install
                        zipGetCoreArray( $config['cep_files']['root'], $exclude1 );

                        $exclude2 = [
                            'images',
                            'imported',
                            'updates',
                            'old',
                            'clean_core',
                            'upgrader',
                            '.github/',
                            'zcache',
                            'xdebug',
                            'README',
                            'README.md',
                        ];

                        //setup array for clean core (same version)
                        zipGetCoreArray( 'inc/clean_core/' . $versionpath . trim( $cep_version ), $exclude2, 1 );

                        foreach ( $installedfiles as $installedfilekey => $installedfile ) {
                            if ( empty( $cleancorefiles[ $installedfilekey ] ) ) {
                                $zip_added_files[] = $installedfilekey;
                            } else if ( $cleancorefiles[ $installedfilekey ] != $installedfile ) {
                                $zip_altered_files[] = $installedfilekey;
                            }
                        }
                        zipAlert( TEXT_STEP_08_WARNING, 'success' );

                        echo '<ul class="list-group">';

                        foreach ( $zip_altered_files as $zip_added_file ) {

                            echo '<li class="list-group-item align-middle">' . $zip_added_file . '</li>';

                        }
                        echo '</ul>';

                        $config['core_changed_files'] = $zip_altered_files;
                        $config['core_added_files'] = $zip_added_files;
                        $config['next_version'] = $next_version;
                        $save_changes        = 1;

                    }

                    if ( $okset == 1 ) {
                        $save_changes        = 1;
                        $config['limitstep'] = ( $config['limitstep'] < 8 ) ? 8 : $config['limitstep'];
                    }

                ?>

                <div class="navbar-light bg-light text-right">
                    <?php
                        /** @var int $laststep */
                        echo zipButton( TEXT_BUTTON_BACK, 'secondary', 'index.php?step=3', 'fa-chevron-left', 'sm' );
                        echo zipButton( TEXT_BUTTON_NEXT, 'success', 'index.php?step=3', 'fa-chevron-right', 'sm' );
                    ?>
                </div>
            </div>

            <?php
        }
    }