<?php
/*
  Worklist view for Zipur CE Phoenix Upgrade Utility
  Author: John Ferguson @BrockleyJohn phoenix@cartmart.uk
  Copyright (c) SE Websites 2026
  Released under the GNU General Public License
*/

  $zipmigutil = 1;

  require_once 'inc/functions/functions.php';
  zipurSessionStart();
  if (!zipurIsAuthenticated()) {
    header('Location: index.php?step=999');
    exit;
  } 

  try {
      require 'inc/header.php';

      if (! empty( $worklist )  ) {

        $b = 0;

        if ( $config['limitstep'] >= 7 ) {
          // core version has been downloaded so can be used
          // corepath should be only folder in clean_core
          $corepath = '';
          $files = scandir('inc/clean_core/');
          foreach ($files as $file) {
            if (is_dir('inc/clean_core/' . $file) && strpos($file, 'CE-Phoenix') === 0) {
              $corepath = realpath('inc/clean_core/' . $file);
              break;
            }
          }

        }

        foreach ($worklist as $filename => $item) {
          echo '<div class="card mb-3">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . htmlspecialchars($filename) . '</h5>';
          echo '<p class="card-text">' . nl2br(htmlspecialchars($item['entry'])) . '</p>';
          $params = [ 'file' => $filename, 'index' => $b ];
          if ( $config['limitstep'] >= 7) {
            // core version has been downloaded so can be used
            $params['corepath'] = $corepath;
            $params['corefile'] = basename($filename);
          }
          $workid = 'worklistitem_' . $b;
          $worklist_item = '';
          if ( $item['status'] == 'complete' ) {
              $worklist_item .= zipButton( TEXT_WORK_ITEM, TEXT_WORKLIST_DONE_COLOUR . ' worklink', '#', 'fa-' . TEXT_WORKLIST_DONE_ICON, 'sm', $workid, $params );
          } else {
            if (strpos($filename, '/includes/languages/') === 0) {
                $worklist_item .= proButton( TEXT_WORK_ITEM_TO_TEMPLATE, TEXT_WORKLIST_TO_TEMPLATE_COLOUR . ' totemplate', '#', 'fa-' . TEXT_WORKLIST_TO_TEMPLATE_ICON, 'sm', $workid, $params );
            }
              $worklist_item .= zipButton( TEXT_WORK_ITEM, TEXT_WORKLIST_TO_DO_COLOUR . ' worklink', '#', 'fa-' . TEXT_WORKLIST_TO_DO_ICON, 'sm', $workid, $params );
          }
          echo '<p class="card-text w-100 text-right">' . $worklist_item . '</p>';
          echo '</div>';
          echo '</div>';
          $b++;
        }

        worklistPopup();

        totemplatePopup();

      } else {

        echo '<div class="alert alert-info">' . TEXT_WORKLIST_EMPTY . '</div>';
      }

      require 'inc/footer.php';
  } catch (Exception $e) {
      echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
  }
