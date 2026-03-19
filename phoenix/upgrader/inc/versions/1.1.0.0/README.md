# Instructions for Manually Updating CE Phoenix 1.0.9.10 to 1.1.0.0

## REQUIRED Modules to Remove (AKA uninstall):
* None

## OPTIONAL Modules to Remove (AKA uninstall):
* None

## REQUIRED SQL:
* https://github.com/CE-PhoenixCart/Updates/raw/master/1.1.0.0/1.0.9.10/update.sql

## Upload: 
https://github.com/CE-PhoenixCart/Updates/raw/master/1.1.0.0/1.0.9.10/update.zip
or
## Perform the following file changes in each commit:
* (https://github.com/CE-PhoenixCart/PhoenixCart/compare/1.0.9.10...1.1.0.0)

## REQUIRED New Modules to Turn On (AKA install):
* None

## REQUIRED Existing Modules to Turn On (AKA install, note that these modules may already be installed):
* None

## OPTIONAL Install Modules:
* None

## OPTIONAL Files To Delete (You can choose to delete these if you are not using them):
* None

## REQUIRED Files to delete (You MUST delete these):
* includes/hooks/admin/catalog/jQueryUI.php
* includes/hooks/admin/siteWide/jQuery.php
* templates/default/includes/hooks/shop/siteWide/jQuery.php

## REQUIRED Folders to delete (You MUST delete these, including all files in the folder):
* templates/bootstrap5/

## REQUIRED After Update:
* Visit the Security Check page in your admin area, and fix any warnings that show.
