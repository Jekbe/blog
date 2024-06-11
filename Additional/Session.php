<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: /blog/Login and register/Login.php");
        exit;
    }
