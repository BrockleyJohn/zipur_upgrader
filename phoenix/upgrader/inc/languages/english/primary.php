<?php

    /*

 Name: Zipur CE Phoenix Upgrade Utility

 Author: Preston Lord
 	 phoenixaddons.com / @zipurman / plord@inetx.ca

 Released under the GNU General Public License

 Copyright (c) 2021: Preston Lord - @zipurman - Intricate Networks Inc.

  Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

  1. Re-distributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

  2. Re-distributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

  3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/

    const TEXT_ERROR_WRITE_FILE = 'CANNOT WRITE FILES IN THIS FOLDER - CHECK PERMISSIONS';

    const TEXT_WELCOME_MESSAGE = 'This utility will allow you to upgrade your CE Phoenix install from an older version to the latest version of CE Phoenix. You will be shown all of the files from your current install that you have modified and then you can decide how to proceed with an upgrade.';

    const TEXT_SUPPORT_LINK = '<a href="%s" target="_blank" class="btn btn-info mt-2"><i class="fas fa-life-ring"></i> Get Help</a>';

    const TEXT_BACKUP_WARNING            = 'MAKE SURE YOU HAVE COMPLETED A RECENT BACKUP OF YOUR DATA AND YOUR FILES BEFORE PROCEEDING.';
    const TEXT_BACKUP_NO_LIABILITY       = 'THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.';
    const TEXT_BACKUP_NO_LIABILITY_AGREE = 'By clicking the following button, you agree to the above conditions.';
    const TEXT_BUTTON_START              = 'I AGREE, GET STARTED';

    const TEXT_STEP_01_DESCRIPTION = 'To get started we will need to setup some security to protect this utility. Once this password is set, you will need to enter it to use this utility. If you forget this password, you can edit the config file to review.<br/><br/>Enter a password that will be used to protect this file below.';
    const TEXT_PASSWORD            = 'Password';
    const TEXT_PASSWORD_TOO_SHORT  = 'You must create a password that is at least 6 characters long. The more complex the safer your utility will be.';

    const TEXT_CREATED        = 'Created';
    const TEXT_FAILED         = 'Failed';
    const TEXT_SUCCESSFUL     = 'Successful';
    const TEXT_SAVED          = 'Changes Saved';
    const TEXT_CLOSE          = 'Close';
    const TEXT_BUTTON_DIFFS   = 'DIFFS';
    const TEXT_BUTTON_BACK    = 'BACK';
    const TEXT_BUTTON_NEXT    = 'NEXT';
    const TEXT_BUTTON_PROCEED = 'PROCEED';
    const TEXT_BUTTON_LOGIN   = 'LOGIN';
    const TEXT_BUTTON_LOGOUT  = 'LOG OUT';
    const TEXT_BUTTON_VIEW_WORKLIST = 'VIEW WORKLIST';
    const TEXT_LOGIN_FAILED   = 'LOGIN FAILED';

    const MYSQL_PORT = 3306;

    const TEXT_STEP_02_DESCRIPTION = 'Now that you have your password set, you are ready to start upgrading your CE Phoenix store.<br/><br/>There are several steps to this process and this utility will walk you through what is required.';

    const TEXT_STEP_03_DESCRIPTION = 'This is the main dashboard for this utility. All of the items below will guide you through the upgrade process. Make sure to take your time and to read carefully through the instructions as they are presented.';
    const TEXT_STEP_03_YOUTUBE     = 'Watch the YouTube Tutorial for this utility. (Highly Recommend Watching)';

    const TEXT_STEP_03_EXPORT_FILES = 'Link to file structure for your CE Phoenix store';

    const TEXT_YOU_ARE_RUNNING = 'You are running version';
    const TEXT_THERE_ARE       = 'There are';
    const TEXT_NEWER_VERSIONS  = 'newer versions. Next upgrade is';
    const TEXT_MAX_VERSIONS    = 'and the maximum upgrade is version';

    const TEXT_STEP_03_CONFIRM_SERVER = 'Test server to make sure PHP and MySQL are setup correctly';

    const TEXT_STEP_03_DOWNLOAD_CORE = 'Download a clean copy of %s\'s core files to compare against your current store files to check for changes. This will allow you to review any changes you have made to core files and make informed decisions on how to proceed with the upgrade.';
    const TEXT_STEP_03_REVIEW_CORE = 'Review Your Core Changes against %s <span class="text-danger">(RECOMMENDED BEFORE <u>EACH</u> UPGRADE)</span>';

    const TEXT_STEP_03_CHECK_DUPLICATES = 'Check configuration table for duplicates';
    const TEXT_STEP_03_UPGRADE_REVIEW   = 'Review upgrade to version ';

    const TEXT_FILES_ROOT         = 'Catalog Root Folder (full path)';
    const TEXT_FILES_ROOT_FAILED  = 'Catalog Root Folder Not Found';
    const TEXT_FILES_ROOT_SUCCESS = 'Catalog Root Folder Found';
    const TEXT_FILES_ADMIN        = 'Catalog Admin Root Folder (full path)';

    const TEXT_FILES_ADMIN_FAILED  = 'Catalog Admin Folder Not Found';
    const TEXT_FILES_ADMIN_SUCCESS = 'Catalog Admin Folder Found';

    const TEXT_STEP_04_DESCRIPTION = 'Enter the information below to connect to your new CE Phoenix files.';
    const TEXT_STEP_05_DESCRIPTION = 'CE Phoenix File Test';
    const TEXT_STEP_06_DESCRIPTION = 'Testing your settings to make sure permissions are set correctly.';
    const TEXT_STEP_07_DESCRIPTION = 'This step will download a full core copy of your current CE Phoenix version and then compare it to your installed version. This will allow the upgrade utility to warn of any core files that will be upgraded that would change your customizations.';
    const TEXT_STEP_08_DESCRIPTION = 'Checking changed core files...';
    const TEXT_STEP_08_WARNING     = 'The following CORE FILES were changed in your current store. This means that some code in these files have changed since they were installed. The upgrade utility will warn you at the next step if these files will be replaced as you upgrade and will save a copy of your edited files. Any extra files that were added to your store that were not in the CORE will also be monitored and you will be warned if they will be adjusted.';
    const TEXT_STEP_08_CURRENT_TEMPLATE = 'Your store template is currently set to: <strong>%s</strong>. If you have made customizations to your default template files, core language files or module templates, you should copy them to the active template instead.';
    const TEXT_STEP_08_NO_ALTERED_FILES = 'No core files were altered from the standard Phoenix Cart distribution. You can proceed with the upgrade without concern for losing store customizations.';

    const TEXT_STEP_09_DESCRIPTION      = 'Check configuration table for duplicates. Some old code may have created duplicates in your data. This will check to see if any exist and will allow you to fix prior to upgrading. If you do not resolve duplicates, future versions of CE Phoenix may throw errors as result and your store will not load.';
    const TEXT_STEP_09_NO_DUPLICATES    = 'NO DUPLICATES FOUND';
    const TEXT_STEP_09_DUPLICATES_FOUND = 'DUPLICATES FOUND!! You will have to delete the duplicates before proceeding.';
    const TEXT_STEP_09_DUPLICATE        = 'DUPLICATE';
    const TEXT_DELETE                   = 'DELETE';
    const TEXT_DISABLE_MODULE                   = 'DISABLE MODULE';
    const TEXT_REMOVED_MODULE                   = 'REMOVED MODULE';
    const TEXT_ENABLE_MODULE                   = 'ENABLE MODULE IF NEEDED - check the module is installed and enabled.';
    const TEXT_DELETE_FAILED                   = 'DELETE FAILED';
    const TEXT_MOVE_FAILED                   = 'MOVE FAILED';
    const TEXT_SKIP_NOT_USED                  = 'SKIPPING ... NOT USED';
    const TEXT_REENABLE_MOD                  = '<span class="alert alert-danger" style="padding: 4px;">RE-ENABLE THIS MODULE IF NEEDED - You had it enabled before this upgrade.</span>';
    const TEXT_REENABLE_MOD_NO                  = 'This mod was NOT enabled prior to upgrade.';
    const TEXT_COPIED                   = 'COPIED';
    const TEXT_BACKED_UP                = 'BACKED UP';
    const TEXT_CREATE_DIR                  = 'CREATE DIRECTORY';
    const TEXT_DELETE_NOT_NEEDED                   = 'You do not have this file in your store. Skipping Delete.';
    const TEXT_COPY_FAILED              = 'COPY FAILED';
    const TEXT_UPGRADE_NOW              = 'UPGRADE NOW';
    const TEXT_NO_UPGRADES              = 'There are no newer upgrades available in your /versions/ folder. You can get new version changes online at <a href="https://phoenixcart.org/forum/addons/" target="_blank">https://phoenixcart.org/forum/addons/</a>';
    const TEXT_NO_MEET_REQUIREMENT_UPGRADES              = 'There are no upgrades available for you in the /versions/ folder. You can get new version changes online at <a href="https://phoenixcart.org/forum/addons/" target="_blank">https://phoenixcart.org/forum/addons/</a>';

    const TEXT_STEP_10_DESCRIPTION = 'Below is a summary of what will be done to upgrade to version ';

    const TEXT_SAFE                = ' Verified - no conflict';
    const TEXT_NOT_SAFE            = ' Warning - conflict';

    const TEXT_SAFE_LEGEND                = 'Files marked as "Verified - no conflict" were un-altered from the original version when you started your upgrade. These are safe to upgrade without concern.';
    const TEXT_NOT_SAFE_LEGEND            = 'Files marked as "Warning - conflict" were altered from their original state. This means that core changes were made to these files and they should be reviewed to make sure once overwritten that your store functionality is not broken due to previous customizations.';

    const TEXT_NO_DATABASE_CHANGES = 'No Database Changes Required';
    const TEXT_NO_DELETE_CHANGES   = 'No Files to Delete';
    const TEXT_NO_ENABLE_CHANGES   = 'No Modules to Enable';
    const TEXT_NO_DISABLE_CHANGES  = 'No Modules to Disable';
    const TEXT_NO_FILE_CHANGES     = 'No File Changes Required';
    const TEXT_CONFLICT            = 'Make sure you review the above conflicts before proceeding. Any core files replaced that were previously altered would result in the loss of any changes to those files. It is also possible that other issues could arise if changes to those files are required for other core changes you have made.';
    const TEXT_UPGRADE_FAILED      = 'The upgrade has failed. Review the comments above in order to re-run the failed items.';
    const TEXT_UPGRADE_PASSED      = 'The upgrade has completed.';
    const TEXT_UPGRADE_BROKEN      = 'The upgrade folder is missing data.';
    const TEXT_SQL_ERROR           = 'SQL ERROR - CHECK LOGS FOR FULL DETAILS';

    const TEXT_STEP_08_DIFFS_INSTRUCTIONS = 'Site file is shown with deletions from core in red and addtions in green.';
    const TEXT_STEP_08_DIFFS_WORKLIST_ENTRY = 'File Worklist Entry';
    const TEXT_STEP_08_DIFFS_WORKLIST_ADD = 'SAVE TO WORKLIST';
    const TEXT_STEP_08_DIFFS_WORKLIST_EDIT = 'EDIT WORKLIST ENTRY';
    const TEXT_STEP_08_DIFFS_WORKLIST_COMPLETE = 'MARK COMPLETE / IGNORE';
    const TEXT_STEP_11_DESCRIPTION = 'Below is the output from your upgrade to ';

    const TEXT_WORKLIST_DONE_COLOUR = 'success';
    const TEXT_WORKLIST_NEW_COLOUR = 'danger';
    const TEXT_WORKLIST_TO_DO_COLOUR = 'warning';
    const TEXT_WORKLIST_DONE_ICON = 'check-circle';
    const TEXT_WORKLIST_NEW_ICON = 'plus-square';
    const TEXT_WORKLIST_TO_DO_ICON = 'hourglass-half';
    define('TEXT_WORKLIST_DONE', 'fas fa-' . TEXT_WORKLIST_DONE_ICON . ' text-' . TEXT_WORKLIST_DONE_COLOUR);
    define('TEXT_WORKLIST_NEW', 'fas fa-' . TEXT_WORKLIST_NEW_ICON . ' text-' . TEXT_WORKLIST_NEW_COLOUR);
    define('TEXT_WORKLIST_TO_DO', 'fas fa-' . TEXT_WORKLIST_TO_DO_ICON . ' text-' . TEXT_WORKLIST_TO_DO_COLOUR);
    const TEXT_WORK_ITEM = 'WORK ITEM';

    const TEXT_WORKLIST_EMPTY = 'Your worklist is currently empty. When you review the comparison of your diffs of your changed files, you can add items to your worklist to keep notes of the customisations you have made, any actions you need to take now or for a later update, and any progress.';

    const TEXT_DIRECTORY_CREATE_ERROR         = 'Creating Clean Core Directory Failed!';
    const ZIPUR_CODE_COMPARE_DOWNLOAD_ERROR   = 'DOWNLOAD ERROR';
    const ZIPUR_CODE_COMPARE_DOWNLOAD_SUCCESS = 'DOWNLOAD SUCCESS';
    const ZIPUR_CODE_COMPARE_UNZIP_SUCCESS    = 'UNZIP SUCCESS';
    const ZIPUR_CODE_COMPARE_UNZIP_FAILED     = 'UNZIP FAILED';

    const TEXT_VERSION_DIRECTORY_CREATE_FAILED = 'Creating Version Directory Failed! Check permissions and make sure the upgrader/inc/versions/.... directory is writable.';
    const TEXT_WORK_DIRECTORY_CREATE_FAILED = 'Creating Work Directory Failed! Check permissions and make sure the upgrader/inc/update_work/ directory is writable.';
    const TEXT_VERSION_DOWNLOAD_FAILED = 'DOWNLOAD ERROR - Update to %s failed to download from %s to %s.';
    const TEXT_VERSION_DOWNLOAD_SUCCESS = 'DOWNLOAD SUCCESS - downloaded update to %s from repository.';
    const TEXT_VERSION_FOLDER_NOT_FOUND = 'VERSION FOLDER NOT FOUND - %s';
    const TEXT_VERSION_UNZIP_SUCCESS = 'UNZIP SUCCESS - unzipped update to %s successfully.';
    const TEXT_VERSION_UNZIP_FAILED = 'UNZIP FAILED - failed to unzip %s.';
    const TEXT_VERSION_MOVE_FAILED = 'MOVE FAILED - failed to move version %s files after unzip.';
    const TEXT_VERSION_MOVE_SUCCESS = 'UPDATE TO VERSION %s FETCHED SUCCESSFULLY';

    const TEXT_FILES_TEST_ROOT_WRITE_IMAGES    = 'Write test file to CE Phoenix Images Directory';
    const TEXT_FILES_TEST_ROOT_DELETE_IMAGES   = 'Delete test file from CE Phoneix Images Directory';
    const TEXT_FILES_TEST_ROOT_WRITE_INCLUDES  = 'Write test file to CE Phoenix Includes Directory';
    const TEXT_FILES_TEST_ROOT_DELETE_INCLUDES = 'Delete test file from CE Phoneix Includes Directory';
    const TEXT_MYSQL_TEST_CREATE_TABLE_CEP     = 'Create test table in CE Phoenix MySQL Database';
    const TEXT_MYSQL_TEST_DELETE_TABLE_CEP     = 'Drop test table in CE Phoenix MySQL Database';

    const TEXT_ALL_DONE_LINK_ADMIN = 'Visit the Security Check page in your admin area, and fix any warnings that show.';
    const TEXT_ALL_DONE = 'Congratulations, your upgrade is completed. If you have custom mods/hooks that need to be installed you will have to do those manually. You should login to your CE Phoenix Admin and run a Security Check as well as test your store to make sure there are no issues with the new version and your additional files.';
    const TEXT_DONATE   = 'At PhoenixAddons.com, we work hard to bring you tools like this. <br/>If you are happy with this tool and the upgrade process and would like us to continue providing <br/>tools like this ... please consider donating what you feel the tool is worth.';
