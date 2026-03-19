<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.10 to 1.1.0.0',
        'requires' => '1.0.9.10',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [],
        'notes'    => 'This is the 1.1.0.0 release, making a new development line.

This release makes Phoenix Cart completely Bootstrap 5 with no reliance on jQuery or jQueryUI.
This release also introduces product queries for building lists of products.',
    ];

    $version_dir = __DIR__;

    require_once dirname(__DIR__) .  '/version_upgrade_builder.php';

