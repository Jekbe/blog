<?php
    global $conn;

    include 'Additional/Session.php';
    include 'Additional/Database con.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $tytul = $_POST["title"];
        $tresc = $_POST["content"];
        $czy18 = isset($_POST["adult"]) ? 1 : 0;
        $autorId = $_SESSION["id"];

        $sqlPost = "INSERT INTO Posty (Tytul_postu, Tresc_postu, Oznaczenie_18plus, ID_autora, Data_utworzenia) VALUES ('$tytul', '$tresc', '$czy18', '$autorId', CURRENT_TIMESTAMP)";

        if ($conn->query($sqlPost) === TRUE) {
            $postId = $conn->insert_id;

            if (!empty($_FILES["images"]["name"][0])) {
                $lokalizacja = "Obrazki/";

                foreach ($_FILES["images"]["name"] as $key => $nazwa_pliku) {
                    $sciezka = $lokalizacja . basename($nazwa_pliku);
                    $imageFileType = strtolower(pathinfo($sciezka, PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES["images"]["tmp_name"][$key]);

                    if ($check === false) echo "Plik nie jest obrazem.";
                    elseif ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png" && $imageFileType !== "gif") echo "Przepraszamy, tylko pliki JPG, JPEG, PNG i GIF są dozwolone.";
                    elseif (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $sciezka)) {
                        $sqlImage = "INSERT INTO Zdjecia (Sciezka, ID_postu) VALUES ('$sciezka', '$postId')";
                        $conn->query($sqlImage);
                    } else echo "Wystąpił błąd podczas przesyłania pliku.";
                }
            }

            header("Location: Index.php");
            exit;
        } else echo "Error: " . $sqlPost . "<br>" . $conn->error;
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Post</title>
    <link rel="stylesheet" href="Style/Style.css">
</head>
<body>
    <?php include 'Additional/Header.php' ?>

    <section class="dodaj_post container">
        <h2>Dodaj Post</h2>
        <form action="Dodaj_post.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tytuł:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Treść:</label>
                <textarea id="content" name="content" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="adult">Oznaczenie 18+: </label>
                <input type="checkbox" id="adult" name="adult">
            </div>
            <div class="form-group">
                <label for="images">Zdjęcia:</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit">Dodaj Post</button>
            </div>
        </form>
    </section>

    <section class="powrot container">
        <a href="Index.php">Powrót</a>
    </section>
</body>
</html>
