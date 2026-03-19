<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.1.0.3 to 1.1.0.4',
        'requires' => '1.1.0.3',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.1.0.4 release, continuing the 1.1.0.* optimisation series.
This release includes bugfixes and security updates and introduces new features in admin to search manufacturers and sort menus. Shop actions are now hooked.',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

