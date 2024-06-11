<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $id = $_SESSION['id'];
    $profil_id = $_GET['id'];
    $value = $_GET['value'];

    $sql = $value ? "INSERT INTO Obserwowani VALUES $id, $profil_id" : "DELETE FROM Obserwowani WHERE ID_obserwujacego=$id AND ID_obserwowanego=$profil_id";
    $conn->query($sql);

    $conn->close();

    header("Location: Profil.php?id=$id");
    exit;
