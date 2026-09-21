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

            if (isset($_POST['cfgid'])) {
                zipurRequireCsrf();
                $cfgid = filter_var($_POST['cfgid'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
                if ($cfgid === false) {
                    throw new RuntimeException('Invalid configuration entry.');
                }
                $candidate = mysqli_query($db, "SELECT configuration_key FROM configuration WHERE configuration_id=" . $cfgid);
                $row = $candidate ? mysqli_fetch_assoc($candidate) : false;
                if (!$row) {
                    throw new RuntimeException('Configuration entry not found.');
                }
                $key = mysqli_real_escape_string($db, $row['configuration_key']);
                $matches = mysqli_query($db, "SELECT COUNT(*) AS total FROM configuration WHERE configuration_key='" . $key . "'");
                $count = $matches ? mysqli_fetch_assoc($matches) : false;
                if (!$count || (int) $count['total'] < 2) {
                    throw new RuntimeException('This entry is no longer duplicated.');
                } 
                if (!mysqli_query($db, "DELETE FROM configuration WHERE configuration_id=" . $cfgid . " LIMIT 1")) {
                    throw new RuntimeException('Could not delete the duplicate configuration entry.');
                }
            }
            $duplicateRow = function ($row) {
                $details = [];
                foreach (['configuration_id', 'configuration_title', 'configuration_value', 'use_function', 'set_function'] as $field) {
                    $details[] = htmlspecialchars((string) ($row[$field] ?? ''), ENT_QUOTES, 'UTF-8');
                }
                return '<br/>' . implode(':', $details)
                    . ' <form action="index.php?step=9" method="post" class="d-inline-block">'
                    . '<input type="hidden" name="cfgid" value="' . (int) $row['configuration_id'] . '">'
                    . '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(zipurCsrfToken(), ENT_QUOTES, 'UTF-8') . '">'
                    . '<button type="submit">' . htmlspecialchars(TEXT_DELETE, ENT_QUOTES, 'UTF-8') . '</button></form>';
            };


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

                            $alert_text = TEXT_STEP_09_DUPLICATE . ' ' . htmlspecialchars($result['configuration_key'], ENT_QUOTES, 'UTF-8');
                            $alert_text .= $duplicateRow($result);
                            $alert_text .= $duplicateRow($dupe_check[$result['configuration_key']]);

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