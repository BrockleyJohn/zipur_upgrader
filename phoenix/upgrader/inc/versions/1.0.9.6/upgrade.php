<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.5 to 1.0.9.6',
        'requires' => '1.0.9.5',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.0.9.6 release, continuation of 1.0.9.x series. Addition of new feature Outgoing Emails',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';
    
