<?php
    global $conn;

    include 'Additional/Session.php';
    include 'Additional/Database con.php';

    $id = $_SESSION['id'];
    $post_id = $_GET['id'];
    $value = $_GET['value'];

    $sql = $value? "INSERT INTO Polubienia VALUES ($id, $post_id)" : "DELETE FROM Polubienia WHERE ID_postu = $post_id AND ID_uzytkownika = $id";
    $conn->query($sql);
    echo json_encode(array('success' => true));

    $conn->close();
    exit;
