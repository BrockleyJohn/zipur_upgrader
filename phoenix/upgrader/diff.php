<?php
/**
 * Phoenix Cart Upgrader - Diff Modal
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

  function zipurDiffError($message, $status = 400) {
    http_response_code($status);
    echo json_encode(['error' => $message]);
    exit;
  }

  if (empty($config['password']) || !zipurIsAuthenticated()) {
      zipurDiffError('Unauthorized', 403);
  }
  try {
      zipurRequireCsrf();
  } catch (RuntimeException $e) {
      zipurDiffError('Invalid request', 403);
  }

    $filename = $_POST['file'] ?? '';
    $corepath = $_POST['corepath'] ?? '';
    $corefile = $_POST['corefile'] ?? '';

    $filename_regex = str_replace( '\\', '\\\\', $filename );
    $filepath = pathinfo( $filename);
    $corepath_regex = str_replace( '\\', '\\\\', $corepath );
    $corepathtest = pathinfo( $corepath );
    $corefile_regex = str_replace( '\\', '\\\\', $corefile );
    $corefiletest = pathinfo( $corefile );

    //if ( empty( $filename ) || ! preg_match( '/^[a-zA-Z0-9_\-\/]+$/', $filepath['dirname'] ) || ! preg_match( '/^[a-zA-Z0-9_\-\.]+$/', $filepath['basename'] ) ) {
    if ( empty( $filename ) || ! preg_match( '/^(?!.*\/\.\.(?:\/.*|$))[a-zA-Z0-9_\-\.\/\\\\]+$/', $filename_regex ) ) {
      error_log( 'Invalid file name "' . $filename . '"' );
      zipurDiffError( 'Invalid site file name' );
    }
    //if ( empty( $corepath ) || ! preg_match( '/^[a-zA-Z0-9_\-\/]+$/', $corepathtest['dirname'] ) || ! preg_match( '/^[a-zA-Z0-9_\-\.]+$/', $corepathtest['basename'] ) ) {
    if ( empty( $corepath ) || ! preg_match( '/^(?!.*\/\.\.(?:\/.*|$))[a-zA-Z0-9_\-\.\/\\\\]+$/', $corepath_regex ) ) {
      error_log( 'Invalid core path "' . $corepath . '"' );
      zipurDiffError( 'Invalid core path' );
    }
    if ( empty( $corefile ) || ! preg_match( '/^(?!.*\/\.\.(?:\/.*|$))[a-zA-Z0-9_\-\.\/\\\\]+$/', $corefile_regex ) ) {
      error_log( 'Invalid core file "' . $corefile . '"' );
      zipurDiffError( 'Invalid core file' );
    }

    if ( ! empty( $config['cep_files'] ) && ! empty( $config['cep_files']['root'] ) && file_exists( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php' ) ) {

      // on the site this inclusion is before starting session, may generate warnings in this context
      ob_start(); // start output buffering to suppress warnings
      require( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php' );
      ob_end_clean(); // end output buffering and discard any warnings
      $cep_version = file_get_contents( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'version.php' );
      $cep_version = trim( $cep_version );

      /* if ( version_compare( '1.0.8.0', trim( $cep_version ) ) <= 0 ) {
          $zippath = 'PhoenixCart-';
      } else {
          $zippath = 'CE-Phoenix-';
      } */

      // echo 'add processing code for ' . htmlspecialchars( $filename ) . ' here';
      $filename = ltrim( $filename, '/\\' );
      $core_filename = ltrim( $corefile, '/\\' );
      $admin_path = ltrim( str_replace( $config['cep_files']['root'], '', $config['cep_files']['admin'] ), '/\\' );
      //error_log( 'Admin path: ' . $admin_path );
      //error_log( 'Filename: ' . $filename );
      if (strpos( $core_filename, $admin_path ) === 0) {
        $core_filename = 'admin' . substr( $core_filename, strlen( $admin_path ) );
      }

      $site_file = $config['cep_files']['root'] . DIRECTORY_SEPARATOR . $filename;
      //$core_file = 'inc' . DIRECTORY_SEPARATOR . 'clean_core' . DIRECTORY_SEPARATOR . $zippath . $cep_version . DIRECTORY_SEPARATOR . $core_filename;
      $core_file = $corepath . DIRECTORY_SEPARATOR . $core_filename;

      //error_log( 'Site file: ' . $site_file );
      //error_log( 'Core file: ' . $core_file );

      $site_code = file_exists( $site_file ) ? file_get_contents( $site_file ) : "<?php\n// Site file not found '$site_file'\n";
      // in case the site file has windows line endings, change them to unix line endings
      $site_code = str_replace("\r\n", "\n", $site_code);
      $core_code = file_exists( $core_file ) ? file_get_contents( $core_file ) : "<?php\n// Core file not found '$core_file'\n";
      // for consistency, do the same for core files, just in case...
      $core_code = str_replace("\r\n", "\n", $core_code);

      echo json_encode(['oldCode' => $core_code, 'newCode' => $site_code], JSON_PARTIAL_OUTPUT_ON_ERROR);
/*
oldCode = escapeHTML(`<?= $core_code ?>`);
newCode = escapeHTML(`<?= $site_code ?>`);
oldCode = `<?= htmlspecialchars($core_code) ?>`;
newCode = `<?= htmlspecialchars($site_code) ?>`;
*/ /*
      ?>
oldCode = `<?= $core_code ?>`;
newCode = `<?= $site_code ?>`;
      <?php
*/
    } else {
        zipurDiffError( 'CEP Files Not Found' );
    }

