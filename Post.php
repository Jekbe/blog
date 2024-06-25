<?php
    global $conn;

    include 'Additional/Session.php';
    include 'Additional/Database con.php';

    $id = $_SESSION['id'];

    $post_id = $_GET['id'];

    $sql_post = "SELECT * FROM Posty WHERE ID = $post_id";
    $result_post = $conn->query($sql_post);

    if ($result_post->num_rows == 1) {
        $row_post = $result_post->fetch_assoc();
        $tytul = $row_post["Tytul_postu"];
        $tresc = $row_post["Tresc_postu"];
        $oznaczenie_18plus = $row_post["Oznaczenie_18plus"];
        $data_utworzenia = $row_post["Data_utworzenia"];
        $id_autora = $row_post["ID_autora"];

        $sql_autor = "SELECT Nick FROM Uzytkownicy WHERE ID = $id_autora";
        $result_autor = $conn->query($sql_autor);
        $row_autor = $result_autor->fetch_assoc();
        $autor = $row_autor["Nick"];

        $sql_obrazy = "SELECT Sciezka FROM Zdjecia WHERE ID_postu=$post_id";
        $result_obrazy = $conn->query($sql_obrazy);

        $sql_polubienia = "SELECT COUNT(ID_polubienia) as 'liczba_polubien' FROM Polubienia WHERE ID_postu = $post_id";
        $result_polubienia = $conn->query($sql_polubienia);
        $row_polubienia = $result_polubienia->fetch_assoc();
        $polubienia = $row_polubienia['liczba_polubien'];

        $sql_czy_lubie = "SELECT ID_polubienia FROM Polubienia WHERE ID_postu = $post_id AND ID_uzytkownika = $id";
        $result_czy_lubie = $conn->query($sql_czy_lubie);
        $row_czy_lubie = $result_czy_lubie->fetch_assoc();
    } else {
        echo "Post o podanym ID nie istnieje.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tytul; ?></title>
    <link rel="stylesheet" href="Style/Style.css">
    <script src="Skrypty/Polub.js"></script>
</head>
<body>
    <?php include 'Additional/Header.php' ?>

    <section class="post container">
        <h2><?php echo $tytul; ?></h2>
        <p>Autor: <a href='Profile/Profil.php?id=<?php echo $id_autora; ?>'><?php echo $autor; ?></a></p>
        <p>Data utworzenia: <?php echo $data_utworzenia; ?></p>
        </section>

        <?php
            if ($oznaczenie_18plus) if ($_SESSION["pelnoletni"]) {
                echo " <section class='tresc container'>
                        $tresc
                    </section>
                    <section class='zdjecia container'>";
                if ($result_obrazy->num_rows > 0) {
                    while ($row_obrazy = $result_obrazy->fetch_assoc()) {
                        echo "<img src='{$row_obrazy['Sciezka']}'>";
                    }
                    echo "</section>";
                }
                else echo "brak obrazów
                    </section>";
            } else echo "<section class=container> Zawartość posta jest przeznaczona dla osób pełnoletnich.</section>";
            else {
                echo " <section class='tresc container'>
                        $tresc
                    </section>
                    <section class='zdjecia container'>";
                if ($result_obrazy->num_rows > 0) {
                    while ($row_obrazy = $result_obrazy->fetch_assoc()) {
                        echo "<img src='{$row_obrazy['Sciezka']}'>";
                    }
                }
                else echo "brak obrazów";
                echo "</section>";
            }

            if ($_SESSION["id"] == $id_autora){
                echo "<section class='Usun container'>
                        <a href='Usun.php?id=$post_id'>Usuń post</a>
                    </section>";
            }
        ?>

    <section class="polub container">
        <h3>Polubienia</h3>
        pulubienia: <?php echo $polubienia ?>
        <?php if ($result_czy_lubie->num_rows == 0): ?>
            <a id="polubienie" onclick="polub(<?php echo $post_id ?>, 1)">Lubię to</a>
        <?php else: ?>
            <a id="polubienie" onclick="polub(<?php echo $post_id ?>, 0)">Nie lubię</a>
        <?php endif ?>
    </section>

    <section class="komentarze container">
        <h3>Komentarze</h3>
        <form action='Dodaj_komentarz.php?id=<?php echo $post_id ?>' method='POST'>
            <div class='form-group'>
                <label for='komenatarz'>Napisz komentarz:</label>
                <textarea id='komenatarz' name='komenatarz' rows='4' required></textarea>
            </div>
            <div class='form-group'>
                <button id="sButton" type='submit'>Aktualizuj</button>
            </div>
        </form>


    </section>

    <section class="powrot container">
        <a href="Index.php">Powrót</a>
    </section>
</body>
</html>

<?php $conn->close();
