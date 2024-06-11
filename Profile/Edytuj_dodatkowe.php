<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $profil_id = $_GET["id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["info"])) {
        $info = $_POST["info"];
        $sql = "UPDATE Uzytkownicy SET Dodatkowe = '$info' WHERE ID = $profil_id";
        $conn->query($sql);

        header("Location: Profil.php?id=$profil_id");
        exit;
    }
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edytuj dodatkowe</title>
    <link rel="stylesheet" href="../Style/Style.css">
    <script src="../Skrypty/Licz_Znaki.js"></script>
</head>
<body>
    <?php include '../Additional/Header.php' ?>

    <section class="formulaz container">
        <form action='Edytuj_dodatkowe.php?id=<?php echo $profil_id?>' method='POST'>
            <div class='form-group'>
                <label for='info'>Edytuj dodatkowe informacje:</label>
                <textarea id='info' name='info' rows='5' required oninput='checkLength()'></textarea>
                <small id="charCount">0/300</small>
                <small id="errorMessage">Przekroczono limit 300 znaków!</small>
            </div>
            <div class='form-group'>
                <button id="sButton" type='submit'>Aktualizuj</button>
            </div>
        </form>
    </section>

    <section class="powrot container">
        <a href="Profil.php?id=<?php echo $profil_id?>">Powrót</a>
    </section>
</body>
</html>

<?php $conn->close();
