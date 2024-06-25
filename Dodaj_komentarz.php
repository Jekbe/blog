<?php
    global $conn;

    include 'Additional/Session.php';
    include 'Additional/Database con.php';

    $profil_id = $_SESSION["id"];
    $post_id = $_GET["id"];

    $komentarz = $_POST['komentarz'];
    $sql = "INSERT INTO Komentarze (Tresc_komentarza, ID_autora, ID_postu) VALUES ($komentarz, $profil_id, $post_id)";
    $conn->query($sql);

    header("Location: Profil.php?id=$profil_id");
    exit;
