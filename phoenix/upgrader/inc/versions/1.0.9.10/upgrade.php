<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.9 to 1.0.9.10',
        'requires' => '1.0.9.9',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.0.9.10 release, continuing the 1.0.9.* optimisation series.
This releases makes Phoenix Cart more accessible and introduces a new feature "Importers".',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

