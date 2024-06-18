<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $od_id = $_SESSION['id'];
    $do_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["opis"])) {
        if (!empty($_FILES["przyklad"])){
            $sciezka = "Zamowienia/" . basename($_FILES["przyklad"]["name"]);
            $imageFileType = strtolower(pathinfo($sciezka, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["przyklad"]["tmp_name"]);

            if ($check === false) echo "Plik nie jest obrazem.";
            elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) echo "Przepraszamy, tylko pliki JPG, JPEG, PNG i GIF są dozwolone.";
            elseif (move_uploaded_file($_FILES['przyklad']['tmp_name'], $sciezka)){
                $opis = $_POST["opis"];

                $sql_wyslij = "INSERT INTO zamowienia (Od, Do, Opis, Przyklad) VALUES ($od_id, $do_id, '$opis', '$sciezka')";
                $conn->query($sql_wyslij);
            }
        }

        header("Location: Profil.php?id=$od_id");
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
    <title>Złóż zamówienie</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>
<body>
    <?php include '../Additional/Header.php' ?>

    <section class="zamow container">
        <h3>Złóż zamowienie</h3>
        <form action="Zamow.php?id=<?php echo $do_id ?>" method="POST" enctype="multipart/form-data">
            <div class='form-group'>
                <label for='opis'>Opis:</label>
                <textarea id='opis' name='opis' rows='4' required></textarea>
            </div>
            <div class="form-group">
                <label for="przyklad">Prześlij przykłd:</label>
                <input type="file" name="przyklad" id="przyklad">
            </div>
            <div class='form-group'>
                <button id="sButton" type='submit'>Złóż zamowienie</button>
            </div>
        </form>
    </section>

    <section class="powrot container">
        <a href="Profil.php?id=<?php echo $od_id?>">Powrót</a>
    </section>
</body>
</html>

<?php $conn->close();
