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

    /**
     * @param        $var_to_check
     * @param        $default_value
     * @param string $checkformat
     * @param string $if_invalid_value
     * @param null   $current_val
     *
     * @return array|float|mixed|string|string[]
     */
    function zipVarCheck( $var_to_check, $default_value, $checkformat = "", $if_invalid_value = "", $current_val = null ) {

        if ( $current_val != null && $default_value == $current_val ) {
            $y = $current_val;
        } else if ( $current_val != "" && $current_val != null ) {
            $y = $current_val;
        } else {
            if ( isset( $_GET[ $var_to_check ] ) ) {
                $y = $_GET[ $var_to_check ];
            } elseif ( isset( $_POST[ $var_to_check ] ) ) {
                $y = $_POST[ $var_to_check ];
            } elseif ( isset( $_COOKIE[ $var_to_check ] ) ) {
                $y = $_COOKIE[ $var_to_check ];
            } elseif ( isset( $_SESSION[ $var_to_check ] ) ) {
                $y = $_SESSION[ $var_to_check ];
            } else {
                $y = $default_value;
            }
        }
        $checkformat = (string) $checkformat;
        if ( strpos( "$checkformat", "FILTER_VALIDATE_INT" ) !== false ) {
            if ( filter_var( $y, FILTER_VALIDATE_INT ) === 0 || ! filter_var( $y, FILTER_VALIDATE_INT ) === false ) {
                //all okay with $y
            } else {
                $y = $if_invalid_value;
            }
        } else if ( strpos( "$checkformat", "FILTER_VALIDATE_FLOAT" ) !== false ) {
            $y = (float) $y;
            if ( ! filter_var( $y, FILTER_VALIDATE_FLOAT ) ) {
                $y = $if_invalid_value;
            }
        } else if ( strpos( "$checkformat", "FILTER_VALIDATE_DATE" ) !== false ) {
            if ( ! validateDate( $y, TEXT_ZIPUR_COMM_DATE_FORMAT2 ) ) {
                $y = $if_invalid_value;
            }
            //double check date length as weird values like 08/14/-18343974928 return true
            if ( strlen( $y ) != '10' ) {
                $y = $if_invalid_value;
            }

        } else if ( strpos( "$checkformat", "FILTER_VALIDATE_EMAIL" ) !== false ) {
            if ( ! filter_var( $y, FILTER_VALIDATE_EMAIL ) ) {
                $y = $if_invalid_value;
            }
        } else if ( strpos( "$checkformat", "FILTER_VALIDATE_URL" ) !== false ) {
            if ( ! filter_var( $y, FILTER_VALIDATE_URL ) ) {
                $y = $if_invalid_value;
            }
        } else if ( strpos( "$checkformat", "FILTER_VALIDATE_ARRAY" ) !== false ) {
            if ( ! is_array( $y ) ) {
                if ( is_array( $if_invalid_value ) ) {
                    $y = $if_invalid_value;
                } else {
                    $y = [ $if_invalid_value ];
                }
            }
        }

        return $y;
    }

    /**
     * @param        $date
     * @param string $format
     *
     * @return bool
     */
    function validateDate( $date, $format ) {

        $timezone = date_default_timezone_get();
        $d        = DateTime::createFromFormat( $format, $date, new DateTimeZone( $timezone ) );

        return $d && $d->format( $format ) == $date;
    }

    /**
     * @param        $text
     * @param        $class
     * @param        $link
     * @param string $icon
     * @param string $size
     * @param string $id
     *
     * @return string
     */
    function zipButton( $text, $class, $link, $icon = '', $size = 'lg', $id = '', $params = [] ) {

        $buttoncode = '';

        $extrahtml = '';
        if ( ! empty( $id ) ) {
            $extrahtml .= 'id="' . $id . '"';
        }

        if ( $link == 'submit' ) {
            $buttoncode .= '<button class="p-1 pr-4 mr-3 btn btn-' . $size . ' btn-' . $class . '" ' . $extrahtml . '>';
            if ( ! empty( $icon ) ) {
                $buttoncode .= '<i class="pr-2 pl-2 mr-1 fas ' . $icon . '"></i> ';
            }
            $buttoncode .= $text . '</button>';
        } else {
            $buttoncode .= '<a ' . $extrahtml . ' class="m-2 mr-4 pr-4 pl-2 btn btn-' . $size . ' btn-' . $class;
            $buttoncode .= '" href="' . $link . '"';
            if ( ! empty( $params ) ) {
                foreach ( $params as $key => $val ) {
                    $buttoncode .= ' data-' . $key . '="' . $val . '"';
                }
            }
            $buttoncode .= '>';
            if ( ! empty( $icon ) ) {
                $buttoncode .= '<i class="pr-2 pl-2 mr-1 fas ' . $icon . '"></i> ';
            }
            $buttoncode .= $text;
            $buttoncode .= '</a>';
        }

        return $buttoncode;
    }

    /**
     * @param        $rowdata
     * @param int    $padding
     * @param string $style
     * @param string $id
     * @param string $class
     */
    function zipurRow( $rowdata, $padding = 2, $style = '', $id = '', $class = '' ) {

        $leftdata  = '';
        $rightdata = '';

        if ( empty( $rowdata[1] ) ) {
            $rowdata[1] = [];
        }

        if ( empty( $rowdata[0]['text'] ) ) {
            $rowdata[0]['text'] = '';
        }

        if ( empty( $rowdata[1]['text'] ) ) {
            $rowdata[1]['text'] = '';
        }

        if ( empty( $rowdata[1]['field'] ) ) {
            $rowdata[1]['field'] = '';
        }

        if ( $rowdata[0]['text'] !== '' ) {
            $leftdata .= $rowdata[0]['text'];
            $leftdata .= ( substr( $rowdata[0]['text'], - 1 ) != '?' ) ? ':' : '';
        }
        if ( $rowdata[1]['text'] !== '' ) {
            $rightdata .= $rowdata[1]['text'];
        }
        if ( $rowdata[1]['field'] !== '' ) {
            $rightdata .= $rowdata[1]['field'];
        }

        $extrahtml = '';

        $style .= 'max-width: 100%; oveflow: hidden;';
        if ( ! empty( $style ) ) {
            $extrahtml .= ' style="' . $style . '" ';
        }
        if ( ! empty( $id ) ) {
            $extrahtml .= ' id="' . $id . '" ';
        }

        echo '<div class="form-group row pt-' . $padding . ' pb-' . $padding . ' ' . $class . '" ' . $extrahtml . '>';
        if ( $leftdata !== '' ) {
            echo '<label class="text-bold col-sm-4 text-left text-sm-right">' . $leftdata . '</label>';
            echo '<div class="col-sm-8">' . $rightdata . '</div>';

        } else if ( $rightdata !== '' ) {
            echo '<div class="col-sm-12">' . $rightdata . '</div>';
        }
        echo '</div>';
        ?>

        <?php

    }

    /**
     * @param        $type
     * @param        $name
     * @param        $value
     * @param array  $options
     * @param string $class
     * @param string $id
     * @param string $onchange
     * @param string $dataafter
     * @param int    $hideoptionall
     * @param string $placeholder
     * @param int    $passwordtoggle
     *
     * @return string
     */
    function zipField( $type, $name, $value, $options = [], $class = '', $id = '', $onchange = '', $dataafter = '', $hideoptionall = 0, $placeholder = '', $passwordtoggle = 0 ) {

        global $jslines;

        $fieldreturn = '';
        if ( empty( $id ) ) {
            $id = $name;
        }
        if ( $type == 'select' ) {
            $fieldreturn .= '<select name="' . $name . '" id="' . $id . '"';
            if ( ! empty( $class ) ) {
                $fieldreturn .= ' class="' . $class . '"';
            }
            if ( ! empty( $onchange ) ) {
                $fieldreturn .= ' onChange="' . $onchange . '"';
            }
            $fieldreturn  .= ' style="width: auto;">';
            $lastoptgroup = '';
            foreach ( $options as $option ) {
                if ( ! empty( $option['optgroup'] ) ) {
                    if ( $lastoptgroup != $option['optgroup'] ) {
                        if ( ! empty( $lastoptgroup ) ) {
                            $fieldreturn .= '</optgroup>';
                        }
                        $fieldreturn  .= '<optgroup label="' . $option['optgroup'] . '">';
                        $lastoptgroup = $option['optgroup'];
                    }
                }
                $fieldreturn .= '<option value="' . $option['value'] . '"';
                if ( $value == $option['value'] ) {
                    $fieldreturn .= ' SELECTED';
                }

                foreach ( $option as $keydat => $optiondat ) {
                    if ( $keydat != 'value' && $keydat != 'optgroup' && $keydat != 'text' ) {
                        $fieldreturn .= ' data-' . $keydat . '="' . $optiondat . '"';
                    }
                }

                $fieldreturn .= '>' . $option['text'] . '</option>';

            }
            if ( ! empty( $lastoptgroup ) ) {
                $fieldreturn .= '</optgroup>';
            }
            $fieldreturn .= '</select>';
        } else if ( $type == 'date' ) {
            $datedisplayformat = ( ZIPUR_PRODUCT_MANAGER_DATE_FORMAT3 == 'yy-mm-dd' ) ? 'YYYY-MM-DD' : ZIPUR_PRODUCT_MANAGER_DATE_FORMAT3;

            $fieldreturn .= '<input name="' . $name . '" id="' . $id . '" value="' . $value . '" size="12" maxlength="10" /><br/><small>' . $datedisplayformat . '</small>';
            if ( $id == 'enddate' ) {
                if ( strpos( $jslines, 'startdate' ) !== false ) {
                    $jslines = str_replace( 'startdate', 'startdate_off', $jslines );
                    $jslines .= '$("#startdate").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 2, dateFormat: "' . ZIPUR_PRODUCT_MANAGER_DATE_FORMAT3 . '",
                    showButtonPanel: true,
                    onClose: function (selectedDate) {
                        $("#enddate").datepicker("option", "minDate", selectedDate, selectedDate);
                    }
                });
                $("#enddate").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 2, dateFormat: "' . ZIPUR_PRODUCT_MANAGER_DATE_FORMAT3 . '",
                    showButtonPanel: true,
                    onClose: function (selectedDate) {
                        $("#startdate").datepicker("option", "maxDate", selectedDate);
                    }
                });' . PHP_EOL;

                } else {
                    $jslines .= '$("#' . $id . '").datepicker({changeMonth: true, changeYear: true, showButtonPanel: true, dateFormat: "' . ZIPUR_PRODUCT_MANAGER_DATE_FORMAT3 . '"});' . PHP_EOL;
                }
            } else {
                $jslines .= '$("#' . $id . '").datepicker({changeMonth: true, changeYear: true, showButtonPanel: true, dateFormat: "' . ZIPUR_PRODUCT_MANAGER_DATE_FORMAT3 . '"});' . PHP_EOL;

            }
        } else if ( $type == 'text' || $type == 'password' || $type = 'checkbox' ) {

            if ( ! empty( $passwordtoggle ) ) {
                $fieldreturn .= '<div class="input-group show_hide_password">';
            }

            $extrahtml = '';
            if ( ! empty( $onchange ) ) {
                $extrahtml .= ' onChange="' . $onchange . '"';
            }
            if ( ! empty( $placeholder ) ) {
                $extrahtml .= ' placeholder="' . $placeholder . '"';
            }

            $readonly = ( $class == 'readonly' ) ? ' readonly' : '';

            if ( $type == 'checkbox' ) {
                if ( $value == 1 ) {
                    $extrahtml .= ' checked="checked"';
                }
                $value = 1;
            }

            $fieldreturn .= '<input type="' . $type . '" onfocus="this.select();" name="' . $name . '" id="' . $id . '" value="' . $value . '" class="' . $class . '" style="" ' . $extrahtml . $readonly . '/>';

            if ( ! empty( $passwordtoggle ) ) {
                $fieldreturn .= '<div class="ml-3 input-group-addon">';
                $fieldreturn .= '<a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>';
                $fieldreturn .= '</div>';
                $fieldreturn .= '</div>';
            }

        } else if ( $type == 'file' ) {

            $fieldreturn .= '<input type="file" name="' . $name . '" id="' . $id . '" value="' . $value . '" class="' . $class . '" style=""/>';
        } else if ( $type == 'textarea' ) {

            $fieldreturn .= '<textarea name="' . $name . '" id="' . $id . '" rows="8" cols="80" class="' . $class . '" style="width: 80%;">';
            $fieldreturn .= $value;
            $fieldreturn .= '</textarea>';
        }

        if ( ! empty( $dataafter ) ) {
            $fieldreturn .= $dataafter;
        }

        return $fieldreturn;
    }

    /**
     * For debugging arrays/objects
     *
     * @param     $arraytoshow
     * @param int $showfullscreen
     */
    function zipShowMe( $arraytoshow, $showfullscreen = 0 ) {

        if ( $showfullscreen == 1 ) {
            echo '<div style="position: fixed; top: 0px; left: 0px; width: 2000px; height: 1000px; overflow: auto;">';
        }
        $newarray = $arraytoshow;

        echo '<pre>';
        var_dump( $newarray );
        echo '</pre>';
        if ( $showfullscreen == 1 ) {
            echo '</div>';
        }
    }

    /**
     * @param        $alerttext
     * @param string $alertclass
     */
    function zipAlert( $alerttext, $alertclass = 'danger' ) {

        ?>
        <div class="alert alert-<?php echo $alertclass; ?> my-2" role="alert">
            <?php echo $alerttext; ?>
        </div>
        <?php
    }

    function zipConfigFileSet() {

        global $inc_directory;

        if ( ! file_exists( $inc_directory . DIRECTORY_SEPARATOR . 'config.php' ) ) {
            touch( $inc_directory . DIRECTORY_SEPARATOR . "config.php" );
            $configfile = fopen( $inc_directory . DIRECTORY_SEPARATOR . "config.php", "w" ) or die( TEXT_ERROR_WRITE_FILE );
            $data = '<?php' . PHP_EOL . PHP_EOL;
            $data .= '$config = [\'init\' => 1,];' . PHP_EOL;
            fwrite( $configfile, $data );
            fclose( $configfile );
        }

    }

    function zipConfigSave() {

        global $config, $inc_directory;

        file_put_contents( $inc_directory . DIRECTORY_SEPARATOR . "config.php", '<?php $config = ' . var_export( $config, true ) . ';' );

        zipAlert( TEXT_SAVED, 'success' );
    }

    /**
     * @param $filename
     *
     * @return string|string[]|null
     */
    function zipGetFileVersion( $filename ) {

        global $inc_directory;

        //get this tool version number from above content block. Dynamically created by Update Creator.
        $getcheckfile  = file_get_contents( $inc_directory . DIRECTORY_SEPARATOR . $filename );
        $checkstartloc = strpos( $getcheckfile, 'Version' );
        $checkendloc   = strpos( $getcheckfile, "\n", $checkstartloc );
        $versiontext   = substr( $getcheckfile, $checkstartloc, $checkendloc - $checkstartloc + 2 );

        return preg_replace( '/[^0-9.]/', '', $versiontext );
    }

    /** Create a nested array from a directory root
     *
     * @param       $path
     * @param array $ignorefolders
     * @param int   $type
     * @param false $convertadmin
     */
    function zipGetDirArray( $path, $ignorefolders = [], $type = 0, $convertadmin = false ) {

        global $installedfiles, $cleancorefiles, $version, $customadminpath, $config;
        $files = scandir( $path );

        foreach ( $files as $file ) {
            if ( $file == '.' || $file == '..' ) {
                //do nothing
            } else if ( is_dir( $path . DIRECTORY_SEPARATOR . $file ) ) {
                if ( ( in_array( basename( $file ), $ignorefolders ) ) ) {
                    //do nothing for ignored folders
                } else {
                    zipGetDirArray( $path . DIRECTORY_SEPARATOR . $file, $ignorefolders, $type, $convertadmin );
                }
            } else {
                if ( ( in_array( basename( $file ), $ignorefolders ) ) ) {
                    //do nothing for ignored files
                } else {

                    //ignore any non-php files for catching patch versions
                    if ( strpos( $file, '.php' ) === false ) {
                        $keypath          = $path . DIRECTORY_SEPARATOR . $file;
                        $cleancorefiles[] = $keypath;
                    }

                }
            }
        }
    }

    /** Create a nested array from a directory root
     *
     * @param       $path
     * @param array $ignorefolders
     * @param int   $type
     * @param false $convertadmin
     */
    function zipGetCoreArray( $path, $ignorefolders = [], $type = 0, $convertadmin = false ) {

        global $installedfiles, $cleancorefiles, $cep_version, $config, $upgradefiles;

        $ds = DIRECTORY_SEPARATOR;

        $files = scandir( $path );

        foreach ( $files as $file ) {
            if ( $file == '.' || $file == '..' ) {
                //do nothing
            } else if ( is_dir( $path . $ds . $file ) ) {
                if ( ( in_array( basename( $file ), $ignorefolders ) ) ) {
                    //do nothing for ignored folders
                } else {
                    zipGetCoreArray( $path . $ds . $file, $ignorefolders, $type, $convertadmin );
                }
            } else {

                $admin_path = str_replace( $config['cep_files']['root'], '', $config['cep_files']['admin'] );

                if ( ( in_array( basename( $file ), $ignorefolders ) ) ) {
                    //do nothing for ignored files
                } else {
                    if ( empty( $type ) ) {
                        $keypath = $path . $ds . $file;
                        $keypath = str_replace( $config['cep_files']['root'], '', $keypath );

                        if ( $convertadmin ) {
                            $keypath = preg_replace( '/^' . $admin_path . $ds, $ds . 'admin', $keypath, 1 );
                        }

                        $filedata = file_get_contents( $path . $ds . $file );
                        $filedata = str_replace( "\r\n", "\n", $filedata );
                        $filedata = preg_replace( "/\/\*.*\*\//s", "", $filedata );

                        $installedfiles[ $keypath ] = hash( 'md5', $filedata );
                        unset( $filedata );

                    } else if ( $type == 1 ) {
                        $keypath = $path . $ds . $file;
                        if ( version_compare( '1.0.8.0', trim( $cep_version ) ) <= 0 ) {
                            $ospath = 'PhoenixCart-';
                        } else {
                            $ospath = 'CE-Phoenix-';
                        }

                        $keypath = str_replace( 'inc' . $ds . 'clean_core' . $ds . $ospath . trim( $cep_version ), '', $keypath );

                        if ( $ds == '\\' ) {
                            $keypath = preg_replace( '/^\\\admin/', $admin_path . '', $keypath, 1 );
                        } else {
                            $keypath = preg_replace( '/^\/admin/', $admin_path . '', $keypath, 1 );
                        }

                        $filedata = file_get_contents( $path . $ds . $file );
                        $filedata = preg_replace( "/\/\*.*\*\//s", "", $filedata );
                        $filedata = str_replace( "\r\n", "\n", $filedata );

                        $cleancorefiles[ $keypath ] = hash( 'md5', $filedata );
                        unset( $filedata );

                    } else if ( $type == 2 ) {

                        //ignore any non-php files for catching patch versions
                        if ( strpos( $file, '.php' ) !== false ) {
                            $keypath          = $path . $ds . $file;
                            $cleancorefiles[] = $keypath;
                        }

                    } else if ( $type == 3 ) {

                        $keypath        = $path . $ds . $file;
                        $upgradefiles[] = $keypath;

                    }
                }
            }
        }
    }

    /**
     * @param $dirname
     *
     * @return bool
     */
    function zipDeleteDirectory( $dirname ) {

        $dirname = str_replace( '/', DIRECTORY_SEPARATOR, $dirname );

        if ( is_dir( $dirname ) ) {
            $dir_handle = opendir( $dirname );
        } else {
            return false;
        }
        /** @noinspection PhpAssignmentInConditionInspection */
        while ( $file = readdir( $dir_handle ) ) {
            if ( $file != "." && $file != ".." ) {
                if ( ! is_dir( $dirname . DIRECTORY_SEPARATOR . $file ) ) {
                    unlink( $dirname . DIRECTORY_SEPARATOR . $file );
                } else {
                    zipDeleteDirectory( $dirname . DIRECTORY_SEPARATOR . $file );
                }
            }
        }
        closedir( $dir_handle );
        rmdir( $dirname );

        return true;
    }

    /**
     * @param $version
     *
     * @return array
     */
    function loadUpgradeVersion( $version ) {

        global $config, $upgradefiles;

        $ds = DIRECTORY_SEPARATOR;

        $upgrade              = [];
        $upgrades             = 'inc' . $ds . 'versions' . $ds . $version . $ds;
        $upgrade['exists']    = false;
        $upgrade['conflict']  = false;
        $upgrade['installed'] = false;

        //if ( file_exists( $upgrades ) && file_exists( $upgrades . 'upgrade.php' ) ) {
        if ( file_exists( $upgrades ) ) {
            
            if (! file_exists( $upgrades . 'upgrade.php' ) ) {

                fetchUpgradeFiles( $version );
            }

            if ( file_exists( $upgrades . 'upgrade.php' ) ) {

                $upgrade['exists']    = true;
                $upgrade['conflict']  = false;
                $upgrade['installed'] = false;

                require( $upgrades . 'upgrade.php' );

                $upgrade['settings'] = $this_upgrade;

                if ( empty( $upgrade['settings']['title'] ) ) {
                    $upgrade['settings']['title'] = 'Upgrade to ' . $version;
                }
                if ( empty( $upgrade['settings']['delete'] ) ) {
                    $upgrade['settings']['delete'] = [];
                }

                if ( empty( $upgrade['settings']['disable'] ) ) {
                    $upgrade['settings']['disable'] = [];
                }

                if ( empty( $upgrade['settings']['enable'] ) ) {
                    $upgrade['settings']['enable'] = [];
                }

                if ( ! empty( $upgrade['settings']['sql'] ) ) {
                    $upgrade['sql'] = true;
                } else {
                    $upgrade['sql'] = false;
                }

                if ( file_exists( $upgrades . 'files' ) ) {
                    $upgrade['files'] = true;

                    $exclude      = [ 'install', ];
                    $upgradefiles = [];
                    zipGetCoreArray( 'inc' . $ds . 'versions' . $ds . $version . $ds . 'files', $exclude, 3 );
                    $upgrade['upgrade_files'] = $upgradefiles;

                } else {
                    $upgrade['files'] = false;
                }

            } else {
                error_log( 'Upgrade file for version ' . $version . ' is missing.' );
            }

        } else {
            error_log( 'Upgrade directory for version ' . $version . ' is missing.' );
        }

        return $upgrade;

    }

    /**
     * @param       $upgrade
     * @param       $config
     * @param false $process
     */
    function showUpgrade( &$upgrade, &$config, $process = false ) {

        global $next_version, $admin_folder, $db, $output_buffer;

        $ds = DIRECTORY_SEPARATOR;

        if ( $upgrade['exists'] ) {
            if ( $process ) {
                $upgrade['installed'] = true;
            }

            echo '<hr/>';
            echo '<h4>' . $upgrade['settings']['title'] . '</h4>';

            if ( ! empty( $upgrade['settings']['notes'] ) && ! $process ) {
                echo '<div class="alert alert-warning" role="alert"> <i class="fas fa-exclamation-triangle fa-3x" style="display: inline-block; float: left; margin: 0px 2rem 1rem 0px;"></i> ';
                echo $upgrade['settings']['notes'];
                echo '</div>';

            }

            zipAlert( TEXT_NOT_SAFE_LEGEND);
            zipAlert( TEXT_SAFE_LEGEND, 'success');


            if ( "{$next_version}" == '1.0.7.7' ) {
                $upgrade['exists'] = setConfigs1077( $process );
            }

            $modules = [];
            echo '<ul class="list-group mt-4">';
            if ( ! empty( $upgrade['settings']['disable'] ) ) {

                foreach ( $upgrade['settings']['disable'] as $disable ) {

                    $query      = mysqli_query( $db, "SELECT COALESCE(COUNT(configuration_id),0) AS x FROM configuration WHERE configuration_key LIKE '{$disable['key']}%';" );
                    $has_module = mysqli_fetch_array( $query, MYSQLI_ASSOC );

                    $skip_text = '';
                    if ( empty( $has_module['x'] ) ) {
                        $skip_text                    = ' (' . TEXT_SKIP_NOT_USED . ')';
                        $modules["{$disable['key']}"] = 2;
                    } else {
                        $modules["{$disable['key']}"] = 1;

                        if ( $process && ! empty( $disable['key'] ) ) {
                            $query     = mysqli_query( $db, "DELETE FROM configuration WHERE configuration_key LIKE '{$disable['key']}%';" );
                            $skip_text .= ' (' . TEXT_REMOVED_MODULE . ')';
                        }

                    }

                    echo '<li class="list-group-item align-middle alert alert-warning" style="padding: 2px 8px;"><i class="fas fa-puzzle-piece"></i> ' . TEXT_DISABLE_MODULE . ' : ' . $disable['name'] . $skip_text . '</li>';

                    if ( ! empty( $output_buffer ) ) {
//                        flush();
//                        ob_flush();
                    }
                }

            } else {
                echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-puzzle-piece"></i> ' . TEXT_NO_DISABLE_CHANGES . '</li>';
            }
            echo '</ul>';

            if ( ! empty( $output_buffer ) ) {
//                flush();
//                ob_flush();
            }

            echo '<ul class="list-group mt-4">';
            if ( ! empty( $upgrade['sql'] ) ) {

                try {

                foreach ( $upgrade['settings']['sql'] as $sql_datum ) {

                    $icon = '';
                    //&& empty( $upgrade['conflict'] ) && ! empty( $upgrade['installed'] )
                    if ( $process ) {

                        if ( ! empty( $sql_datum['check_key'] ) ) {
                            $query = mysqli_query( $db, "DELETE FROM configuration WHERE configuration_key = '{$sql_datum['check_key']}';" );
                        }

                        //error_log("SQL statement: '{$sql_datum['action']}'");
                        //error_log("escaped SQL statement: '" . mysqli_real_escape_string( $db, $sql_datum['action'] ) . "'");
                        //$query = mysqli_query( $db, mysqli_real_escape_string( $db, $sql_datum['action'] ) );
                        $query = mysqli_query( $db, $sql_datum['action'] );

                        $icon  = ' <i class="fas fa-check text-success"></i> ';

                    }

                    echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-database"></i> ' . $icon . '<small>' . $sql_datum['action'] . '</small></li>';
                }

                } catch ( mysqli_sql_exception $e ) {
                    echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-database"></i> <span class="text-danger">' . TEXT_SQL_ERROR . '</span><br/><small>' . $e->getMessage() . '</small></li>';
                    error_log( 'SQL error during upgrade: ' . $e->getMessage() . "\n" . 'Offending SQL: ' . $sql_datum['action'] );
                    $upgrade['installed'] = false;
                    // don't do any more on this update to support resolve and rerun
                    return; 
                }

            } else {
                echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-database"></i> ' . TEXT_NO_DATABASE_CHANGES . '</li>';
            }
            echo '</ul>';

            if ( ! empty( $output_buffer ) ) {
//                flush();
//                ob_flush();
            }

            echo '<ul class="list-group mt-4">';

            if ( ! empty( $upgrade['upgrade_files'] ) ) {

                foreach ( $upgrade['upgrade_files'] as $upgrade_file ) {

                    $upgrade_file_short = str_replace( 'inc' . $ds . 'versions' . $ds . $next_version . $ds . 'files', '', $upgrade_file );

                    if ( $ds == '\\' ) {
                        $upgrade_file_short = preg_replace( "/^\\\admin/", $ds . $admin_folder, $upgrade_file_short );
                    } else {
                        $upgrade_file_short = preg_replace( "/^\/admin/", '/' . $admin_folder, $upgrade_file_short );
                    }

                    if ( ! $process ) {

                        $tag = '<div class="alert alert-success" role="alert" style="display: inline-block; padding: 2px 1rem; width: auto; margin: 0px 1rem;">' . TEXT_SAFE . '</div>';

                        foreach ( $config['core_changed_files'] as $key => $file ) {
                            if ( "{$file}" == "{$upgrade_file_short}" ) {
                                $tag                 = '<div class="alert alert-danger" role="alert" style="display: inline-block; padding: 2px 1rem; width: auto; margin: 0px 1rem;">' . TEXT_NOT_SAFE . '</div>';
                                $upgrade['conflict'] = true;
                            }
                        }

                        echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-file-alt"></i> ' . $tag . ' ' . $upgrade_file_short . '</li>';

                    } else {


                        foreach ( $config['core_changed_files'] as $key => $file ) {
                            if ( "{$file}" == "{$upgrade_file_short}" ) {
                                //remove from future warnings as file is now replaced by core of this version
                                unset($config['core_changed_files'][$key]);
                            }
                        }

                        $from_file = $upgrade_file;
                        $to_file   = $config['cep_files']['root'] . '' . $upgrade_file_short;

                        $target      = pathinfo( $to_file );
                        $extra_label = '';

                        if ( ! file_exists( $target['dirname'] ) ) {
                            $extra_label = '<br/><small>' . TEXT_CREATE_DIR . ' : ' . $target['dirname'] . '</small>';
                            mkdir( $target['dirname'], 0755, true );
                        }

                        copy( $upgrade_file, $to_file );

                        $filedata_1 = file_get_contents( $upgrade_file );
                        $filedata_1 = hash( 'md5', $filedata_1 );

                        $filedata_2 = file_get_contents( $to_file );
                        $filedata_2 = hash( 'md5', $filedata_2 );

                        if ( $filedata_1 == $filedata_2 ) {
                            $tag = '<div class="alert alert-success" role="alert" style="display: inline-block; padding: 2px 1rem; width: auto; margin: 0px 1rem;">' . TEXT_COPIED . '</div> ';
                        } else {
                            $tag                  = '<div class="alert alert-danger" role="alert" style="display: inline-block; padding: 2px 1rem; width: auto; margin: 0px 1rem;">' . TEXT_COPY_FAILED . '</div> ';
                            $upgrade['installed'] = false;
                        }

                        $label = $extra_label . '<br/><small><i class="far fa-copy"></i> ' . $upgrade_file . ' <i class="fas fa-arrow-right"></i> ';
                        $label .= $to_file . '</small>';

                        unset( $filedata_1 );

                        echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-file-alt"></i> ' . $tag . $upgrade_file_short . ' ' . $label . '</li>';

                    }

                    if ( ! empty( $output_buffer ) ) {
//                        flush();
//                        ob_flush();
                    }

                }
            } else {
                echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-file-alt"></i> ' . TEXT_NO_FILE_CHANGES . '</li>';

            }
            echo '</ul>';

            if ( ! empty( $output_buffer ) ) {
//                flush();
//                ob_flush();
            }

            echo '<ul class="list-group mt-4">';
            if ( ! empty( $upgrade['settings']['delete'] ) ) {
                foreach ( $upgrade['settings']['delete'] as $delete ) {

                    $delete_info = '';

                    //force leading slash
                    if ( $delete[0] != $ds ) {
                        $delete = $ds . $delete;
                    }

                    if ( $ds == '\\' ) {
                        $delete   = str_replace( '/', $ds, $delete );
                        $filename = preg_replace( "/^\\\admin/", $ds . $admin_folder, $delete );
                    } else {
                        $filename = preg_replace( "/^\/admin/", '/' . $admin_folder, $delete );
                    }

                    $filename = $config['cep_files']['root'] . $filename;

                    $icon = '';

                    if ( file_exists( $filename ) ) {
                        if ( is_dir( $filename ) ) {
                            $icon = '<i class="far fa-folder-open"></i>';
                            if ( $process ) {
                                zipDeleteDirectory( $filename );
                                if ( ! file_exists( $filename ) ) {
                                    $icon .= ' <i class="fas fa-check text-success"></i> ';
                                } else {
                                    $icon .= TEXT_DELETE_FAILED . ' <i class="fas fa-exclamation-triangle text-danger"></i> ';
                                }
                            }
                        } else {

                            if ( "{$next_version}" == '1.0.7.9' && $delete == '/user.css') {
                                //user.css - special rule
                                $icon = '<i class="fab fa-css3-alt"></i> MOVE NOT ';
                                if ( $process ) {
                                    $filename_to = str_replace( $filename, '.css', '.backup.css');
                                    $to_file   = $config['cep_files']['root'] . '/templates/default/static/user.css';
                                    copy( $filename, $to_file );
                                    rename( $filename, $filename_to );
                                    if (  file_exists( $filename_to ) ) {
                                        $icon .= ' <i class="fas fa-check text-success"></i> ';
                                    } else {
                                        $icon .= TEXT_MOVE_FAILED . ' <i class="fas fa-exclamation-triangle text-danger"></i> ';
                                    }
                                }
                            } else {

                                $icon = '<i class="far fa-file-alt"></i>';
                                if ( $process ) {
                                    unlink( $filename );
                                    if ( ! file_exists( $filename ) ) {
                                        $icon .= ' <i class="fas fa-check text-success"></i> ';
                                    } else {
                                        $icon .= TEXT_DELETE_FAILED . ' <i class="fas fa-exclamation-triangle text-danger"></i> ';
                                    }
                                }

                            }
                        }
                    } else {
                        $delete_info .= '<br/>(' . TEXT_DELETE_NOT_NEEDED . ')';
                    }

                    if ( $process ) {

                    }

                    echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-trash-alt"></i> ' . $icon . ' ' . TEXT_DELETE . ' - <small>' . $filename . $delete_info . '</small></li>';

                    if ( ! empty( $output_buffer ) ) {
//                        flush();
//                        ob_flush();
                    }

                }
            } else {
                echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-trash-alt"></i> ' . TEXT_NO_DELETE_CHANGES . '</li>';
            }
            echo '</ul>';

            if ( ! empty( $output_buffer ) ) {
//                flush();
//                ob_flush();
            }

            echo '<ul class="list-group mt-4 mb-4">';
            if ( ! empty( $upgrade['settings']['enable'] ) ) {
                foreach ( $upgrade['settings']['enable'] as $enable ) {

                    $skip_text = '';
                    if ( ! empty( $modules["{$enable['key']}"] ) ) {
                        if ( $modules["{$enable['key']}"] == 1 ) {
                            $skip_text = '<br/>(' . TEXT_REENABLE_MOD . ')';
                        } else if ( $modules["{$enable['key']}"] == 2 ) {
                            $skip_text = '<br/>(' . TEXT_REENABLE_MOD_NO . ')';
                        }
                    }

                    $extra_class = ( $enable['force'] ) ? 'alert-danger' : 'alert-warning';
                    $extra_text = ( $enable['force'] ) ? '!!REQUIRED!! ' : '';

                    echo '<li class="list-group-item align-middle alert ' . $extra_class . '" style="padding: 2px 8px;"><i class="fas fa-puzzle-piece"></i> ' . $extra_text . TEXT_ENABLE_MODULE . ' : ' . $enable['name'] . $skip_text . '</li>';

                }
            } else {
                echo '<li class="list-group-item align-middle" style="padding: 2px 8px;"><i class="fas fa-puzzle-piece"></i> ' . TEXT_NO_ENABLE_CHANGES . '</li>';
            }
            echo '</ul>';



            if ( ! empty( $output_buffer ) ) {
//                flush();
//                ob_flush();
            }

        } else {

            zipAlert( TEXT_UPGRADE_BROKEN );

        }
    }

    /**
     * @param $process
     *
     * @return bool
     */
    function setConfigs1077( $process ) {

        global $admin_folder;
        $ds = DIRECTORY_SEPARATOR;

        $secure = ( ENABLE_SSL ) ? "'secure' => true," : '';

        $http_server = ( ENABLE_SSL || ! empty( HTTPS_SERVER ) ) ? HTTPS_SERVER : HTTP_SERVER;

        $catalog = ( ENABLE_SSL ) ? DIR_WS_HTTPS_CATALOG : DIR_WS_HTTP_CATALOG;

        if ( defined( 'CFG_TIME_ZONE' ) ) {
            $time_zone = '\'' . CFG_TIME_ZONE . '\'';
        } else {
            $time_zone = 'date_default_timezone_get()';
        }

        $sessionstring = '';
        if ( defined( 'STORE_SESSIONS' ) ) {
            if ( 'mysql' !== STORE_SESSIONS && ! empty( STORE_SESSIONS ) && defined( 'SESSION_WRITE_DIRECTORY' ) ) {
                $sessionstring = "const DIR_FS_SESSION = '" . SESSION_WRITE_DIRECTORY . "';\n";
            }
        }

        $stream = fopen( 'inc' . $ds . 'versions' . $ds . '1.0.7.7' . $ds . 'base_configure.php', "r" );
        $base   = stream_get_contents( $stream );
        fclose( $stream );

        $stream = fopen( 'inc' . $ds . 'versions' . $ds . '1.0.7.7' . $ds . 'admin_configure.php', "r" );
        $admin  = stream_get_contents( $stream );
        fclose( $stream );



        $base = str_replace( "<?php", '', $base );
        $base = str_replace( "--error_reporting--", error_reporting(), $base );
        $base = str_replace( "--HTTP_SERVER--", $http_server, $base );
        $base = str_replace( "--cookie-domain--", HTTP_COOKIE_DOMAIN, $base );
        $base = str_replace( "--cookie-path--", HTTP_COOKIE_PATH, $base );
        $base = str_replace( "--secure--", $secure, $base );
        $base = str_replace( "--DIR_WS_CATALOG--", $catalog, $base );
        $base = str_replace( "--DIR_FS_CATALOG--", DIR_FS_CATALOG, $base );
        $base = str_replace( "--date_default_timezone_set--", $time_zone, $base );
        $base = str_replace( "--session--", $sessionstring, $base );
        $base = str_replace( "--DB_SERVER--", DB_SERVER, $base );
        $base = str_replace( "--DB_SERVER_USERNAME--", DB_SERVER_USERNAME, $base );
        $base = str_replace( "--DB_SERVER_PASSWORD--", DB_SERVER_PASSWORD, $base );
        $base = str_replace( "--DB_DATABASE--", DB_DATABASE, $base );

        $admin = str_replace( "<?php", '', $admin );
        $admin = str_replace( "--error_reporting--", error_reporting(), $admin );
        $admin = str_replace( "--HTTP_SERVER--", $http_server, $admin );
        $admin = str_replace( "--cookie-domain--", HTTP_COOKIE_DOMAIN, $admin );
        $admin = str_replace( "--cookie-path--", HTTP_COOKIE_PATH . $admin_folder, $admin );
        $admin = str_replace( "--secure--", $secure, $admin );
        $admin = str_replace( "--DIR_WS_ADMIN--", $catalog . $admin_folder . $ds, $admin );
        $admin = str_replace( "--DIR_FS_DOCUMENT_ROOT--", DIR_FS_CATALOG, $admin );
        $admin = str_replace( "--DIR_FS_ADMIN--", DIR_FS_CATALOG . $admin_folder . $ds, $admin );
        $admin = str_replace( "--HTTP_CATALOG_SERVER--", $http_server, $admin );
        $admin = str_replace( "--DIR_WS_CATALOG--", $catalog, $admin );
        $admin = str_replace( "--DIR_FS_CATALOG--", DIR_FS_CATALOG, $admin );
        $admin = str_replace( "--date_default_timezone_set--", $time_zone, $admin );
        $admin = str_replace( "--session--", $sessionstring, $admin );
        $admin = str_replace( "--DB_SERVER--", DB_SERVER, $admin );
        $admin = str_replace( "--DB_SERVER_USERNAME--", DB_SERVER_USERNAME, $admin );
        $admin = str_replace( "--DB_SERVER_PASSWORD--", DB_SERVER_PASSWORD, $admin );
        $admin = str_replace( "--DB_DATABASE--", DB_DATABASE, $admin );

        $ok_to_proceed = 1;
        $track_error   = [];
        $php_topper    = '?php' . "\n\n";

        if ( ! file_exists( DIR_FS_CATALOG . 'includes' . $ds . 'configure.php' ) ) {
            $ok_to_proceed = 0;
            $track_error[] = 'MISSING: ' . DIR_FS_CATALOG . 'includes' . $ds . 'configure.php';
        } else {
            chmod( DIR_FS_CATALOG . 'includes' . $ds . 'configure.php', 0644 );
        }
        if ( ! file_exists( DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure.php' ) ) {
            $ok_to_proceed = 0;
            $track_error[] = 'MISSING: ' . DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure.php';
        } else {
            chmod( DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure.php', 0644 );
        }

        file_put_contents( DIR_FS_CATALOG . 'includes' . $ds . 'configure_1077.php', '<' . $php_topper . $base );

        file_put_contents( DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure_1077.php', '<' . $php_topper . $admin );

        if ( ! file_exists( DIR_FS_CATALOG . 'includes' . $ds . 'configure_1077.php' ) ) {
            $ok_to_proceed = 0;
            $track_error[] = 'COULD NOT CREATE: ' . DIR_FS_CATALOG . 'includes' . $ds . 'configure_1077.php';
        }
        if ( ! file_exists( DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure_1077.php' ) ) {
            $ok_to_proceed = 0;
            $track_error[] = 'COULD NOT CREATE: ' . DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure_1077.php';
        }

        if ( $process ) {
            rename( DIR_FS_CATALOG . 'includes' . $ds . 'configure.php', DIR_FS_CATALOG . 'includes' . $ds . 'configure_backup_before_1077.php' );
            rename( DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure.php', DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure_backup_before_1077.php' );
            copy( DIR_FS_CATALOG . 'includes' . $ds . 'configure_1077.php', DIR_FS_CATALOG . 'includes' . $ds . 'configure.php' );
            copy( DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure_1077.php', DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure.php' );

            chmod( DIR_FS_CATALOG . 'includes' . $ds . 'configure.php', 0444 );
            chmod( DIR_FS_CATALOG . $admin_folder . $ds . 'includes' . $ds . 'configure.php', 0444 );

        }

        if ( ! empty( $track_error ) ) {
            foreach ( $track_error as $item ) {
                zipAlert( $item );
            }

            return false;
        } else {
            return true;
        }

    }
    
    /**
     * @param string $path, $catalogfile
     *
     * @return array admin menu loc, key
     */
    function moduleDetails( $path, $catalogfile ) {

        $fp = @fopen( $path . $catalogfile, 'r' );
        if ( false === $fp ) {
            throw new Exception( 'File not found: ' . $catalogfile );
        }
        $class_name = $key_prefix = '';
        $i = 0;
        while ( ( $line = fgets( $fp ) ) !== false && $i < 100 && ( empty( $class_name ) || empty( $key_prefix ) ) ) {
            if ( strpos( $line, 'class ' ) !== false ) {
                $class_name = rtrim( explode( ' ', trim( str_replace( [ 'class ' ], '', $line ) ) )[0], '{' );
            }
            if ( strpos( $line, 'CONFIG_KEY_BASE' ) !== false ) {
                $key_prefix = trim( str_replace( [ 'const', 'CONFIG_KEY_BASE', '=', ';' ], '', $line ) );
            }
            $i++;
        }
        fclose( $fp );
        if ( empty( $class_name ) || empty( $key_prefix ) ) {
            throw new Exception( 'Could not find class name or key prefix in file: ' . $catalogfile );
        }
        $module_path = str_replace( ['includes/', basename($catalogfile) ], '', $catalogfile );
        $module_path = 'admin &gt;' . str_replace( '/', ' &gt; ', $module_path ) . $class_name;
        
        return [ 'module_path' => $module_path, 'class_name' => $class_name, 'key_prefix' => $key_prefix ];
    }

    /**
     * @param string $version
     *
     * @return array next version, available updates
     */
    function cartmartCheckVersion( $version ) {

        $return = callCartmart( $version, '' );
        if ( $return['httpcode'] == 200 ) {
            $response = json_decode( $return['response'], true );
            error_log('Cartmart response: ' . print_r($response, true));
            if ( ! empty( $response['next_version'] )  ) {
                return [ $response['next_version'], $response['later'] ?? [] ];
            } else {
                throw new Exception( 'Invalid response from Cartmart: ' . $return['response'] );
            }
        } else {
            throw new Exception( 'Error connecting to Cartmart. HTTP code: ' . $return['httpcode'] );
        }
    }

    /**
     * @param string $version, $action
     *
     * @return array
     */
    function callCartmart( $version, $action ) {

        $url = 'https://cartmart.uk/api/coreupdates/' . $version;
        if (! empty($action)) $url .= '?' . http_build_query($query);
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        $headers[] = 'X-Cartmart-Upgrades-Site: ' .  HTTP_SERVER . DIR_WS_CATALOG;
        $headers[] = 'X-Cartmart-Upgrader-Ver: ' .  $GLOBALS['zipFileVersion'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return ['httpcode' => $httpcode, 'response' => $response, 'curlinfo' => $info];
    }    

    /**
     * @param string $version
     *
     * @return void
     */
    function fetchUpgradeFiles( $version ) {

        $okset = 1;

        $ziparch = class_exists('ZipArchive');
        $version_folder = 'inc/versions/' . $version;
        if ( ! is_dir( $version_folder ) ) {
            throw new Exception( TEXT_VERSION_DIRECTORY_CREATE_FAILED);
        }
        $version_folder .= '/';
        $work_folder = 'inc/update_work';
        if ( ! is_dir( $work_folder ) ) {
            if (! mkdir( $work_folder, 0700, true ) ) {
                throw new Exception( TEXT_WORK_DIRECTORY_CREATE_FAILED);
            }
        } else {
            // clean up any old stuff in work folder
            $files = glob($work_folder . '/*'); // get all file names
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // delete file
                } else if ($file != "." && $file != ".." && is_dir($file)) {
                    zipDeleteDirectory($file); // delete directory and its contents
                }
            }
        }
        $work_folder .= '/';

        $version_url = 'https://api.github.com/repos/BrockleyJohn/core_updates/zipball/v' . $version;
        $zipext = $ziparch ? '.zip' : '.tar.gz';
        $version_zip = $work_folder . 'upgrade' . $zipext;

        $fp      = fopen( $version_zip, 'w+' );
        $ch      = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $version_url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'PhoenixUpgrader/' . $GLOBALS['zipFileVersion'] );
        curl_setopt( $ch, CURLOPT_FILE, $fp );
        curl_exec( $ch );
        $info = curl_getinfo($ch);
        curl_close( $ch );
        fclose( $fp );
        error_log('Download info: ' . print_r($info, true));

        if ( $info['http_code'] !== 200 && $info['http_code'] !== 302 || ! file_exists( $version_zip ) ) {
            echo '<span class="text-danger">' . sprintf(TEXT_VERSION_DOWNLOAD_FAILED, $version, $version_url, $version_zip) . '</span>';
            $okset = 0;
        } else {
            echo '<span class="text-success">' . sprintf(TEXT_VERSION_DOWNLOAD_SUCCESS, $version) . '</span>';
            if ($ziparch) {
                $zip = new ZipArchive;
                $res = $zip->open( $version_zip );
                if ( $res === true ) {
                    $zip->extractTo( $work_folder );
                    $zip->close();
                    echo '<br/><span class="text-success">' . sprintf(TEXT_VERSION_UNZIP_SUCCESS, $version) . '</span>';
                    unlink( $version_zip );//deletes downloaded zip
                } else {
                    echo '<br/><span class="text-danger">' . sprintf(TEXT_VERSION_UNZIP_FAILED, $version_zip) . '</span>';
                    $okset = 0;
                }
            } else {
                $gz_extract = new PharData( $version_zip );
                $gz_extract->decompress(); // creates files.tar
                $tar_extract = new PharData( str_replace( '.gz', '', $version_zip ) );
                $tar_extract->extractTo( $work_folder );
                unlink( str_replace( '.gz', '', $version_zip ) );//deletes tar
                unlink( $version_zip );//deletes downloaded zip
                echo '<br/><span class="text-success">' . sprintf(TEXT_VERSION_UNZIP_SUCCESS, $version) . '</span>';
            }
            if ($okset) {
                // Lets get the actual folder name that was extracted (when using github api the folder name is not consistent so we need to find it). Work dir contains only the extracted folder so we should be safe to just get the first folder in there
                $files = scandir($work_folder);
                foreach ($files as $file) {
                    if ($file != "." && $file != ".." && is_dir($work_folder . $file)) {
                        $extracted_folder = $work_folder . $file;
                        break;
                    }
                }
                // the next level should be /versions/ then the version number
                if ( is_dir( $extracted_folder . '/versions/' . $version ) ) {
                    // move the files to the correct location
                    if (! rename( $extracted_folder . '/versions/' . $version, $version_folder ) ) {
                        echo '<br/><span class="text-danger">' . sprintf(TEXT_VERSION_MOVE_FAILED, $version) . '</span>';
                    } else {
                        echo '<br/><span class="text-success">' . sprintf(TEXT_VERSION_MOVE_SUCCESS, $version) . '</span>';
                    }
                } else {
                    echo '<br/><span class="text-danger">' . sprintf(TEXT_VERSION_FOLDER_NOT_FOUND, $extracted_folder . '/versions/' . $version) . '</span>';
                }
            }
        }

        return $okset;
    }        