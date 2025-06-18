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
        $zip_cep_root   = zipVarCheck( 'zip_cep_root', '' );
        $zip_cep_admin  = zipVarCheck( 'zip_cep_admin', '' );

        $zip_cep_root  = rtrim( $zip_cep_root, DIRECTORY_SEPARATOR );
        $zip_cep_admin = rtrim( $zip_cep_admin, DIRECTORY_SEPARATOR );

        $temp = [
            'root'   => $zip_cep_root,
            'admin'  => $zip_cep_admin,
            'status' => 0,
        ];

        $config['cep_files'] = $temp;
        $save_changes = 1;

        if ( $require_step == $this_step_file || empty( $require_step ) ) {
            ?>

            <div class="w-75 m-auto">
                <p><?php echo TEXT_STEP_05_DESCRIPTION; ?></p>

                <?php

                    $okset = 0;

                    if ( file_exists( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'application_top.php' ) ) {
                        zipAlert( TEXT_FILES_ROOT_SUCCESS, 'success' );
                        $okset ++;
                    } else {
                        zipAlert( TEXT_FILES_ROOT_FAILED );
                    }

                    if ( file_exists( $config['cep_files']['admin'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php' ) ) {
                        zipAlert( TEXT_FILES_ADMIN_SUCCESS, 'success' );
                        $okset ++;
                    } else {
                        zipAlert( TEXT_FILES_ADMIN_FAILED );
                    }

                    if ( $okset == 2 ) {
                        $config['cep_files']['status'] = 1;
                        $config['limitstep'] = ( $config['limitstep'] < 5 ) ? 5 : $config['limitstep'];
                    }

                ?>

                <div class="navbar-light bg-light text-right">
                    <?php
                        /** @var int $laststep */
                        echo zipButton( TEXT_BUTTON_BACK, 'secondary', 'index.php?step=' . $laststep, 'fa-chevron-left', 'sm' );
                        echo zipButton( TEXT_BUTTON_NEXT, 'success', 'index.php?step=3', 'fa-chevron-right', 'sm' );
                    ?>
                </div>
            </div>

            <?php
        }
    }