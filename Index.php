<?php
    global $conn;

    include 'Additional/Session.php';
    include 'Additional/Database con.php';

    $artysta = $_SESSION["artist"];
    $user = $_SESSION["id"];
    $dorosly = $_SESSION["pelnoletni"];

    $sql_obserwowani = "SELECT ID_obserwowanego FROM Obserwowani WHERE ID_obserwujacego = $user";
    $result_obserwowani = $conn->query($sql_obserwowani);

    $sql_all_posty = $dorosly ? "SELECT * FROM Posty ORDER BY Data_utworzenia DESC" : "SELECT * FROM Posty WHERE Oznaczenie_18plus = false ORDER BY Data_utworzenia DESC";
    $result_all_posty = $conn->query($sql_all_posty);

    $posty_fun = function($posty, $conn){
        echo "<table>
            <tr>
            <th>id</th>
            <th>tytuł</th>
            <th>autor</th>
            <th>data</th>
            </tr>";
        while ($row = $posty->fetch_assoc()){
            $id = $row["ID"];
            $tytul = $row["Tytul_postu"];
            $data = $row["Data_utworzenia"];
            $id_autora = $row["ID_autora"];

            $sql_autor = "SELECT Nick FROM Uzytkownicy WHERE ID = $id_autora";
            $result_autor = $conn->query($sql_autor);
            $row_autor = $result_autor->fetch_assoc();
            $autor = $row_autor["Nick"];

            echo "<tr>
                <td>$id</td>
                <td><a href='Post.php?id=$id'>$tytul</a></td>
                <td><a href='Profile/Profil.php?id=$id_autora'>$autor</a></td>
                <td>$data</td>
                </tr>";
        }
        echo "</table>";
    };

    $znajdz_obserwowanych = function ($result_obserwowani, $dorosly, $conn, $posty_fun){
        if ($result_obserwowani->num_rows > 0){
            $obserwowani = [];
            while ($row = $result_obserwowani->fetch_assoc()) $obserwowani[] = $row['ID_obserwowanego'];

            $obserwowani_str = implode(",", $obserwowani);
            $sql_posty = $dorosly ? "SELECT * FROM Posty WHERE ID_autora IN ($obserwowani_str) ORDER BY Data_utworzenia DESC LIMIT 10" : "SELECT * FROM Posty WHERE ID_autora IN ($obserwowani_str) AND Oznaczenie_18plus = false ORDER BY Data_utworzenia DESC LIMIT 10";

            $result_posty = $conn->query($sql_posty);

            if ($result_posty->num_rows > 0) $posty_fun($result_posty, $conn);
            else echo "Brak postów do wyświetlenia";
        } else echo "Nie obserwujesz nikogo";
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

    <section class="dodaj_post container">
        <?php if ($artysta) echo "<a href='Dodaj_post.php'>Dodaj post</a>" ?>
    </section>

    <section class="latest-posts container">
        <h2>Najnowsze od obserwowanych</h2>
        <?php $znajdz_obserwowanych($result_obserwowani, $dorosly, $conn, $posty_fun) ?>
    </section>

    <section class="all-posts container">
        <h2>Wszystkie posty</h2>
        <?php
            if ($result_all_posty->num_rows > 0) $posty_fun($result_all_posty, $conn);
            else echo "Brak postów do wyświetlenia"
        ?>
    </section>
</body>
</html>

<?php $conn->close();
