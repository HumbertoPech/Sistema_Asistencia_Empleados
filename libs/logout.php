<?php 
    session_start(); 
    unset($_SESSION);
    session_destroy();
    header('location: ../pages/employes/login.html');
?>