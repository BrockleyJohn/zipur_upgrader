<?php
/*
  Worklist view for Zipur CE Phoenix Upgrade Utility
  Author: John Ferguson @BrockleyJohn phoenix@cartmart.uk
  Copyright (c) SE Websites 2026
  Released under the GNU General Public License
*/

  $zipmigutil = 1;

  try {
      require 'inc/header.php';

      if (! empty( $worklist )  ) {

        $b = 0;

        foreach ($worklist as $filename => $item) {
          echo '<div class="card mb-3">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . htmlspecialchars($filename) . '</h5>';
          echo '<p class="card-text">' . nl2br(htmlspecialchars($item['entry'])) . '</p>';
          $params = [ 'file' => $filename, 'index' => $b ];
          $workid = 'workitem_' . $b;
          if ( $item['status'] == 'complete' ) {
              $worklist_item = zipButton( TEXT_WORK_ITEM, TEXT_WORKLIST_DONE_COLOUR . ' worklink', '#', 'fa-' . TEXT_WORKLIST_DONE_ICON, 'sm', $workid, $params );
          } else {
              $worklist_item = zipButton( TEXT_WORK_ITEM, TEXT_WORKLIST_TO_DO_COLOUR . ' worklink', '#', 'fa-' . TEXT_WORKLIST_TO_DO_ICON, 'sm', $workid, $params );
          }
          echo '<p class="card-text w-100 text-right">' . $worklist_item . '</p>';
          echo '</div>';
          echo '</div>';
          $b++;
        }

        worklistPopup();

      } else {

        echo '<div class="alert alert-info">' . TEXT_WORKLIST_EMPTY . '</div>';
      }


      require 'inc/footer.php';
  } catch (Exception $e) {
      echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
  }
