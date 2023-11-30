<?php
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: Login.php");
        exit;
    }
    $sesja = $_SESSION["id"];

    $conn = new mysqli("localhost", "root", "", "blog");
    if ($conn -> connect_error) die("Connection failed: " . $conn->connect_error);

    $profil_id = $_GET["id"];
    $sql_profil = "SELECT * FROM Uzytkownicy WHERE ID=$profil_id";
    $result_profil = $conn->query($sql_profil);
    $row_profil = $result_profil->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <header class="container">
        <h1>Draw&play</h1>
        <?php
            $nick = $_SESSION["nick"];
            $awatar = $_SESSION["awatar"];
            echo "<a href='Profil.php?id={$_SESSION['id']}'>$nick <img src='$awatar' width='20px'></a> <br>";
        ?>
        <a href="Logout.php" class="button">Wyloguj się</a>
    </header>

    <section class="info container">
        <?php
            if ($_SESSION['id'] === $profil_id) echo "<h2>Mój profil</h2>";
        ?>
        <h3>Informacje</h3>
        <img src="<?php echo $row_profil['Awatar']?>">
        <br>
        <?php
            echo $row_profil["Nick"], "<br>";
            echo "Jest z nami od: ", $row_profil["Data_rejestracji"], "<br>";
        ?>
    </section>

    <section class="opcje container">
        <h3>Opcje</h3>
        <?php
            if ($_SESSION["id"] === $profil_id){
                echo "<a href='Zmien_awatar.php'>Zmień awatar</a> <br>";
                echo $row_profil["Pelnoletni"];
                if ($row_profil["Pelnoletni"]) echo "<a href='Zmien_wiek.php?value=0'>Wyłącz treści dla dorosłych</a>";
                else echo "<a href='Zmien_wiek.php?value=1'>Włącz treści dla dorosłych</a>";
                echo "<br> <a href='Doladuj_portfel.php'>Doładuj portfel</a>";
            } else{
                $sql_obserwuje = "SELECT * FROM Obserwowani WHERE ID_obserwujacego=$sesja AND ID_obserwowanego=$profil_id";
                $result_obserwuje = $conn->query($sql_obserwuje);
                if ($result_obserwuje->num_rows == 0) echo "<a href='Obserwuj.php?id=$profil_id'>Obserwuj</a>";
                else echo "<a href='Obserwuj.php?id=$profil_id'>przestań obserwować</a>";
            }

            echo "<br>Zaloguj się ponownie aby zastosować!"
        ?>
    </section>

    <section class="Posty container">
        <h3>Posty użytkownika</h3>

    </section>

    <section class="powrot container">
        <a href="Index.php">Powrót</a>
    </section>
</body>
</html>