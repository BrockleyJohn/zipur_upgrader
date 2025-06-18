<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.4 to 1.0.9.5',
        'requires' => '1.0.9.4',
        'delete'   => [
            '/admin/define_language.php',
            '/admin/includes/boxes/tools_define_language.php',
            '/admin/includes/languages/english/define_language.php',
            '/admin/includes/languages/english/modules/boxes/tools_define_language.php',
            '/includes/languages/english/info_shopping_cart.php',
        ],
        'disable'  => [],
        'enable'   => [
            [
                'name'  => 'admin &gt; modules &gt; content &gt; contact_us Page Heading',
                'key'   => 'MODULE_CONTENT_CU_TITLE_',
                'force' => true,
            ],
            [
                'name'  => 'admin &gt; modules &gt; content &gt; π Modular contact_us',
                'key'   => 'MODULE_CONTENT_CU_MODULAR_',
                'force' => true,
            ],
            [
                'name'  => 'admin &gt; modules &gt; Layout &gt; contact_us Form',
                'key'   => 'CU_FORM_',
                'force' => true,
            ],
            [
                'name'  => 'admin &gt; modules &gt; Layout &gt; contact_us Text',
                'key'   => 'CU_TEXT_',
                'force' => false,
            ],
        ],
        'sql'      => [
            [ 'action' => "INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Store Tax ID', 'STORE_TAX_ID', '', 'This is the Tax ID of my business.', 1, 19, NOW());" ],
            [ 'action' => "INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Display buttons in product listing', 'PRODUCT_LIST_BUTTONS', 'False', 'Do you want to display buy and view buttons in the product listing', 8, 290, 'Config::select_one([\'True\', \'False\'], ', NOW());" ],
            [ 'action' => "UPDATE customer_data_groups SET customer_data_groups_width = 'col-12 col-md-6';" ],
            [ 'action' => "INSERT INTO hooks (hooks_site, hooks_group, hooks_action, hooks_code, hooks_class, hooks_method) VALUES ('shop', 'siteWide', 'injectProductCard', '_10_inject_product_card', '', 'product_card::inject');" ],
            [ 'action' => "INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Background Colour', 'MODULE_HEADER_TAGS_TABLE_CLICK_JQUERY_TR_BACKGROUND', 'table-success', 'The background colour of the clicked Row.  See https://getbootstrap.com/docs/4.6/content/tables/#contextual-classes', 6, 3, now());" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_ACCOUNT_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_CHECKOUT_SUCCESS_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_IN_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_IN_CATEGORY_DESCRIPTION_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_IN_CATEGORY_LISTING_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_IN_CARD_PRODUCTS_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_IP_CATEGORY_DESCRIPTION_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_IP_PRODUCT_LISTING_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_LOGIN_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_SC_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_ACCOUNT_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_TESTIMONIALS_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_CAS_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_INFO_TITLE_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mt-2') WHERE configuration_key = 'MODULE_CONTENT_SC_ORDER_SUBTOTAL_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mt-2') WHERE configuration_key = 'MODULE_CONTENT_SC_STOCK_NOTICE_CONTENT_WIDTH';" ],
        ],
        'notes'    => 'This is the 1.0.9.5 release, continuation of 1.0.9.x series.',
    ];




