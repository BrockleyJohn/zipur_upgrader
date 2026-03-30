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
  require $inc_directory . '/config.php';

  if ( ! empty( $config['password'] ) && $_COOKIE['zip_upgrade_pw'] == hash( 'sha256', $config['password'] )) {

    $filename = $_POST['file'] ?? '';
    $filepath = pathinfo( $filename);
    $corepath = $_POST['corepath'] ?? '';
    $corepathtest = pathinfo( $corepath );

    if ( empty( $filename ) || ! preg_match( '/^[a-zA-Z0-9_\-\/]+$/', $filepath['dirname'] ) || ! preg_match( '/^[a-zA-Z0-9_\-\.]+$/', $filepath['basename'] ) ) {
      die( 'Invalid file name "' . htmlspecialchars( $filename ) . '"' );
    }
    if ( empty( $corepath ) || ! preg_match( '/^[a-zA-Z0-9_\-\/]+$/', $corepathtest['dirname'] ) || ! preg_match( '/^[a-zA-Z0-9_\-\.]+$/', $corepathtest['basename'] ) ) {
      die( 'Invalid core path "' . htmlspecialchars( $corepath ) . '"' );
    }

    if ( ! empty( $config['cep_files'] ) && ! empty( $config['cep_files']['root'] ) && file_exists( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php' ) ) {

      require( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'configure.php' );
      $cep_version = file_get_contents( $config['cep_files']['root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'version.php' );
      $cep_version = trim( $cep_version );

      /* if ( version_compare( '1.0.8.0', trim( $cep_version ) ) <= 0 ) {
          $zippath = 'PhoenixCart-';
      } else {
          $zippath = 'CE-Phoenix-';
      } */

      // echo 'add processing code for ' . htmlspecialchars( $filename ) . ' here';
      $core_filename = $filename = ltrim( $filename, '/\\' );
      $admin_path = ltrim( str_replace( $config['cep_files']['root'], '', $config['cep_files']['admin'] ), '/\\' );
      error_log( 'Admin path: ' . $admin_path );
      error_log( 'Filename: ' . $filename );
      if (strpos( $filename, $admin_path ) === 0) {
        $core_filename = 'admin' . substr( $filename, strlen( $admin_path ) );
      }

      $site_file = $config['cep_files']['root'] . DIRECTORY_SEPARATOR . $filename;
      //$core_file = 'inc' . DIRECTORY_SEPARATOR . 'clean_core' . DIRECTORY_SEPARATOR . $zippath . $cep_version . DIRECTORY_SEPARATOR . $core_filename;
      $core_file = $corepath . DIRECTORY_SEPARATOR . $core_filename;

      error_log( 'Site file: ' . $site_file );
      error_log( 'Core file: ' . $core_file );

      $site_code = file_exists( $site_file ) ? file_get_contents( $site_file ) : "<?php\n// Site file not found '$site_file'\n";
      $core_code = file_exists( $core_file ) ? file_get_contents( $core_file ) : "<?php\n// Core file not found '$core_file'\n";
/*
oldCode = escapeHTML(`<?= $core_code ?>`);
newCode = escapeHTML(`<?= $site_code ?>`);
oldCode = `<?= htmlspecialchars($core_code) ?>`;
newCode = `<?= htmlspecialchars($site_code) ?>`;
*/
      ?>
oldCode = `<?= $core_code ?>`;
newCode = `<?= $site_code ?>`;
      <?php

    } else {
        die( 'CEP Files Not Found' );
    }

  } else {
      die( 'Unauthorized' );
  }
