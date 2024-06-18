<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $sesja_id = $_SESSION["id"];
    $sesja_wiek = $_SESSION["pelnoletni"];
    $profil_id = $_GET["id"];
    $sql_profil = "SELECT * FROM Uzytkownicy WHERE ID=$profil_id";
    $result_profil = $conn->query($sql_profil);
    $row_profil = $result_profil->fetch_assoc();
    $profil_nick = $row_profil['Nick'];
    $profil_status = $row_profil['Jest_artysta'];
    $dodatkowe = $row_profil['Dodatkowe'];

    $sql_obserwujacy = "SELECT COUNT(ID_obserwujacego) AS liczba_obserwujacych FROM Obserwowani WHERE ID_obserwowanego = $profil_id";
    $result_obserwujacy = $conn->query($sql_obserwujacy);

    $sql_posty = $sesja_wiek? "SELECT * FROM Posty WHERE ID_autora=$profil_id ORDER BY Data_utworzenia DESC": "SELECT * FROM Posty WHERE ID_autora=$profil_id AND Oznaczenie_18plus = FALSE ORDER BY Data_utworzenia DESC";
    $result_posty = $conn->query($sql_posty);

    $sql_obserwuje = "SELECT * FROM Obserwowani WHERE ID_obserwujacego=$sesja_id AND ID_obserwowanego=$profil_id";
    $result_obserwuje = $conn->query($sql_obserwuje);

    $posty_fun = function($posty, $nick){
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
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link rel="stylesheet" href="../Style/Style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../Skrypty/Zmien_wiek.js"></script>
    <script src="../Skrypty/Obserwuj.js"></script>
</head>
<body>
    <?php include '../Additional/Header.php' ?>

    <section class="info container">
        <?php
            if ($sesja_id === $profil_id) echo "<h2>Mój profil</h2>";
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

    <section class="dodatkowe container">
        <h3>Dodatkowe informacje</h3>
        <?php
            echo "$dodatkowe <br>";
            if ($sesja_id === $profil_id) echo "<a href='Edytuj_dodatkowe.php?id=$profil_id'>edytuj dodatkowe</a>";
        ?>
    </section>

    <section class="opcje container">
        <h3>Opcje</h3>
        <?php if ($sesja_id === $profil_id): ?>
            <a href='Zmien_awatar.php'>Zmień awatar</a> <br>
            <?php if ($row_profil["Pelnoletni"]): ?>
                <a id='zmienWiek' onclick='zmien_wiek(0)'>Wyłącz treści dla dorosłych</a> <br>
            <?php else: ?>
                <a id='zmienWiek' onclick='zmien_wiek(1)'>Włącz treści dla dorosłych</a> <br>
            <?php endif ?>
            <a href='Doladuj_portfel.php?id=<?php echo $profil_id; ?>'>Doładuj portfel</a> <br>
            <a href='Wiadomosci.php'>Wiadomości</a>
        <?php elseif ($profil_status): ?>
            <?php if ($result_obserwuje->num_rows == 0): ?>
                <a id='obserwuj' onclick='obserwuj(<?php echo $profil_id; ?>, 1)'>Obserwuj</a><br>
            <?php else: ?>
                <a id='obserwuj' onclick='obserwuj(<?php echo $profil_id; ?>, 0)'>Przestań obserwować</a><br>
            <?php endif ?>
            <a href='Zamow.php?id=<?php echo $profil_id; ?>'>Złóż zamówienie</a>
        <?php endif ?>

    </section>

    <?php if ($profil_status): ?>
        <section class='Posty container'>
            <h3>Posty użytkownika</h3>
            <?php $posty_fun($result_posty, $profil_nick); ?>
        </section>
    <?php endif ?>

    <section class="powrot container">
        <a href="../Index.php">Powrót</a>
    </section>
</body>
</html>

<?php $conn->close();
