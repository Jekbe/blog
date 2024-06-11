function toggleAdultContent(value) {
    $.ajax({
        url: 'Zmien_wiek.php',
        type: 'GET',
        data: { value: value },
        success: function(response) {
            // Aktualizuj interfejs użytkownika w zależności od nowego stanu
            if (value === 1) {
                $('#toggleAdultContent').text('Wyłącz treści dla dorosłych');
                $('#toggleAdultContent').attr('onclick', 'toggleAdultContent(0)');
            } else {
                $('#toggleAdultContent').text('Włącz treści dla dorosłych');
                $('#toggleAdultContent').attr('onclick', 'toggleAdultContent(1)');
            }
        },
        error: function() {
            alert('Wystąpił błąd. Spróbuj ponownie.');
        }
    });
}
