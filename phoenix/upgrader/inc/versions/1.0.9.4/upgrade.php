<?php

    $this_upgrade = [
        'title'    => 'Updating Phoenix Cart 1.0.9.3 to 1.0.9.4',
        'requires' => '1.0.9.3',
        'delete'   => [
        ],
        'disable'  => [],
        'enable'   => [
        ],
        'sql'      => [
            [ 'action' => "INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Favicon', 'FAVICON_LOGO', 'favicon.png', 'This is the filename of your Favicon.  This should be updated at admin > configuration > Store Logo', 6, 1200, now());" ],
            [ 'action' => "INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Mini Logo', 'MINI_LOGO', 'mini_logo.png', 'This is the filename of your Mini Logo.  This should be updated at admin > configuration > Store Logo', 6, 1100, now());" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'container-xl' WHERE configuration_key = 'BOOTSTRAP_CONTAINER';" ],
            [ 'action' => "UPDATE configuration SET configuration_title = 'Content Container' WHERE configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_description = 'What container should the content be shown in? (col-*-12 = full width, col-*-6 = half width).' WHERE configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET set_function = NULL WHERE configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-12' WHERE configuration_value = '12' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-11' WHERE configuration_value = '11' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-10' WHERE configuration_value = '10' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-9' WHERE configuration_value = '9' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-8' WHERE configuration_value = '8' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-7' WHERE configuration_value = '7' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-6' WHERE configuration_value = '6' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-5' WHERE configuration_value = '5' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-4' WHERE configuration_value = '4' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-3' WHERE configuration_value = '3' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-2' WHERE configuration_value = '2' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-1' WHERE configuration_value = '1' AND configuration_key LIKE '%_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-2 mb-sm-0') WHERE configuration_key = 'MODULE_CONTENT_FOOTER_INFORMATION_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-2 mb-sm-0') WHERE configuration_key = 'MODULE_CONTENT_FOOTER_ACCOUNT_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-2 mb-sm-0') WHERE configuration_key = 'MODULE_CONTENT_FOOTER_CONTACT_US_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-2 mb-sm-0') WHERE configuration_key = 'MODULE_CONTENT_FOOTER_TEXT_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' text-center text-sm-left') WHERE configuration_key = 'MODULE_CONTENT_FOOTER_EXTRA_COPYRIGHT_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' text-center text-sm-right') WHERE configuration_key = 'MODULE_CONTENT_FOOTER_EXTRA_ICONS_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' my-2') WHERE configuration_key = 'MODULE_CONTENT_CS_CONTINUE_BUTTON_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_CARD_PRODUCTS_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_UPCOMING_PRODUCTS_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mt-5') WHERE configuration_key = 'MODULE_CONTENT_SC_ORDER_SUBTOTAL_CONTENT_WIDTH';" ],
            [ 'action' => "UPDATE configuration SET configuration_title = 'Review Container' WHERE configuration_key = 'MODULE_CONTENT_PRODUCT_INFO_REVIEWS_CONTENT_WIDTH_EACH';" ],
            [ 'action' => "UPDATE configuration SET configuration_description = 'What container should the content be shown in? (col-*-12 = full width, col-*-6 = half width).' WHERE configuration_key = 'MODULE_CONTENT_PRODUCT_INFO_REVIEWS_CONTENT_WIDTH_EACH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-sm-6' WHERE configuration_key = 'MODULE_CONTENT_PRODUCT_INFO_REVIEWS_CONTENT_WIDTH_EACH';" ],
            [ 'action' => "UPDATE configuration SET configuration_title = 'Thumbnail Container' WHERE configuration_key = 'PI_GALLERY_CONTENT_WIDTH_EACH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'col-4 col-sm-6 col-lg-4' WHERE configuration_key = 'PI_GALLERY_CONTENT_WIDTH_EACH';" ],
            [ 'action' => "UPDATE configuration SET configuration_description = 'What container should each thumbnail be shown in? Default:  XS 3 each row, SM/MD 2 each row, LG/XL 3 each row.' WHERE configuration_key = 'PI_GALLERY_CONTENT_WIDTH_EACH';" ],
            [ 'action' => "UPDATE configuration SET configuration_value = 'Schema' WHERE configuration_key = 'MODULE_CONTENT_HEADER_BREADCRUMB_LOCATION';" ],
            [ 'action' => "INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Content Container', 'MODULE_CONTENT_CHECKOUT_SUCCESS_DOWNLOADS_CONTENT_WIDTH', 'col-sm-12', 'What container should the content be shown in? (col-*-12 = full width, col-*-6 = half width).', 6, 2, NOW());" ],
        ],
        'notes'    => 'This is the 1.0.9.4 release, continuation of 1.0.9.x series.<br/><strong>OPTIONAL MODULES TO REMOVE:</strong><br/>YOU WILL NEED TO MANUALLY DISABLE THESE IN THE ADMIN BEFORE DELETING ANY RELATED FILES!<ul>
    <li>includes/modules/content/index/cm_i_title.php</li>
    <li>includes/modules/content/index/cm_i_text_main.php</li>
    <li>includes/modules/content/index/cm_i_customer_greeting.php</li>
    <li>includes/modules/content/header/cm_header_logo.php</li>
    <li>includes/modules/content/header/cm_header_search.php</li>
    <li>includes/modules/boxes/bm_best_sellers.php</li>
    <li>includes/modules/boxes/bm_categories.php</li>
    <li>includes/modules/boxes/bm_currencies.php</li>
    <li>includes/modules/boxes/bm_information.php</li>
    <li>includes/modules/boxes/bm_languages.php</li>
    <li>includes/modules/boxes/bm_manufacturer_info.php</li>
    <li>includes/modules/boxes/bm_manufacturers.php</li>
    <li>includes/modules/boxes/bm_order_history.php</li>
    <li>includes/modules/boxes/bm_product_notifications.php</li>
    <li>includes/modules/boxes/bm_reviews.php</li>
    <li>includes/modules/boxes/bm_search.php</li>
    <li>includes/modules/boxes/bm_shopping_cart.php</li>
    <li>includes/modules/boxes/bm_specials.php</li>
    <li>includes/modules/boxes/bm_whats_new.php</li>
</ul><br/><strong>OPTIONAL MODULES TO INSTALL MANUALLY IN YOUR ADMIN:</strong><ul>
    <li>includes/modules/content/header/cm_header_menu.php</li>
    <li>includes/modules/content/index/cm_i_slider.php</li>
    <li>includes/modules/navbar/nb_search.php</li>
</ul>',
    ];




