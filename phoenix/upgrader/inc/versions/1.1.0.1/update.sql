DELETE FROM configuration WHERE configuration_key = 'MAX_RANDOM_SELECT_REVIEWS';
DELETE FROM configuration WHERE configuration_key = 'MAX_RANDOM_SELECT_NEW';
DELETE FROM configuration WHERE configuration_key = 'MAX_RANDOM_SELECT_SPECIALS';
DELETE FROM configuration WHERE configuration_key = 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX';

UPDATE configuration SET configuration_description = 'What type of container should the page content be shown in? See <a target="_blank" rel="noreferrer" href="https://getbootstrap.com/docs/5.3/layout/containers/"><u>layout/#containers</u></a>.' WHERE configuration_key = 'BOOTSTRAP_CONTAINER';

UPDATE configuration SET configuration_description = 'The background colour of the clicked Row.  See  https://getbootstrap.com/docs/5.3/content/tables/#variants' WHERE configuration_key = 'MODULE_HEADER_TAGS_TABLE_CLICK_JQUERY_TR_BACKGROUND';

UPDATE configuration SET configuration_description = 'What background and foreground colour should the Navbar have?  See <a target="_blank" rel="noreferrer" href="https://getbootstrap.com/docs/5.3/utilities/background/#background-color"><u>background/#background-color</u></a> and <a target="_blank" rel="noreferrer" href="https://getbootstrap.com/docs/5.3/components/navbar/#color-schemes"><u>navbar/#color-schemes</u></a>' WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_STYLE_BG';

UPDATE configuration SET configuration_description = 'Should the Navbar be Fixed/Sticky/Default behaviour? See <a target="_blank" rel="noreferrer" href="https://getbootstrap.com/docs/5.3/components/navbar/#placement"><u>navbar/#placement</u></a>' WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_FIXED';

UPDATE configuration SET configuration_description = 'When should the Navbar Show? See <a target="_blank" rel="noreferrer" href="https://getbootstrap.com/docs/5.3/components/navbar/#how-it-works"><u>navbar/#how-it-works</u></a>' WHERE configuration_key = 'MODULE_CONTENT_NAVBAR_COLLAPSE';

UPDATE configuration SET configuration_description = 'What colour scheme should this Navigation Bar have?  See https://getbootstrap.com/docs/5.3/components/navbar/#color-schemes' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MENU_STYLE';

UPDATE configuration SET configuration_description = 'When should this Navigation Bar Show? See https://getbootstrap.com/docs/5.3/components/navbar/#how-it-works' WHERE configuration_key = 'MODULE_CONTENT_HEADER_MENU_COLLAPSE';