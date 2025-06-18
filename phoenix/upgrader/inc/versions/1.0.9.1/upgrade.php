<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.0 to 1.0.9.1',
        'requires' => '1.0.9.0',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [
            [ 'action' => "DELETE FROM hooks WHERE hooks_code = '_04_general';" ],
            [ 'action' => "DELETE FROM hooks WHERE hooks_code = '_05_href_link';" ],
            [ 'action' => "DELETE FROM hooks WHERE hooks_code = '_06_image';" ],
            [ 'action' => "DELETE FROM hooks WHERE hooks_code = '_07_html_output';" ],
            [ 'action' => "DELETE FROM hooks WHERE hooks_code = '_08_sessions';" ],
            [ 'action' => "DELETE FROM hooks WHERE hooks_code = '_25_password_funcs';" ],
        ],
        'notes'    => 'This is the 1.0.9.1 release, the first in the 1.0.9.* optimisation series.',
    ];




