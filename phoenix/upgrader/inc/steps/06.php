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
                <p><?php echo TEXT_STEP_06_DESCRIPTION; ?></p>

                <?php

                    $okset = 1;

                    //test write file to image directory of target
                    $testfile = $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'testfile.txt';

                    //create file
                    touch( $testfile );
                    if ( file_exists( $testfile ) ) {
                        zipAlert( TEXT_FILES_TEST_ROOT_WRITE_IMAGES . ' ' . TEXT_SUCCESSFUL, 'success' );
                    } else {
                        zipAlert( TEXT_FILES_TEST_ROOT_WRITE_IMAGES . ' ' . TEXT_FAILED );
                        $okset = 0;
                    }

                    //remove file
                    unlink( $testfile );
                    if ( ! file_exists( $testfile ) ) {
                        zipAlert( TEXT_FILES_TEST_ROOT_DELETE_IMAGES . ' ' . TEXT_SUCCESSFUL, 'success' );
                    } else {
                        zipAlert( TEXT_FILES_TEST_ROOT_DELETE_IMAGES . ' ' . TEXT_FAILED );
                        $okset = 0;
                    }


                    $testfile = $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'testfile.txt';

                    //create file
                    touch( $testfile );
                    if ( file_exists( $testfile ) ) {
                        zipAlert( TEXT_FILES_TEST_ROOT_WRITE_INCLUDES . ' ' . TEXT_SUCCESSFUL, 'success' );
                    } else {
                        zipAlert( TEXT_FILES_TEST_ROOT_WRITE_INCLUDES . ' ' . TEXT_FAILED );
                        $okset = 0;
                    }

                    //remove file
                    unlink( $testfile );
                    if ( ! file_exists( $testfile ) ) {
                        zipAlert( TEXT_FILES_TEST_ROOT_DELETE_INCLUDES . ' ' . TEXT_SUCCESSFUL, 'success' );
                    } else {
                        zipAlert( TEXT_FILES_TEST_ROOT_DELETE_INCLUDES . ' ' . TEXT_FAILED );
                        $okset = 0;
                    }

                    $db     = mysqli_connect( DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, MYSQL_PORT );
                    $query  = mysqli_query( $db, "CREATE TABLE zip_test_db (
                        id int NOT NULL auto_increment,
                        test varchar(255) NOT NULL,
                        PRIMARY KEY (id)
                        );" );
                    $query  = mysqli_query( $db, "SHOW TABLES LIKE 'zip_test_db'" );
                    $result = mysqli_fetch_array( $query, MYSQLI_ASSOC );
                    if ( ! empty( $result ) ) {
                        zipAlert( TEXT_MYSQL_TEST_CREATE_TABLE_CEP . ' ' . TEXT_SUCCESSFUL, 'success' );
                    } else {
                        zipAlert( TEXT_MYSQL_TEST_CREATE_TABLE_CEP . ' ' . TEXT_FAILED );
                        $okset = 0;
                    }

                    $query  = mysqli_query( $db, "DROP TABLE zip_test_db" );
                    $query  = mysqli_query( $db, "SHOW TABLES LIKE 'zip_test_db'" );
                    $result = mysqli_fetch_array( $query, MYSQLI_ASSOC );
                    if (  empty( $result ) ) {
                        zipAlert( TEXT_MYSQL_TEST_DELETE_TABLE_CEP . ' ' . TEXT_SUCCESSFUL, 'success' );
                    } else {
                        zipAlert( TEXT_MYSQL_TEST_DELETE_TABLE_CEP . ' ' . TEXT_FAILED );
                        $okset = 0;
                    }

                    if ( $okset == 1 ) {
                        $save_changes = 1;
                        $config['limitstep'] = ( $config['limitstep'] < 6 ) ? 6 : $config['limitstep'];
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