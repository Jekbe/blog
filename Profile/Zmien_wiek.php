<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $value = $_GET["value"];
    $id = $_SESSION["id"];

    $sql = "UPDATE Uzytkownicy SET Pelnoletni=$value WHERE ID=$id";
    $conn->query($sql);
    $_SESSION["pelnoletni"] = $value;
    echo json_encode(array('success' => true));

    $conn->close();
    exit;
