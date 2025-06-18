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

            $db = mysqli_connect( DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, MYSQL_PORT );

            ?>

            <div class="w-75 m-auto">
                <p><?php
                        if (!empty($next_version)) {
                            echo TEXT_STEP_10_DESCRIPTION . $next_version;
                        } else {
                            echo TEXT_NO_UPGRADES;
                        }
                        ?></p>


                <?php

                    $upgrade = [];

                    foreach ( $versions as $version ) {
                        if ( $next_version == $version['version'] ) {

                            $upgrade = loadUpgradeVersion( $version['version'] );
                            if ( ! empty( $upgrade['settings'] ) ) {
                                if ( version_compare( "{$upgrade['settings']['requires']}", "{$cep_version}" ) == 0 ) {

                                    showUpgrade( $upgrade, $config );

                                }
                            }
                        }
                    }
                    if ( ! empty( $upgrade['settings'] ) ) {

                        if ( ! empty( $upgrade['conflict'] ) ) {
                            zipAlert( TEXT_CONFLICT );
                        }
                        if ( $upgrade['exists'] ) {
                            zipAlert( TEXT_BACKUP_WARNING );
                            $save_changes        = 1;
                            $config['limitstep'] = ( $config['limitstep'] < 10 ) ? 10 : $config['limitstep'];
                        }
                    }

                ?>

                <div class="navbar-light bg-light text-right">
                    <?php
                        /** @var int $laststep */
                        echo zipButton( TEXT_BUTTON_BACK, 'secondary', 'index.php?step=3', 'fa-chevron-left', 'sm' );
                        if ( ! empty( $upgrade['settings'] ) && $upgrade['exists'] ) {
                            echo zipButton( TEXT_UPGRADE_NOW, 'success', 'index.php?step=11', 'fa-chevron-right', 'sm' );
                        }
                    ?>
                </div>
            </div>

            <?php

        }
    }