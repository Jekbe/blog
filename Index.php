<?php
    global $conn;

    include 'Additional/Session.php';
    include 'Additional/Database con.php';

    $artysta = $_SESSION["artist"];
    $user = $_SESSION["id"];
    $dorosly = $_SESSION["pelnoletni"];
    $searchQuery = $_GET['search'] ?? '';

    $sql_obserwowani = $dorosly ? "SELECT P.ID, P.Tytul_postu, P.Data_utworzenia, P.ID_autora, U.Nick FROM Posty P JOIN Uzytkownicy U ON P.ID_autora = U.ID WHERE P.ID_autora IN (SELECT ID_obserwowanego FROM Obserwowani WHERE ID_obserwujacego = $user) AND P.Tytul_postu LIKE '%$searchQuery%' ORDER BY P.Data_utworzenia DESC LIMIT 10" : "SELECT P.ID, P.Tytul_postu, P.Data_utworzenia, P.ID_autora, U.Nick FROM Posty P JOIN Uzytkownicy U ON P.ID_autora = U.ID WHERE P.ID_autora IN (SELECT ID_obserwowanego FROM Obserwowani WHERE ID_obserwujacego = $user) AND P.Oznaczenie_18plus = false AND P.Tytul_postu LIKE '%$searchQuery%' ORDER BY P.Data_utworzenia DESC LIMIT 10";
    $result_obserwowani = $conn->query($sql_obserwowani);

    $sql_all_posty = $dorosly ? "SELECT P.ID, P.Tytul_postu, P.Data_utworzenia, P.ID_autora, U.Nick FROM Posty P JOIN Uzytkownicy U ON P.ID_autora = U.ID WHERE P.Tytul_postu LIKE '%$searchQuery%' ORDER BY P.Data_utworzenia DESC" : "SELECT P.ID, P.Tytul_postu, P.Data_utworzenia, P.ID_autora, U.Nick FROM Posty P JOIN Uzytkownicy U ON P.ID_autora = U.ID WHERE P.Oznaczenie_18plus = false AND P.Tytul_postu LIKE '%$searchQuery%' ORDER BY P.Data_utworzenia DESC";
    $result_all_posty = $conn->query($sql_all_posty);

    $posty_fun = function($posty) {
        echo "<table>
                <tr><th>id</th><th>tytuł</th><th>autor</th><th>data</th></tr>";
        while ($row = $posty->fetch_assoc()) {
            $id = $row["ID"];
            $tytul = $row["Tytul_postu"];
            $data = $row["Data_utworzenia"];
            $autor = $row["Nick"];
            $id_autora = $row["ID_autora"];

            echo "<tr><td>$id</td><td><a href='Post.php?id=$id'>$tytul</a></td><td><a href='Profile/Profil.php?id=$id_autora'>$autor</a></td><td>$data</td></tr>";
        }
        echo "</table>";
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona główna</title>
    <link rel="stylesheet" href="Style/Style.css">
</head>
<body>
    <?php include 'Additional/Header.php' ?>

    <section class="szukaj container">
        <form action="Index.php" method="GET">
            <label for="text">Podaj frazę:</label>
            <input id="text" type="text" name="search" placeholder="Szukaj postów po tytule" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Szukaj</button>
        </form>
    </section>

    <section class="dodaj_post container">
        <?php if ($artysta) echo "<a href='Dodaj_post.php'>Dodaj post</a>" ?>
    </section>

    <section class="latest-posts container">
        <h2>Najnowsze od obserwowanych</h2>
        <?php
            if ($result_obserwowani->num_rows > 0) $posty_fun($result_obserwowani);
            else echo "Brak postów do wyświetlenia";
        ?>
    </section>

    <section class="all-posts container">
        <h2>Wszystkie posty</h2>
        <?php
            if ($result_all_posty->num_rows > 0) $posty_fun($result_all_posty);
            else echo "Brak postów do wyświetlenia"
        ?>
    </section>
</body>
</html>

<?php $conn->close();
