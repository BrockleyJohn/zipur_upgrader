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
  require $inc_directory . '/config.php';

  if ( ! empty( $config['password'] ) && $_COOKIE['zip_upgrade_pw'] == hash( 'sha256', $config['password'] )) {

    $action = $_POST['action'] ?? '';
    $filename = $_POST['file'] ?? '';
    $worklist_entry = $_POST['worklist_entry'] ?? '';
    $index = $_POST['index'] ?? '';

    $worklist = file_exists( $inc_directory . '/worklist.json' ) ? json_decode( file_get_contents( $inc_directory . '/worklist.json' ), true ) : [];

    switch ($action) {
      case 'load':
        if ( isset( $worklist[$filename] ) ) {
          $status = $worklist[$filename]['status'] ?? 'todo';
          $return = [
            'entry' => $worklist[$filename]['entry'] ?? null,
            'entrystatus' => $status,
            'buttons' => zipButton( TEXT_STEP_08_DIFFS_WORKLIST_EDIT, 'primary listentry', 'submit', 'fa-edit', 'lg',  'editWorklistEntry', ['file' => $filename, 'action' => 'edit', 'index' => $index] )
          ];
        } else {
          $status = 'todo';
          $return = [
            'entry' => null,
            'entrystatus' => $status,
            'buttons' => zipButton( TEXT_STEP_08_DIFFS_WORKLIST_ADD, 'primary listentry', 'submit', 'fa-plus', 'lg', 'addWorklistEntry', ['file' => $filename, 'action' => 'add', 'index' => $index] )
          ];
        }
        $return['buttons'] .=  ' ' . zipButton( TEXT_STEP_08_DIFFS_WORKLIST_COMPLETE, 'success listentry', 'submit', 'fa-check', 'lg', 'completeWorklistEntry', ['file' => $filename, 'action' => 'complete', 'index' => $index] );
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
