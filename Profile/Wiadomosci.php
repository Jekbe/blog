<?php
    global $conn;

    include '../Additional/Session.php';
    include '../Additional/Database con.php';

    $id = $_SESSION['id'];

    $sql = "SELECT * FROM Zamowienia WHERE Od = '$id' OR Do = '$id'";
    $result = $conn->query($sql);

    $konwersacje_fun = function($konwersacje) {
        echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Od</th>
                        <th>Do</th>
                        <th>Opis</th>
                        <th>Status</th>
                    </tr>";
        while ($row = $konwersacje->fetch_assoc()) {
            $id = $row["ID"];
            $od = $row["Od"];
            $do = $row["Do"];
            $opis = $row["Opis"];

            $status = match ($row['Status']) {
                0 => "Oczekuje",
                -1 => "Odrzucone",
                1 => "Zaakceptowane",
                2 => "Opłacone",
                3 => "Zrealizowane"
            };

            echo "<tr>
                        <td>$id</td>
                        <td>$od</td>
                        <td>$do</td>
                        <td><a href='Wiadomosc.php?id=$id'>$opis</a></td>
                        <td>$status</td>
                      </tr>";
        }
        echo "</table>";
    };
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wiadomości</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>
<body>
    <?php include '../Additional/Header.php' ?>

    <section class="wiadomosci container">
        <h3>Wiadomości</h3>
        <?php
            if ($result->num_rows > 0) $konwersacje_fun($result);
            else echo "Brak konwersacji do wyświetlenia.";
        ?>
    </section>

    <section class="powrot container">
        <a href="Profil.php?id=<?php echo $id?>">Powrót</a>
    </section>
</body>
</html>

<?php $conn->close();
