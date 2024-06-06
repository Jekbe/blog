<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $sesja = $_SESSION["id"];
    $profil_id = $_GET["id"];
    $sql_profil = "SELECT * FROM Uzytkownicy WHERE ID=$profil_id";
    $result_profil = $conn->query($sql_profil);
    $row_profil = $result_profil->fetch_assoc();
    $profil_nick = $row_profil['Nick'];

    $sql_obserwujacy = "SELECT COUNT(ID_obserwujacego) AS liczba_obserwujacych FROM Obserwowani WHERE ID_obserwowanego = $profil_id";
    $result_obserwyjacy = $conn->query($sql_obserwujacy);

    $sql_posty = "SELECT * FROM Posty WHERE ID_autora=$profil_id ORDER BY Data_utworzenia DESC";
    $result_posty = $conn->query($sql_posty);

    $sql_obserwuje = "SELECT * FROM Obserwowani WHERE ID_obserwujacego=$sesja AND ID_obserwowanego=$profil_id";
    $result_obserwuje = $conn->query($sql_obserwuje);

    $posty_fun = function($posty, $conn) :void
    {
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

            $sql_nick = "SELECT Nick FROM Uzytkownicy WHERE ID=$id_autora";
            $result_nick = $conn->query($sql_nick);
            $row_nick = $result_nick->fetch_assoc();
            $nick = $row_nick["Nick"];


            echo "<tr>
                    <td>$id</td>
                    <td><a href='../Post.php?id=$id'>$tytul</a></td>
                    <td><a href='Profil.php?id=$id_autora'>$nick</a></td>
                    <td>$data</td>
                    </tr>";
        }
        echo "</table>";
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>
<body>
    <?php include '../Additional/Header.php' ?>

    <section class="info container">
        <?php
            if ($sesja === $profil_id) echo "<h2>Mój profil</h2>";
        ?>
        <h3>Informacje</h3>
        <img src="<?php echo $row_profil['Awatar']?>">
        <br>
        <?php
            echo $profil_nick, "<br>";
            echo "Jest z nami od: ", $row_profil["Data_rejestracji"], "<br>";
            if ($row_profil["Pelnoletni"]) echo "Użytkownik Zweryfikowany <br>";
            else echo "Użytkownik niepołnoletni <br>";
        ?>
    </section>

    <section class="opcje container">
        <h3>Opcje</h3>
        <?php
            if ($sesja === $profil_id){
                echo "<a href='Zmien_awatar.php'>Zmień awatar</a> <br>";
                if ($row_profil["Pelnoletni"]) echo "<a href='Zmien_wiek.php?value=0'>Wyłącz treści dla dorosłych</a>";
                else echo "<a href='Zmien_wiek.php?value=1'>Włącz treści dla dorosłych</a>";
                echo "<br> <a href='Doladuj_portfel.php?id=$profil_id'>Doładuj portfel</a>";
            } else{
                if ($result_obserwuje->num_rows == 0) echo "<a href='Obserwuj.php?id=$profil_id'>Obserwuj</a>";
                else echo "<a href='Obserwuj.php?id=$profil_id'>przestań obserwować</a>";
            }
        ?>
    </section>

    <section class="Posty container">
        <h3>Posty użytkownika</h3>
        <?php
            $posty_fun($result_posty, $conn)
        ?>
    </section>

    <section class="powrot container">
        <a href="../Index.php">Powrót</a>
    </section>
</body>
</html>