<?php
function file_get_php_classes($filepath) {
  $php_code = file_get_contents($filepath);
  $classes = get_php_classes($php_code);
  return $classes;
}

function get_php_classes($php_code) {
  $classes = array();
  $tokens = token_get_all($php_code);
  $count = count($tokens);
  for ($i = 2; $i < $count; $i++) {
    if (   $tokens[$i - 2][0] == T_CLASS
        && $tokens[$i - 1][0] == T_WHITESPACE
        && $tokens[$i][0] == T_STRING) {

        $class_name = $tokens[$i][1];
        $classes[] = $class_name;
    }
  }
  return $classes;
}

function load_class_map(){
  $classmap=array();

  $classes = scandir(NATURAL_CLASSES_PATH);

  foreach($classes as $class_file ){
    if($class_file!='.' && $class_file!='..' && $class_file!='.svn'){
      foreach(file_get_php_classes(NATURAL_CLASSES_PATH . $class_file) as $cl){
        $classmap[$cl]=NATURAL_CLASSES_PATH . $class_file;
      }
    }
  }
  
  $libs = scandir(NATURAL_LIB_PATH);

  foreach($libs as $lib_file ){
    if($lib_file!='.' && $lib_file!='..' && $lib_file!='.svn'){
      foreach(file_get_php_classes(NATURAL_LIB_PATH . $lib_file) as $li){
        $classmap[$li]=NATURAL_LIB_PATH . $lib_file;
      }
    }
  }
  return $classmap;
}

function __autoload($class_name) {
  $cm = load_class_map();
  $f = $cm[$class_name];
  if(file_exists($f)) {
    require_once($f);
  } else {
    throw new Exception("Unable to load $class_name from $f.");
  }
}


?>
