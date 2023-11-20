<?php
$conn = new mysqli("localhost", "root", "", "blog");
    if ($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

if (isset($_POST["nick"])) {
    echo "is set";
    $login = $_POST["nick"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $is_artist = isset($_POST["is_artist"]) ? 1 : 0;

    $hashed_password = md5($password);
    $sql = "INSERT INTO Uzytkownicy (Nick, Adres_email, Haslo, Jest_artysta) VALUES ('$login', '$email', '$hashed_password', '$is_artist')";
    echo $sql;
    $result = $conn->query($sql);

    if ($result) {
        echo "<div class='form'>
            <h3>Zostałeś pomyślnie zarejestrowany.</h3><br/>
            <p class='link'>Kliknij tutaj, aby się <a href='Login.php'>zalogować</a></p>
            </div>";
    } else {
        echo "<div class='form'>
            <h3>Nie wypełniłeś wymaganych pól lub wystąpił błąd.</h3><br/>
            <p class='link'>Kliknij tutaj, aby ponowić próbę <a href='Register.php'>rejestracji</a>.</p>
            </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="container">
        <h1>Rejestracja</h1>
        <form action="Register.php" method="POST">
            <div class="form-group">
                <label for="name">Nick:</label>
                <input type="text" id="name" name="nick" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>
          <div class="form-group">
                <input type="checkbox" id="is_artist" name="is_artist">
                <label for="is_artist">Jestem artystą</label>
            </div>
            <div class="form-group">
                <button type="submit">Zarejestruj</button>
            </div>
        </form>
        <p>Masz już konto? <a href="Login.php">Zaloguj się</a></p>
    </div>
</body>
</html>
