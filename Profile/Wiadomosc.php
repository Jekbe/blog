<?php
global $conn;

include '../Additional/Session.php';
include '../Additional/Database con.php';

$user_id = $_SESSION['id'];
$message_id = $_GET['id'];

// Pobierz szczegóły zamówienia
$sql = "SELECT * FROM Zamowienia WHERE ID = '$message_id'";
$result = $conn->query($sql);
$message = $result->fetch_assoc();

// Obsługa formularza
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    switch ($action) {
        case 'accept_order':
            $kwota = $_POST['kwota'];
            $sql = "UPDATE Zamowienia SET Status = 1, kwota = '$kwota' WHERE ID = '$message_id'";
            $conn->query($sql);
            break;
        case 'reject_order':
            $sql = "UPDATE Zamowienia SET Status = -1 WHERE ID = '$message_id'";
            $conn->query($sql);
            break;
        case 'approve_payment':
            $sql = "SELECT saldo FROM Users WHERE id = '$user_id'";
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();
            if ($user['saldo'] >= $message['kwota']) {
                $conn->query("UPDATE Users SET saldo = saldo - '{$message['kwota']}' WHERE id = '$user_id'");
                $conn->query("UPDATE Zamowienia SET Status = 2 WHERE ID = '$message_id'");
            } else {
                echo "Niewystarczające środki na koncie.";
            }
            break;
        case 'send_art':
            $plik = $_POST['plik'];
            $sql = "UPDATE Zamowienia SET Status = 3, Przyklad = '$plik' WHERE ID = '$message_id'";
            $conn->query($sql);
            $conn->query("UPDATE Users SET saldo = saldo + '{$message['kwota']}' WHERE id = '{$message['Od']}'");
            break;
        case 'request_refund':
            // Logika do obsługi zwrotu środków
            break;
    }
    // Odśwież stronę po wykonaniu akcji
    header("Location: Wiadomosc.php?id=$message_id");
    exit();
}
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Szczegóły wiadomości</title>
    <link rel="stylesheet" href="../Style/Style.css">
</head>
<body>
<?php include '../Additional/Header.php' ?>

<section class="wiadomosc container">
    <h3>Szczegóły wiadomości</h3>
    <p><strong>ID:</strong> <?php echo $message['ID']; ?></p>
    <p><strong>Od:</strong> <?php echo $message['Od']; ?></p>
    <p><strong>Do:</strong> <?php echo $message['Do']; ?></p>
    <p><strong>Opis:</strong> <?php echo $message['Opis']; ?></p>
    <p><strong>Status:</strong>
        <?php
        $status = match ($message['Status']) {
            0 => "Oczekuje",
            -1 => "Odrzucone",
            1 => "Zaakceptowane",
            2 => "Opłacone",
            3 => "Zrealizowane",
            default => "Nieznany"
        };
        echo $status;
        ?>
    </p>
    <?php if ($message['Status'] == 0 && $message['Do'] == $user_id): ?>
        <form method="post">
            <label for="kwota">Podaj kwotę:</label>
            <input type="number" id="kwota" name="kwota" required>
            <button type="submit" name="action" value="accept_order">Akceptuj zamówienie</button>
            <button type="submit" name="action" value="reject_order">Odrzuć zamówienie</button>
        </form>
    <?php elseif ($message['Status'] == 1 && $message['Od'] == $user_id): ?>
        <form method="post">
            <button type="submit" name="action" value="approve_payment">Zgódź się na kwotę</button>
            <button type="submit" name="action" value="reject_order">Odrzuć zamówienie</button>
        </form>
    <?php elseif ($message['Status'] == 2 && $message['Do'] == $user_id): ?>
        <form method="post">
            <label for="plik">Podaj link do pliku:</label>
            <input type="text" id="plik" name="plik" required>
            <button type="submit" name="action" value="send_art">Wyślij gotowy plik</button>
        </form>
    <?php elseif ($message['Status'] == 3 && $message['Od'] == $user_id): ?>
        <p>Gotowy plik: <a href="../Images/<?php echo $message['Przyklad']; ?>" download>Pobierz</a></p>
        <form method="post">
            <button type="submit" name="action" value="request_refund">Złóż zażalenie i prośbę o zwrot środków</button>
        </form>
    <?php endif ?>
</section>

<section class="powrot container">
    <a href="../Index.php">Powrót</a>
</section>
</body>
</html>

<?php $conn->close();

