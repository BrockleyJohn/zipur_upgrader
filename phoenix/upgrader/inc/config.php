<?php 
  $config = [];
  $config_file = $inc_directory . '/config.json';
  if ( file_exists( $config_file ) && ! empty( $content = file_get_contents( $config_file ) ) ) {
    $config = json_decode( $content, true );
  }
  