<?php 
  $config = [];
  $config_file = $inc_directory . '/config.json';
  if ( file_exists( $config_file ) ) {
    $config = json_decode( file_get_contents( $config_file ), true );
  }
  