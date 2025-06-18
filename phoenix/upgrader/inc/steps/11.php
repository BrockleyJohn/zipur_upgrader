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
                <p><?php echo TEXT_STEP_11_DESCRIPTION . $next_version; ?></p>

                <?php

                    $upgrade = [];

                    $upgrade = loadUpgradeVersion( $next_version );
                    if ( ! empty( $upgrade['settings'] ) ) {

                        if ( version_compare( "{$upgrade['settings']['requires']}", "{$cep_version}" ) == 0 ) {
                            showUpgrade( $upgrade, $config, true );
                        }

                    }
                    if ( $upgrade['installed'] ) {

                        $save_changes        = 1;
                        $config['limitstep'] = 9;
                        unset( $config['next_version'] );

                        $catalog_path = defined( 'DIR_WS_CATALOG' ) ? DIR_WS_CATALOG : DIR_WS_HTTP_CATALOG;

                        zipAlert( '<a target="_blank" href="' . HTTP_SERVER . $catalog_path . $admin_folder . '/security_checks.php">' . TEXT_ALL_DONE_LINK_ADMIN . '</a>', 'success' );

                        zipAlert( TEXT_ALL_DONE, 'success' );

                        ?>
                        <div id="ppdonatebox" style="text-align: center;">
                            <?php echo TEXT_DONATE; ?>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                <input type="hidden" name="cmd" value="_s-xclick"/>
                                <input type="hidden" name="hosted_button_id" value="XW8QXWTG4PM58"/>
                                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button"/>
                                <img alt="" style="border: 0px;" src="https://www.paypal.com/en_CA/i/scr/pixel.gif" width="1" height="1"/>
                            </form>
                        </div>
                        <?php

                    } else {

                        zipAlert( TEXT_UPGRADE_FAILED );

                    }

                ?>

                <div class="navbar-light bg-light text-right">
                    <?php
                        /** @var int $laststep */
                        echo zipButton( TEXT_BUTTON_BACK, 'secondary', 'index.php?step=10', 'fa-chevron-left', 'sm' );
                        if ( $upgrade['installed'] ) {
                            echo zipButton( TEXT_BUTTON_NEXT, 'success', 'index.php?step=3', 'fa-chevron-right', 'sm' );
                        }
                    ?>
                </div>
            </div>

            <?php

        }
    }