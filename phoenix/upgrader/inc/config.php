<?php
// Store configuration as PHP so it cannot be downloaded as static JSON.
$config = [];
$state_file = __DIR__ . '/config_state.php';
$legacy_file = __DIR__ . '/config.json';

if (is_file($state_file)) {
    $loaded_config = require $state_file;
    if (!is_array($loaded_config)) {
        throw new RuntimeException('Invalid upgrader configuration.');
    }
    $config = $loaded_config;
} elseif (is_file($legacy_file)) {
    $loaded_config = json_decode((string) file_get_contents($legacy_file), true);
    if (!is_array($loaded_config)) {
        throw new RuntimeException('Invalid legacy upgrader configuration.');
    }
    $config = $loaded_config;
    zipurWriteConfig($config); // Delete the exposed JSON file on migration.
}
