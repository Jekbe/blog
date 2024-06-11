<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $profil_id = $_GET["id"];

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["awatar"])){
        if (!empty($_FILES["awatar"])) {
            $sciezka = '/blog/Profile/Awatary/'. basename($_FILES["awatar"]["name"]);
            $imageFileType = strtolower(pathinfo($sciezka, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["awatar"]["tmp_name"]);

            if ($check === false) echo "Plik nie jest obrazem.";
            elseif ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png" && $imageFileType !== "gif") echo "Przepraszamy, tylko pliki JPG, JPEG, PNG i GIF są dozwolone.";
            elseif (move_uploaded_file($_FILES['awatar']['tmp_name'], $sciezka)){
                $sql = "UPDATE Uzytkownicy SET Awatar = $sciezka WHERE id = $profil_id";
                $conn->query($sql);
                $_SESSION["awatar"] = $sciezka;
            }
        }

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
    <title>Zmień awatar</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>
<body>
    <?php include '../Additional/Header.php' ?>

    <section class="container">
        <h2>Zmień awatar</h2>
        <form action="Zmien_awatar.php" method="post" enctype="multipart/form-data">
            <label for="awatar">Wybierz nowy awatar:</label>
            <input type="file" name="awatar" id="awatar">
            <input type="submit" value="Zmień awatar" name="submit">
        </form>
    </section>
</body>
</html>

<?php $conn->close();
