<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $value = $_GET["value"];
    $id = $_SESSION["id"];
    $sql = "UPDATE Uzytkownicy SET Pelnoletni=$value WHERE ID=$id";
    $result = $conn->query($sql);
    $_SESSION["pelnoletni"] = $value;

    $conn->close();

    header("Location: Profil.php?id=$id");
    exit;
