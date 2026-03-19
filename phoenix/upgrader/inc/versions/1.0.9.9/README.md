# Instructions for Manually Updating CE Phoenix 1.0.9.8 to 1.0.9.9

## REQUIRED Modules to Remove (AKA uninstall):
* None

## OPTIONAL Modules to Remove (AKA uninstall):
* None

## REQUIRED SQL:
* https://github.com/CE-PhoenixCart/Updates/raw/master/1.0.9.9/1.0.9.8/update.sql

## Upload: 
https://github.com/CE-PhoenixCart/Updates/raw/master/1.0.9.9/1.0.9.8/update.zip
or
## Perform the following file changes in each commit:
* (https://github.com/CE-PhoenixCart/PhoenixCart/compare/1.0.9.8...1.0.9.9)

## REQUIRED New Modules to Turn On (AKA install):
* None

## REQUIRED Existing Modules to Turn On (AKA install, note that these modules may already be installed):
* None

## OPTIONAL Install Modules:
* includes/modules/pi/product_info/pi_gallery_images.php
* includes/modules/pi/product_info/pi_date_available.php
* includes/modules/content/testimonials/cm_t_write.php

## OPTIONAL Files To Delete (You can choose to delete these if you are not using them):
* images/sample/apple-1.jpg
* images/sample/apple-pears.jpg
* images/sample/citrus.jpg
* images/sample/fruit.jpg
* images/sample/grapefruit-1.jpg
* images/sample/green-apple-1.jpg
* images/sample/green-tomatoes-1.jpg
* images/sample/lemon-1.jpg
* images/sample/lime-1.jpg
* images/sample/orange-1.jpg

## REQUIRED Files to delete (You MUST delete these):
* None

## REQUIRED After Update:
* Visit the Security Check page in your admin area, and fix any warnings that show.
