<?php
/**
 * Extension to class_index 
 * so that we can check if core classes have been overridden
 * 
 * Upgrader Addon
 * author: John Ferguson @BrockleyJohn phoenix@cartmart.uk
 * copyright: SE Websites 2026
 * released under the MIT License without warranty express or implied
 */

class upgrader_class_index extends class_index {

  public function __construct(class_index $phoenix_index) {
    // do not call parent constructor but copy properties
    foreach (get_object_vars($phoenix_index) as $property => $value) {
      $this->$property = $value;
    }
  }

  public function class_is_overridden($original_class, $core_file) {
    $class = $this->normalize_class_name($original_class);
    return isset($this->files[$class]) && $this->files[$class] !== $core_file;
  }
}