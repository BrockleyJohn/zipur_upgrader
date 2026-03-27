<?php
    // look for json file
    if ( file_exists($version_dir . '/update.json') ) {
        try {
            $json = file_get_contents($version_dir . '/update.json');
            error_log('Got json "' . $json . '" from ' . $version_dir . '/update.json');
            $json = json_decode($json, true);
            if ( is_array($json) ) {

                $zip_cep_root   = zipVarCheck( 'zip_cep_root', '' );
                $upd_root = $version_dir . '/files/';

                if (isset($json['required_files_delete']) && is_array($json['required_files_delete']) && count($json['required_files_delete']) > 0) {
                    $this_upgrade['delete'] = array_merge($this_upgrade['delete'], $json['required_files_delete']);
                }
                if (isset($json['required_folders_delete']) && is_array($json['required_folders_delete']) && count($json['required_folders_delete']) > 0) {
                    $this_upgrade['delete'] = array_merge($this_upgrade['delete'], $json['required_folders_delete']);
                }
                if (isset($json['required_modules_remove']) && is_array($json['required_modules_remove']) && count($json['required_modules_remove']) > 0) {
                    // Preston has written the current disable to require the key prefix... need to get it from the file
                    foreach ($json['required_modules_remove'] as $module) {
                        try {
                            $module_details = moduleDetails( $zip_cep_root, $module);
                            $this_upgrade['disable'][] = [
                                'file' => $module,
                                'name' => $module_details['module_path'],
                                'key' => $module_details['key_prefix'],
                            ];
                        } catch (Exception $e) { // if it's not there already, we can just move on... but log the error just in case
                            error_log('Error processing required_modules_remove for module ' . $module . ': ' . $e->getMessage());
                        }
                    }
                }
                if (isset($json['required_modules_install']) && is_array($json['required_modules_install']) && count($json['required_modules_install']) > 0) {
                    // Preston has written the current disable to require the key prefix... need to get it from the file
                    foreach ($json['required_modules_install'] as $module) {
                        $module_details = moduleDetails( $upd_root, $module);
                        $this_upgrade['enable'][] = [
                            'file' => $module,
                            'name' => $module_details['module_path'],
                            'key' => $module_details['key_prefix'],
                        ];
                    }
                }
                if (isset($json['optional_modules_install']) && is_array($json['optional_modules_install']) && count($json['optional_modules_install']) > 0) {
                    // Preston has written the current disable to require the key prefix... need to get it from the file
                    foreach ($json['optional_modules_install'] as $module) {
                        $module_details = moduleDetails( $upd_root, $module);
                        $this_upgrade['enable'][] = [
                            'file' => $module,
                            'name' => $module_details['module_path'],
                            'key' => $module_details['key_prefix'],
                            'force' => false
                        ];
                    }
                }

                error_log('Update.json file found and processed successfully.');

                if (file_exists($version_dir . '/update.sql')) {
                    $sql = file_get_contents($version_dir . '/update.sql');
                    if ($sql) {
                        $statements = explode(";", $sql);
                        foreach ($statements as $statement) {

                            if (! empty(trim($statement))) {

                                $statement = trim($statement);
                                $this_upgrade['sql'][] = [
                                    'action' => $statement
                                ];

                                //echo("SQL statement: '{$statement}'<br />\n");
                                //echo("escaped SQL statement: '" . mysqli_real_escape_string( $GLOBALS['db'], $statement ) . "'<br />\n");
                            }

                        }
                    } else {
                        error_log('Error reading update.sql: File is empty.');
                    }
                } else {
                    error_log('No update sql file found.');
                }

            } else {
                error_log('Error decoding update.json: Invalid JSON format. Got: ' . print_r($json, true));
                $this_upgrade['exists'] = false;
            }
        
        } catch (Exception $e) {
            error_log('Error reading update.json: ' . $e->getMessage());
            $upgrade['exists'] = false;
        }
    } else {
        error_log('No update.json file found in ' . $version_dir);
        $upgrade['exists'] = false;
    }

//exit('<pre>' . print_r($this_upgrade, true) . '</pre>');
