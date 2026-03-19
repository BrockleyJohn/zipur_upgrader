UPDATE configuration SET configuration_value = '' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MENU_STYLE';
UPDATE configuration SET configuration_value = 'bg-body-secondary border-bottom' WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_STYLE_BG';
UPDATE configuration SET configuration_value = REPLACE(`configuration_value`, "-right", "-end");
UPDATE configuration SET configuration_value = REPLACE(`configuration_value`, "-left", "-start");