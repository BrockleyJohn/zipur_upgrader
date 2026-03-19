<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.7 to 1.0.9.8',
        'requires' => '1.0.9.7',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.0.9.8 release, continuing the 1.0.9.* optimisation series.
This releases introduces PI Modular flexibility to Index Page and to Info Pages.',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

