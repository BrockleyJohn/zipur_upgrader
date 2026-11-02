<?php
/**
 * Phoenix Cart Upgrader - Worklist Modal
 * 
 * author: John Ferguson @BrockleyJohn phoenix@cartmart.uk
 * copyright (c) SE Websites 2026
 */

  $inc_directory = dirname( __FILE__ ) . '/inc';

  require $inc_directory . '/languages/english/primary.php';
  require $inc_directory . '/functions/functions.php';
  zipurSessionStart();
  require $inc_directory . '/config.php';
  header('Content-Type: application/json; charset=UTF-8');

  if ( ! empty( $config['password'] ) && zipurIsAuthenticated()) {
    zipurRequireCsrf();

    $action = $_POST['action'] ?? '';
    $filename = $_POST['file'] ?? '';
    $corepath = $_POST['corepath'] ?? '';
    $corefile = $_POST['corefile'] ?? '';
    $worklist_entry = $_POST['worklist_entry'] ?? '';
    $should_override = ($_POST['should_override'] ?? 0) == '1';
    $is_overridden = ($_POST['is_overridden'] ?? 0) == '1';
    $step = $_POST['step'] ?? '';
    $index = $_POST['index'] ?? '';

    $worklist = file_exists( $inc_directory . '/worklist.json' ) ? json_decode( file_get_contents( $inc_directory . '/worklist.json' ), true ) : [];

    switch ($action) {
      case 'load':
        if ( isset( $worklist[$filename] ) ) {
          $status = $worklist[$filename]['status'] ?? 'todo';
          $return = [
            'entry' => $worklist[$filename]['entry'] ?? null,
            'entrystatus' => $status,
            'buttons' => zipButton( TEXT_STEP_08_DIFFS_WORKLIST_EDIT, 'primary listentry', 'submit', 'fa-edit', '',  'editWorklistEntry', ['file' => $filename, 'action' => 'edit', 'index' => $index] )
          ];
        } else {
          $status = 'todo';
          $return = [
            'entry' => null,
            'entrystatus' => $status,
            'buttons' => zipButton( TEXT_STEP_08_DIFFS_WORKLIST_ADD, 'primary listentry', 'submit', 'fa-plus', '', 'addWorklistEntry', ['file' => $filename, 'action' => 'add', 'index' => $index] )
          ];
        }
        if ($should_override) {
          $return['buttons'] .=  ' ' . proButton( TEXT_STEP_08_DIFFS_WORKLIST_OVERRIDE, 'warning changefiles', 'submit', 'fa-hand-point-right', '', 'moveToTemplate', ['file' => $filename, 'corepath' => $corepath, 'corefile' => $corefile, 'action' => 'movetemplate', 'index' => $index] );
        }
        $return['buttons'] .=  ' ' . proButton( TEXT_STEP_08_DIFFS_WORKLIST_REVERT, 'warning changefiles', 'submit', 'fa-history', '', 'revertToCore', ['file' => $filename, 'corepath' => $corepath, 'corefile' => $corefile, 'action' => 'revert', 'index' => $index] );
        $return['buttons'] .=  ' ' . zipButton( TEXT_STEP_08_DIFFS_WORKLIST_COMPLETE, 'success listentry', 'submit', 'fa-check', '', 'completeWorklistEntry', ['file' => $filename, 'action' => 'complete', 'index' => $index] );
        if ($step == '10' && $is_overridden) {
          //error_log("Step 10 and file is overridden: $filename");
          // if it's a language file
          if (strpos($filename, 'includes/languages/') !== false && substr($filename, -4) === '.php') {
            //error_log("Checking added definitions for language file: $filename");
            // check for added definitions
            $added_definitions = compareLanguageFiles($filename, $corefile, $corepath);
            if (!empty($added_definitions)) {
              $return['diffMessages'] = $added_definitions;
              $return['buttons'] .=  ' ' . proButton( TEXT_STEP_10_DIFFS_WORKLIST_ADD_DEFINITIONS, 'danger changefiles', 'submit', 'fa-puzzle-piece', '', 'addDefinitions', ['file' => $filename, 'corepath' => $corepath, 'corefile' => $corefile, 'action' => 'adddefs', 'index' => $index] );
            }
          }
        }
        die( json_encode($return) );
        break;
      case 'add':
        $worklist[$filename] = [
          'entry' => $worklist_entry,
          'status' => 'todo'
        ];
        file_put_contents( $inc_directory . '/worklist.json', json_encode($worklist, JSON_PRETTY_PRINT) );
        break;
      case 'edit':
        if ( isset( $worklist[$filename] ) ) {
          $worklist[$filename] = [
            'entry' => $worklist_entry,
            'status' => 'todo'
          ];
          file_put_contents( $inc_directory . '/worklist.json', json_encode($worklist, JSON_PRETTY_PRINT) );
        } else {
          die( json_encode(['error' => 'Worklist entry not found']) );
        }
        break;
      case 'complete':
        //if ( isset( $worklist[$filename] ) ) {
          $worklist[$filename] = [
            'entry' => $worklist_entry,
            'status' => 'complete'
          ];
          file_put_contents( $inc_directory . '/worklist.json', json_encode($worklist, JSON_PRETTY_PRINT) );
        /* } else {
          die( json_encode(['error' => 'Worklist entry not found']) );
        } */
        break;
      default:
        die( json_encode(['error' => 'Invalid action']) );
    }
    // common return for successfully handled actions
    die( json_encode([
      'success' => true,
      'entrystatus' => $worklist[$filename]['status'],
    ]) );

  } else {
      die( json_encode(['error' => 'Unauthorized']) );
  }
