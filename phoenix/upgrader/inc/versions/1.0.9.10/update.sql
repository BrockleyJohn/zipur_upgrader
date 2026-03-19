CREATE TABLE importers (
  importers_id int NOT NULL auto_increment,
  importers_name varchar(255) NOT NULL,
  importers_image varchar(255),
  importers_address TEXT NULL,
  importers_email varchar(255),
  date_added datetime NULL,
  last_modified datetime NULL,
  PRIMARY KEY (importers_id),
  KEY IDX_IMPORTERS_NAME (importers_name)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE importers_info (
  importers_id int NOT NULL,
  languages_id int NOT NULL,
  importers_url varchar(255) NOT NULL,
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime NULL,
  importers_description TEXT NULL,
  PRIMARY KEY (importers_id, languages_id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE manufacturers ADD manufacturers_address TEXT NULL;
ALTER TABLE manufacturers ADD manufacturers_email varchar(255);

ALTER TABLE products ADD importers_id int NULL;

UPDATE configuration SET configuration_value = 'sticky-top' WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_FIXED';
