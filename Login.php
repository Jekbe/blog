<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blog");
if ($conn -> connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_POST["email"])) {
    $login = $_POST["email"];
    $haslo = $_POST["haslo"];
    $sql = "SELECT * FROM Uzytkownicy WHERE Adres_email='$login' AND haslo='" . md5($haslo) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["login"] = $login;
        $row = $result->fetch_assoc();
        $_SESSION["id"] = $row["ID"];
        $_SESSION["artist"] = $row["Jest_artysta"];
        $_SESSION["portfel"] = $row["Portfel"];
        $_SESSION["awatar"] = $row["Awatar"];
        $_SESSION["pelnoletni"] = $row["Pelnoletni"];
        $_SESSION["nick"] = $row["Nick"];
        header("Location: Index.php");
        exit;
    }
    else echo "<div class='form'>
        <h3>Nieprawidłowy login lub hasło.</h3><br/>
        <p class='link'>Ponów próbę <a href='Login.php'>logowania</a>.</p>
        </div>";
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="Style.css"> <!-- Załącz plik CSS -->
</head>
<body>
<div class="container">
    <h1>Logowanie</h1>
    <form action="Login.php" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input type="password" id="password" name="haslo" required>
        </div>
        <div class="form-group">
            <button type="submit">Zaloguj</button>
        </div>
    </form>
    <p>Nie masz jeszcze konta? <a href="Register.php">Zarejestruj się</a></p>
</div>
</body>
</html>
