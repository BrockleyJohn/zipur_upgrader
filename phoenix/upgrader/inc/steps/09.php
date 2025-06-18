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

            $db                = mysqli_connect( DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, MYSQL_PORT );

            $cfgid  =  zipVarCheck( 'cfgid', 0, 'FILTER_VALIDATE_INT', 0 );
            if (!empty($cfgid)){
                mysqli_query( $db, "DELETE FROM configuration WHERE configuration_id={$cfgid}" );
            }


            ?>

            <div class="w-75 m-auto">
                <p><?php echo TEXT_STEP_09_DESCRIPTION; ?></p>

                <?php

                    $passed_dupe_check = 1;

                    $query      = mysqli_query( $db, "SELECT * FROM configuration ORDER BY configuration_key" );
                    $dupe_check = [];
                    while ( $result = mysqli_fetch_array( $query, MYSQLI_ASSOC ) ) {

                        if ( ! empty( $dupe_check["{$result['configuration_key']}"] ) ) {
                            $passed_dupe_check = 0;

                            $alert_text = TEXT_STEP_09_DUPLICATE . ' ' . $result['configuration_key'];
                            $alert_text .= '<br/>' . $result['configuration_id'] . ':' . $result['configuration_title'] . ':' . $result['configuration_value'] . ':' . $result['use_function']. ':' . $result['set_function'] . ' <a href="index.php?step=9&cfgid=' . $result['configuration_id'] . '">' . TEXT_DELETE . '</a>';

                            $alert_text .= '<br/>' . $dupe_check["{$result['configuration_key']}"]['configuration_id']  . ':' . $dupe_check["{$result['configuration_key']}"]['configuration_title'] . ':' . $dupe_check["{$result['configuration_key']}"]['configuration_value'] . ':' . $dupe_check["{$result['configuration_key']}"]['use_function']. ':' . $dupe_check["{$result['configuration_key']}"]['set_function'] . ' <a href="index.php?step=9&cfgid=' . $dupe_check["{$result['configuration_key']}"]['configuration_id'] . '">' . TEXT_DELETE . '</a>';

                            zipAlert($alert_text);
                        } else {
                            $dupe_check["{$result['configuration_key']}"] = $result;
                        }
                    }

                    if ( ! empty( $passed_dupe_check ) ) {
                        zipAlert(TEXT_STEP_09_NO_DUPLICATES, 'success');
                        $save_changes        = 1;
                        $config['limitstep'] = ( $config['limitstep'] < 9 ) ? 9 : $config['limitstep'];
                    } else {
                        zipAlert(TEXT_STEP_09_DUPLICATES_FOUND);
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