DROP TABLE IF EXISTS outgoing;
CREATE TABLE outgoing ( id int(11) NOT NULL AUTO_INCREMENT, customer_id int(11) NOT NULL, identifier varchar(255) NULL DEFAULT NULL, send_at datetime NOT NULL, fname varchar(255) NOT NULL, lname varchar(255) NOT NULL, email_address varchar(255) NOT NULL, slug varchar(255) NOT NULL, merge_tags longtext, date_added datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, last_modified datetime DEFAULT NULL, PRIMARY KEY (id) ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
DROP TABLE IF EXISTS outgoing_tpl;
CREATE TABLE outgoing_tpl ( id int(11) NOT NULL AUTO_INCREMENT, slug varchar(255) NOT NULL, title varchar(255) NOT NULL, text longtext NOT NULL, date_added datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, last_modified datetime DEFAULT NULL, PRIMARY KEY (id) ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
DELETE from configuration WHERE configuration_key = 'DIR_FS_CACHE';
DELETE from configuration WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_STYLE_FG';

UPDATE configuration SET configuration_value = CONCAT(configuration_value, ';ht_outgoing.php') WHERE configuration_key = 'MODULE_HEADER_TAGS_INSTALLED';

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Enable Queued E-mail Module', 'MODULE_HEADER_TAGS_O_STATUS', 'True', 'Do you want to enable the this module?', 6, 1, 'Config::select_one([\'True\', \'False\'], ', NOW());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_O_SORT_ORDER', '810', 'Sort order of display. Lowest is displayed first.', 6, 2, now());

UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_LOGIN_FORM_CONTENT_WIDTH';
UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_CREATE_ACCOUNT_LINK_CONTENT_WIDTH';
UPDATE configuration SET configuration_value = CONCAT(configuration_value, ' mb-4') WHERE configuration_key = 'MODULE_CONTENT_FORGOT_PASSWORD_CONTENT_WIDTH';

UPDATE configuration SET configuration_value = 'col-sm-6 mb-2' WHERE configuration_key = 'MODULE_CONTENT_TESTIMONIALS_LIST_CONTENT_WIDTH_EACH';
UPDATE configuration SET set_function = NULL WHERE configuration_key = 'MODULE_CONTENT_TESTIMONIALS_LIST_CONTENT_WIDTH_EACH';

UPDATE configuration SET configuration_value = 'bg-light navbar-light border-bottom' WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_STYLE_BG';

INSERT INTO outgoing_tpl (id, slug, title, text, date_added) VALUES ('1', 'no_checkout', '{{FNAME}}, no checkout?', 'Hi {{FNAME}}\r\n\r\nWe noticed you registered on our site back on the {{SIGN_UP_DAY}} of {{SIGN_UP_MONTH}} but you did not checkout.\r\n\r\nIf you had a problem with our site, please do not hesitate to contact us.', NOW());
INSERT INTO outgoing_tpl (id, slug, title, text, date_added) VALUES ('2', 'order_thanks', '{{FNAME}} thank you for Order #{{ORDER_ID}}', 'Hi {{FNAME}}\r\n\r\nThank you for Order #{{ORDER_ID}} made on {{ORDER_DATE}}.  We are working to pick and pack your Order and will update you at each stage of the process.\r\n\r\nYou ordered:\r\n{{ORDER_PRODUCTS}}\r\n\r\nIf you have any questions about this Order or our site, please do not hesitate to contact us.', NOW());
INSERT INTO outgoing_tpl (id, slug, title, text, date_added) VALUES ('3', 'winback', '{{FNAME}}, we\'ve missed you', 'Hi {{FNAME}}\r\n\r\nWe really hope you enjoyed your products that you ordered back on {{ORDER_DATE}}\r\n\r\nWe have new products we think you might be interested in.', NOW());

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) VALUES ('E-Mail From', 'EMAIL_FROM', 'root@localhost', 'All e-mails will be sent from this address', 12, 6, NOW());
