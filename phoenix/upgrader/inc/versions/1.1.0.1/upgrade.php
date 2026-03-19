<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.1.0.0 to 1.1.0.1',
        'requires' => '1.1.0.0',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.1.0.1 release, which solves some Bootstrap 5 omissions, re-introduces Paypal and introduces Stripe.',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

