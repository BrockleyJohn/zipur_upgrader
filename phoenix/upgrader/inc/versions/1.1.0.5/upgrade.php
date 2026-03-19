<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.1.0.4 to 1.1.0.5',
        'requires' => '1.1.0.4',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.1.0.5 release, continuing the 1.1.0.* optimisation series.
This release includes bugfixes and general updates. New features: [Admin & Shop] Queued Emails are now i18n',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

