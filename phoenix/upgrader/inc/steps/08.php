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

                        $versionpath = 'CE-Phoenix';

                        // lets get the actual folder name that was extracted (when using github api the folder name is not consistent so we need to find it)
                        $files = scandir('inc/clean_core/');
                        foreach ($files as $file) {
                            if (is_dir('inc/clean_core/' . $file) && strpos($file, $versionpath) === 0) {
                                $extracted_folder = 'inc/clean_core/' . $file;
                                break;
                            }
                        }
                        //error_log('Extracted folder: ' . $extracted_folder);

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
                        //error_log('installed files: ' . print_r($installedfiles, true));

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
                        //zipGetCoreArray( 'inc/clean_core/' . $versionpath . trim( $cep_version ), $exclude2, 1 );
                        zipGetCoreArray( $extracted_folder, $exclude2, 1 );

                        //error_log('clean core files: ' . print_r($cleancorefiles, true));

                        foreach ( $installedfiles as $installedfilekey => $installedfile ) {
                            if ( empty( $cleancorefiles[ $installedfilekey ] ) ) {
                                $zip_added_files[] = $installedfilekey;
                            } else if ( $cleancorefiles[ $installedfilekey ] != $installedfile ) {
                                $zip_altered_files[] = $installedfilekey;
                            }
                        }
                        zipAlert( TEXT_STEP_08_WARNING, 'success' );
                        $db = mysqli_connect( DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, MYSQL_PORT );

                        $set_template = templateInitialise();
                        zipAlert( sprintf(TEXT_STEP_08_CURRENT_TEMPLATE, $set_template), 'info' );

                        $worklist = file_exists( $inc_directory . '/worklist.json' ) ? json_decode( file_get_contents( $inc_directory . '/worklist.json' ), true ) : [];

                        $admin_path = str_replace( $GLOBALS['config']['cep_files']['root'], '', $GLOBALS['config']['cep_files']['admin'] );

                        echo '<ul class="list-group">';
                        $b = 0;

                        foreach ( $zip_altered_files as $zip_added_file ) {

                          switch (true) {
                            case ($zip_added_file === DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php'):
                            case ($zip_added_file === $admin_path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php'):
                              $worklist_style = TEXT_WORKLIST_EXPECTED;
                              break; 
                            case ($worklist[$zip_added_file]['status'] ?? '') === 'complete':
                              $worklist_style = TEXT_WORKLIST_DONE;
                              break;
                            case ! isset($worklist["{$zip_added_file}"]):
                              $worklist_style = TEXT_WORKLIST_NEW;
                              //error_log("Worklist item for file {$zip_added_file} is NEW.");
                              //error_log('Not ' . $admin_path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php');
                              break;
                            default:
                              $worklist_style = TEXT_WORKLIST_TO_DO;
                          }

                          $overrides = '';
                          if ($override_file = coreFileIsOverridden($zip_added_file)) {
                              $overrides = ' <span class="badge badge-info">' . sprintf(TEXT_CORE_CHANGE_OVERRIDDEN, $override_file) . '</span>';
                          } elseif (coreChangeShouldOverride($zip_added_file)) {
                              $overrides = ' <span class="badge badge-warning">' . TEXT_CORE_CHANGE_SHOULD_OVERRIDE . '</span>';
                          }

                          echo '<li class="list-group-item align-items-center justify-content-between d-flex py-1">' . htmlspecialchars($zip_added_file, ENT_QUOTES, 'UTF-8') . $overrides . ' <span>' . zipButton(TEXT_BUTTON_DIFFS, 'secondary btn-diff', '#', 'fa-compress-alt', 'md', 'diffs' . $b, ['filename' => $zip_added_file, 'corepath' => $extracted_folder, 'corefile' => $zip_added_file, 'index' => $b]) . ' <i id="worklist_' . $b . '" class="' . $worklist_style . '"></i></span></li>';
                          $b++;

                        }
                        if ( $b == 0 ) {
                            echo '<li class="list-group-item">' . TEXT_STEP_08_NO_ALTERED_FILES . '</li>';
                        }
                        echo '</ul>';

                        $save_changes = 1;
                        $config['core_changed_files'] = $zip_altered_files;
                        $config['core_added_files'] = $zip_added_files;
                        $config['next_version'] = $next_version;
                        $config['limitstep'] = ( $config['limitstep'] < 8 ) ? 8 : $config['limitstep'];

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
          outputDiffContent('08');

        }
    }