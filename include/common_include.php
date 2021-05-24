<?php
  define("MUNKAKONYVTAR", getcwd() . "/") ;

  spl_autoload_register(function ($className) {
    require_once(str_replace('\\', '/', $className).".php");
  });

  session_name("orarend");
  session_start() ;

  if (!isset($_SESSION["belepett_user"]) && substr($_SERVER["PHP_SELF"], strrpos($_SERVER["PHP_SELF"], "/") + 1) != "login.php") {
    header('Location: login.php');
    exit;
  }
?>