<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.8.20 to 1.0.8.21',
        'requires' => '1.0.8.20',
        'delete'   => [],
        'disable'  => [],
        'enable'   => [],
        'sql'      => [
            [ 'action' => "ALTER TABLE customers CHANGE customers_dob customers_dob DATETIME NULL DEFAULT '1970-01-01 00:00:01';" ],
            [ 'action' => "UPDATE customers SET customers_dob = NULL WHERE customers_dob = '1970-01-01 00:00:01';" ],
            [ 'action' => "ALTER TABLE customers CHANGE customers_dob customers_dob DATE NULL;" ],
            [ 'action' => "UPDATE configuration SET configuration_description = 'Allow customer to check out even if there is insufficient stock. If set to false, product(s) will be deactivated if stock count drops below 1 when the customer checks out.' WHERE configuration_key = 'STOCK_ALLOW_CHECKOUT';" ],
            [ 'action' => "ALTER TABLE countries ADD status INT NOT NULL DEFAULT '1';" ],
            [ 'action' => "INSERT INTO countries VALUES (250, 'Guernsey', 'GG', 'GGY', '1', '1');" ],
            [ 'action' => "INSERT INTO countries VALUES (251, 'Jersey', 'JE', 'JEY', '1', '1');" ],
            [ 'action' => "INSERT INTO countries VALUES (252, 'Isle of Man', 'IM', 'IMN', '1', '1');" ],
            [ 'action' => "ALTER TABLE customer_data_groups CHANGE customer_data_groups_width customer_data_groups_width VARCHAR(255) NOT NULL;" ],
            [ 'action' => "INSERT INTO hooks (hooks_site, hooks_group, hooks_action, hooks_code, hooks_class, hooks_method) VALUES ('shop', 'logoff', 'resetStart', '_41_unset_customer', 'global_eraser', 'customer');" ],
        ],
        'notes'    => 'This is the 1.0.8.21 release, in the 1.0.8.* series. This is the third release candidate for 1.0.9.0. *** This release will break your store if you have any calls to old tep_ functions. Consult the forums before upgrading if you have any older code in your store and you are uncertain if it supports this version.',
    ];




