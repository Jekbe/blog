<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: Login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draw&play</title>
    <link rel="stylesheet" href="Style.css"> <!-- Załącz plik CSS -->
</head>
<body>
    <header>
        <h1>Draw&play</h1>
        <?php
        // Sprawdź, czy użytkownik jest zalogowany i artystą, jeśli tak, wyświetl przycisk "Dodaj post".
        //if ($user_is_artist) {
            //echo '<a href="add_post.php" class="button">Dodaj post</a>';
        //}
        ?>
        <a href="logout.php" class="button">Wyloguj się</a>
    </header>

    <section class="latest-posts">
        <h2>Najnowsze od obserwowanych</h2>
        <?php
        $conn = new mysqli("localhost", "root", "", "dzbanyv2db");
        if ($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
        }
        ?>
    </section>

    <section class="all-posts">
        <h2>Wszystkie posty</h2>
        <?php
        
        ?>
    </section>
</body>
</html>
