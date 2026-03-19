<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.6 to 1.0.9.7',
        'requires' => '1.0.9.6',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.0.9.7 release, continuation of 1.0.9.x series. Addition of Bootstrap 5 Template. Addition of Customer Data Hub. Includes an optional sql update to update configs if implementing the Bootstrap 5 Template.',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

