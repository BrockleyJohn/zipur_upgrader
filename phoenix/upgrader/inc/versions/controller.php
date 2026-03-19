<?php

    $versions   = [];

    /* enough of this hardcoding, let's just get the versions from the directory 
    $versions[] = [ 'version' => '1.0.0.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.0.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.0.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.0.4', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.1.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.1.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.1.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.1.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.1.4', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.2.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.4', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.5', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.6', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.7', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.2.8', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.3.0', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.4.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.4.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.4.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.4.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.4.4', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.4.5', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.5.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.4', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.5', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.6', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.7', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.8', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.9', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.5.10', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.6.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.6.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.6.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.6.3', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.7.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.4', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.5', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.6', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.7', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.9', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.10', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.11', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.12', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.13', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.14', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.15', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.16', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.7.18', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.8.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.4', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.5', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.6', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.7', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.8', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.9', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.10', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.11', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.12', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.13', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.14', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.15', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.16', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.17', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.18', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.19', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.20', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.8.21', 'active' => true, ];

    $versions[] = [ 'version' => '1.0.9.0', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.9.1', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.9.2', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.9.3', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.9.4', 'active' => true, ];
    $versions[] = [ 'version' => '1.0.9.5', 'active' => true, ];
    */
    // get subdirectories of inc/versions/
    $dir = __DIR__ ;
    $subdirs = array_filter(glob($dir . '/*'), 'is_dir');
    foreach ($subdirs as $subdir) {
        $version = basename($subdir);
        if (preg_match('/^\d+\.\d+\.\d+\.\d+$/', $version)) {
            $versions[] = [ 'version' => $version, 'active' => true, ];
        }
    }