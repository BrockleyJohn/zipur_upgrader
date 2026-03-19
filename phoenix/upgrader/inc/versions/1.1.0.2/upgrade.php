<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.1.0.1 to 1.1.0.2',
        'requires' => '1.1.0.1',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.1.0.2 release, continuing the 1.1.0.* optimisation series.',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

