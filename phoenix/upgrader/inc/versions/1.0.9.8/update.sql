INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Checkout Redirect', 'CHECKOUT_REDIRECT', 'create_account.php', 'At checkout, redirect a new (not logged in) customer to create_account or login page?', 1, 23, 'Config::select_one([\'create_account.php\', \'login.php\'], ', NOW());

UPDATE configuration_group SET visible = 0 WHERE configuration_group_title = 'Cache';

UPDATE configuration SET configuration_value = 'col-sm-6 offset-sm-3' WHERE configuration_key = 'MODULE_CONTENT_LOGIN_FORM_CONTENT_WIDTH';

UPDATE configuration SET configuration_value = 'col-sm-6 offset-sm-3 mt-4' WHERE configuration_key = 'MODULE_CONTENT_CREATE_ACCOUNT_LINK_CONTENT_WIDTH';

UPDATE configuration SET configuration_value = 'col-sm-6 offset-sm-3 mt-2' WHERE configuration_key = 'MODULE_CONTENT_FORGOT_PASSWORD_CONTENT_WIDTH';

UPDATE configuration SET configuration_value = '1500' WHERE configuration_key = 'MODULE_CONTENT_FORGOT_PASSWORD_SORT_ORDER';

UPDATE configuration SET configuration_value = 'bg-light navbar-light bg-body-secondary border-bottom' WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_STYLE_BG';

UPDATE configuration SET configuration_value = 'navbar-expand-sm' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MENU_COLLAPSE';

UPDATE configuration SET configuration_key = 'MODULE_CONTENT_HEADER_MENU_MANUFACTURERS' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MANUFACTURERS';

UPDATE pages SET pages_status = 0 WHERE slug = 'privacy';
UPDATE pages SET pages_status = 0 WHERE slug = 'conditions';
UPDATE pages SET pages_status = 0 WHERE slug = 'shipping';

INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id,sort_order, date_added) VALUES (NULL, 'Installed Modules', 'MODULE_CONTENT_I_INSTALLED', '', 'List of &pi; Index child modules separated by a semi-colon. This is automatically updated. No need to edit.', 6, 0, now());

INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES (NULL, 'Installed Modules', 'MODULE_CONTENT_INFO_INSTALLED', '', 'List of &pi; Info Pages child modules separated by a semi-colon. This is automatically updated. No need to edit.', 6, 0, now());

UPDATE manufacturers SET manufacturers_image = 'brands/fiacre.jpg' WHERE manufacturers_name = 'Fiacre';
UPDATE manufacturers SET manufacturers_image = 'brands/von-peacock.jpg' WHERE manufacturers_name = 'Von Peacock';

UPDATE configuration SET configuration_value = 'col-sm-6 text-center text-sm-left text-sm-start' WHERE configuration_key = 'MODULE_CONTENT_FOOTER_EXTRA_COPYRIGHT_CONTENT_WIDTH';

UPDATE configuration SET configuration_value = 'col-sm-6 text-center text-sm-left text-sm-end' WHERE configuration_key = 'MODULE_CONTENT_FOOTER_EXTRA_ICONS_CONTENT_WIDTH';

UPDATE configuration SET configuration_value = '' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MENU_STYLE';
