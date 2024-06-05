<?php
    session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: Login.php");
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "blog");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $profil_id = $_GET["id"];
    $sql_profil = "SELECT * FROM Uzytkownicy WHERE ID=$profil_id";
    $result_profil = $conn->query($sql_profil);
    $row_profil = $result_profil->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["amount"])) {
        $amount = $_POST["amount"];
        $sql_doladuj_konto = "UPDATE Uzytkownicy SET Portfel = Portfel + $amount WHERE ID = $profil_id";
        $conn->query($sql_doladuj_konto);

        header("Location: Profil.php?id=$profil_id");
        exit;
    }
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

    <section class="formulaz container">
        <form action='Doladuj_portfel.php?id=<?php echo $profil_id?>' method='POST'>
            <div class='form-group'>
                <label for='amount'>Kwota doładowania:</label>
                <input type='number' id='amount' name='amount' min='1' required>
            </div>
            <div class='form-group'>
                <button type='submit'>Doładuj Konto</button>
            </div>
        </form>
    </section>

    <section class="powrot container">
        <a href="Profil.php?id=<?php echo $profil_id?>">Powrót</a>
    </section>
</body>
</html>
