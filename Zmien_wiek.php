<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: Login.php");
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "blog");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $value = $_GET["value"];
    $id = $_SESSION["id"];
    $sql = "UPDATE Uzytkownicy SET Pelnoletni=$value WHERE ID=$id";
    $result = $conn->query($sql);

    $conn->close();

    header("Location: Profil.php?id=$id");
    exit;
