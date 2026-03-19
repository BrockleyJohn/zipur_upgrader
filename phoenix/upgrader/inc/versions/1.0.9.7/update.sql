CREATE TABLE customers_gdpr (
   gdpr_id int NOT NULL auto_increment,
   customers_id int NOT NULL,
   page varchar(255) NOT NULL,
   slug varchar(255) NOT NULL,
   pages_title varchar(255) NOT NULL,
   pages_text text NOT NULL,
   language varchar(255) NOT NULL,
   timestamp datetime NOT NULL,
   date_added datetime NOT NULL,
   PRIMARY KEY (gdpr_id),
   KEY idx_customers_id (customers_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE reviews ADD is_anon ENUM('y','n') NOT NULL DEFAULT 'n';
ALTER TABLE testimonials ADD is_anon ENUM('y','n') NOT NULL DEFAULT 'n';
  
DELETE FROM configuration WHERE configuration_key = 'SMALL_IMAGE_WIDTH';
DELETE FROM configuration WHERE configuration_key = 'SMALL_IMAGE_HEIGHT';
DELETE FROM configuration WHERE configuration_key = 'HEADING_IMAGE_WIDTH';
DELETE FROM configuration WHERE configuration_key = 'HEADING_IMAGE_HEIGHT';
DELETE FROM configuration WHERE configuration_key = 'CONFIG_CALCULATE_IMAGE_SIZE';

UPDATE configuration SET configuration_description = 'What type of container should the page content be shown in? See <a target="_blank" rel="noreferrer" href="https://getbootstrap.com/docs/4.6/layout/overview/#containers"><u>overview/#containers</u></a>.  <div class="alert alert-danger">container-xxl is an option for Bootstrap 5 only.</div>' WHERE configuration_key = 'BOOTSTRAP_CONTAINER';
UPDATE configuration SET set_function = 'Config::select_one([\'container\', \'container-sm\', \'container-md\', \'container-lg\', \'container-xl\', \'container-xxl\', \'container-fluid\'], ' WHERE configuration_key = 'BOOTSTRAP_CONTAINER';

UPDATE configuration SET configuration_description = 'When should this Navigation Bar Show? See https://getbootstrap.com/docs/4.6/components/navbar/#how-it-works.  <div class="alert alert-danger">navbar-expand-xxl is an option for Bootstrap 5 only.</div>' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MENU_COLLAPSE';
UPDATE configuration SET set_function = 'Config::select_one([\'navbar-expand\', \'navbar-expand-sm\', \'navbar-expand-md\', \'navbar-expand-lg\', \'navbar-expand-xl\', \'navbar-expand-xxl\'], ' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MENU_COLLAPSE';

UPDATE configuration SET configuration_title = 'Content Container' WHERE configuration_key = 'MODULE_CONTENT_CU_TITLE_CONTENT_WIDTH';
UPDATE configuration SET configuration_description = 'What container should the content be shown in? (col-*-12 = full width, col-*-6 = half width).' WHERE configuration_key = 'MODULE_CONTENT_CU_TITLE_CONTENT_WIDTH';

UPDATE configuration SET configuration_title = 'Content Container' WHERE configuration_key = 'MODULE_CONTENT_CU_MODULAR_CONTENT_WIDTH';
UPDATE configuration SET configuration_description = 'What container should the content be shown in? (col-*-12 = full width, col-*-6 = half width).' WHERE configuration_key = 'MODULE_CONTENT_CU_MODULAR_CONTENT_WIDTH';

UPDATE configuration SET configuration_title = 'Content Container' WHERE configuration_key = 'CU_FORM_CONTENT_WIDTH';
UPDATE configuration SET configuration_description = 'What container should the content be shown in? (col-*-12 = full width, col-*-6 = half width).' WHERE configuration_key = 'CU_FORM_CONTENT_WIDTH';

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Bootstrap Theme', 'BOOTSTRAP_THEME', 'auto', 'What theme (colour mode) should your site default to? See <a target="_blank" rel="noreferrer" href="https://getbootstrap.com/docs/5.3/customize/color-modes/"><u>/customize/color-modes/</u></a>.  <div class="alert alert-danger">This is an option for Bootstrap 5 only.</div>', 16, 3, 'Config::select_one([\'dark\', \'light\', \'auto\'], ', NOW());
