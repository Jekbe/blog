<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $profil_id = $_GET["id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["amount"])) {
        $amount = $_POST["amount"];
        $sql = "UPDATE Uzytkownicy SET Portfel = Portfel + $amount WHERE ID = $profil_id";
        $conn->query($sql);

        $sql_select = "SELECT Portfel FROM Uzytkownicy WHERE ID = $profil_id";
        $result = $conn->query($sql_select);
        $row = $result->fetch_assoc();
        $_SESSION["portfel"] = $row["Portfel"];

        header("Location: Profil.php?id=$profil_id");
        exit;
    }
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Doładuj portfel</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>
<body>
    <?php include '../Additional/Header.php' ?>

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

<?php $conn->close();
