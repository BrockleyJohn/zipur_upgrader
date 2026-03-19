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
                <p><?php echo TEXT_STEP_03_DESCRIPTION; ?></p>

                <?php

                    if ( ! empty( $cep_version ) ) {

                        $alert_text = '';
                        $alert_text .= TEXT_YOU_ARE_RUNNING . ' ' . $cep_version . '. '  ;

                        if (!empty($max_version)){
                            $alert_text .= TEXT_THERE_ARE . ' ' . $num_versions . ' ' . TEXT_NEWER_VERSIONS . ' ' . $next_version . ' ' . TEXT_MAX_VERSIONS . ' ' . $max_version;

                        }

                        zipAlert( $alert_text );

                    }

//                    zipAlert( 'Recommend to disable NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES on MySQL for upgrading.' );


                ?>

                <ul class="list-group">
                    <?php

                        if ( empty( $config['limitstep'] ) ) {
                            $config['limitstep'] = 3;
                            $save_changes        = 1;
                        }
/*
                    */?><!--
                    <li class="list-group-item align-middle">
                        <a href="https://www.youtube.com/embed/EnQL7tlEp4Y" class="text-danger" target="_blank"><i class="fas fa-arrow-circle-right text-primary"></i>
                            <i class="fab fa-youtube"></i>
                            <?php /*echo TEXT_STEP_03_YOUTUBE; */?></a>
                    </li>
                    --><?php

                        /**
                         * @param     $text
                         * @param     $requiredstep
                         * @param     $linkstep
                         * @param int $limitstep
                         */
                        function zipDashListItem( $text, $requiredstep, $linkstep, $limitstep = 0 ) {

                            global $config;

                            $limitstep = ( empty( $limitstep ) ) ? $config['limitstep'] : $limitstep;

                            echo '<li class="list-group-item">';

                            if ( $limitstep >= $requiredstep ) {
                                echo '<a href="index.php?step=' . $linkstep . '">';
                            } else {
                                echo '<span class="text-secondary">';
                            }
                            echo '<i class="fas fa-arrow-circle-right"></i> ' . $text;
                            if ( $limitstep >= $requiredstep ) {
                                echo '</a>';
                            } else {
                                echo '</span>';
                            }

                            echo '</li>';
                        }

                        $limitstep = 0;

                        $destfilestatus = '';
                        if ( ! empty( $config['cep_files'] ) ) {
                            if ( ! empty( $config['cep_files']['status'] ) ) {
                                $destfilestatus = '<i class="fas fa-check text-success"></i>';
                            }
                        }

                        zipDashListItem( TEXT_STEP_03_EXPORT_FILES . ' ' . $destfilestatus, 3, 4, $limitstep );

                        $teststatus = '';
                        if ( $config['limitstep'] >= 6 ) {
                            $teststatus = '<i class="fas fa-check text-success"></i>';
                        }

                        zipDashListItem( TEXT_STEP_03_CONFIRM_SERVER . ' ' . $teststatus, 5, 6, $limitstep );

                        $upgradetext = '';
                        if ( $config['limitstep'] >= 8 && (!empty($config['core_changed_files']) || !empty($config['core_added_files']))) {
                            $upgradetext = '<i class="fas fa-check text-success"></i>';
                        }

                        zipDashListItem( TEXT_STEP_03_REVIEW_CORE . ' ' . $upgradetext, 6, 7, $limitstep );

                        $tablescounttext = '';
                        if ( $config['limitstep'] >= 9) {
                            $tablescounttext = '<i class="fas fa-check text-success"></i>';
                        }
                        zipDashListItem( TEXT_STEP_03_CHECK_DUPLICATES . ' ' . $tablescounttext, 8, 9, $limitstep );



                        if (!empty($next_version)) {

                            $upgrade = loadUpgradeVersion( $next_version );

                            if ( version_compare( "{$upgrade['settings']['requires']}", "{$cep_version}" ) == 0 ) {

                                $targettablecheck = ( $config['limitstep'] >= 10 ) ? ' <i class="fas fa-check text-success"></i>' : '';
                                zipDashListItem( TEXT_STEP_03_UPGRADE_REVIEW . $next_version . $targettablecheck, 9, 10, $limitstep );

                            } else {

                                zipAlert( TEXT_NO_MEET_REQUIREMENT_UPGRADES, 'success');

                            }

                        } else {
                            zipAlert( TEXT_NO_UPGRADES, 'success');
                        }

                    ?>

                </ul>


            </div>

            <?php
        }
    }