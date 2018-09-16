<?php 

function loadClass($classname){
    //define class directory
    $classdir = 'classes';
    // define root application directory
    $root = $_SERVER["DOCUMENT_ROOT"];
    
    // . to concatenate
    $classfile = strtolower($classname) . '.class.php';
    //include the class file from class direcotry
    include($root . '/' . $classdir . '/' . $classfile);
}

//register loadClass as a classloader
spl_autoload_register("loadClass");
?>