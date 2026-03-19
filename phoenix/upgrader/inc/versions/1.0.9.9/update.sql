UPDATE configuration SET configuration_title = 'Admin Items Per Page', configuration_description = 'Amount of items to list' WHERE configuration_key = 'MAX_DISPLAY_SEARCH_RESULTS';

UPDATE configuration SET configuration_title = 'Display Delivery Cost', configuration_description = 'Do you want to display the order delivery cost?' WHERE configuration_key = 'MODULE_ORDER_TOTAL_SHIPPING_STATUS';

UPDATE configuration SET configuration_title = 'Allow Free Delivery', configuration_description = 'Do you want to allow free delivery?' WHERE configuration_key = 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING';

UPDATE configuration SET configuration_title = 'Free Delivery For Orders Over', configuration_description = 'Provide free delivery for orders over the set amount.' WHERE configuration_key = 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER';

UPDATE configuration SET configuration_title = 'Provide Free Delivery For Orders Made', configuration_description = 'Provide free delivery for orders sent to the set destination.' WHERE configuration_key = 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION';

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('Products Per Page', 'MAX_DISPLAY_PRODUCTS_PER_PAGE', '20', 'Amount of products to list per page', 8, 292, now());

UPDATE configuration SET configuration_group_id = '8', sort_order = '294' WHERE configuration_key = 'MAX_DISPLAY_PAGE_LINKS';

UPDATE configuration SET configuration_description = 'The pages to add the necessary javascript to.' WHERE configuration_key = 'MODULE_HEADER_TAGS_TABLE_CLICK_JQUERY_PAGES';

UPDATE configuration SET configuration_value= 'fab fa-paypal fa-lg,fab fa-cc-visa fa-lg' WHERE configuration_key = 'MODULE_CONTENT_FOOTER_EXTRA_ICONS_DISPLAY';

UPDATE categories SET categories_image = 'sample/fruit.webp' WHERE categories_image = 'sample/fruit.jpg';
UPDATE categories SET categories_image = 'sample/vegetables-1.webp' WHERE categories_image = 'sample/vegetables-1.jpg';
UPDATE categories SET categories_image = 'sample/apples-pears.webp' WHERE categories_image = 'sample/apples-pears.jpg';
UPDATE categories SET categories_image = 'sample/citrus.webp' WHERE categories_image = 'sample/citrus.jpg';

UPDATE products SET products_image = 'sample/orange-1.webp' WHERE products_image = 'sample/orange-1.jpg';
UPDATE products SET products_image = 'sample/lemon-1.webp' WHERE products_image = 'sample/lemon-1.jpg';
UPDATE products SET products_image = 'sample/pear-1.webp' WHERE products_image = 'sample/pear-1.jpg';
UPDATE products SET products_image = 'sample/apple-1.webp' WHERE products_image = 'sample/apple-1.jpg';
UPDATE products SET products_image = 'sample/tomatoes-1.webp' WHERE products_image = 'sample/tomatoes-1.jpg';
UPDATE products SET products_image = 'sample/green-apple-1.webp' WHERE products_image = 'sample/green-apple-1.jpg';
UPDATE products SET products_image = 'sample/grapefruit-1.webp' WHERE products_image = 'sample/grapefruit-1.jpg';
UPDATE products SET products_image = 'sample/lime-1.webp' WHERE products_image = 'sample/lime-1.jpg';
