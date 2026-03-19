# Instructions for Manually Updating CE Phoenix 1.0.9.9 to 1.0.9.10

## REQUIRED Modules to Remove (AKA uninstall):
* None

## OPTIONAL Modules to Remove (AKA uninstall):
* None

## REQUIRED SQL:
* https://github.com/CE-PhoenixCart/Updates/raw/master/1.0.9.10/1.0.9.9/update.sql

## Upload: 
https://github.com/CE-PhoenixCart/Updates/raw/master/1.0.9.10/1.0.9.9/update.zip
or
## Perform the following file changes in each commit:
* (https://github.com/CE-PhoenixCart/PhoenixCart/compare/1.0.9.9...1.0.9.10)

## REQUIRED New Modules to Turn On (AKA install):
* None

## REQUIRED Existing Modules to Turn On (AKA install, note that these modules may already be installed):
* None

## OPTIONAL Install Modules:
* includes/modules/pi/product_info/pi_manufacturers.php
* includes/modules/pi/product_info/pi_importers.php

## OPTIONAL Files To Delete (You can choose to delete these if you are not using them):
* None

## REQUIRED Files to delete (You MUST delete these):
* admin/includes/actions/catalog/views/new_product_preview.php

## REQUIRED Folders to delete (You MUST delete these, including all files in the folder):
* admin/includes/actions/define_language/

## REQUIRED After Update:
* Visit the Security Check page in your admin area, and fix any warnings that show.
