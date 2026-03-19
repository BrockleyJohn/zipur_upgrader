# Instructions for Manually Updating CE Phoenix 1.0.9.7 to 1.0.9.8

## REQUIRED Modules to Remove (AKA uninstall):
* None

## OPTIONAL Modules to Remove (AKA uninstall):
* None

## REQUIRED SQL:
* https://github.com/CE-PhoenixCart/Updates/raw/master/1.0.9.8/1.0.9.7/update.sql

## Upload: 
https://github.com/CE-PhoenixCart/Updates/raw/master/1.0.9.8/1.0.9.7/update.zip
or
## Perform the following file changes in each commit:
* (https://github.com/CE-PhoenixCart/PhoenixCart/compare/1.0.9.7...1.0.9.8)

## REQUIRED New Modules to Turn On (AKA install):
* None

## REQUIRED Existing Modules to Turn On (AKA install, note that these modules may already be installed):
* None

## OPTIONAL Install Modules:
* includes/modules/content/index/cm_i_modular.php
* includes/modules/pi/index/i_adverts.php
* includes/modules/pi/index/i_brand_icons.php
* includes/modules/pi/index/i_hero.php
* includes/modules/content/info/cm_info_modular.php
* includes/modules/pi/info/ip_text.php

## OPTIONAL Files To Delete (You can choose to delete these if you are not using them):
* None

## REQUIRED Files to delete (You MUST delete these):
* templates/bootstrap5/includes/languages/english/system/versioned/1.0.7.other/1.0.7.12/product.php

## REQUIRED After Update:
* Visit the Security Check page in your admin area, and fix any warnings that show.
