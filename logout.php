<?php
    require_once("include/common_include.php") ;

    unset($_SESSION["belepett_user"]) ;
    header('Location: login.php');
    exit;                        
?>    