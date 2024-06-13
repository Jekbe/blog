function zmien_wiek(value) {
    $.ajax({
        url: '../Profile/Zmien_wiek.php',
        type: 'GET',
        data: {
            value: value
        },
        success(response) {
            const $selector = $('#zmienWiek');
            if (value === 1) {
                $selector.text('Wyłącz treści dla dorosłych');
                $selector.attr('onclick', 'zmien_wiek(0)')
            } else {
                $selector.text('Włącz treści dla dorosłych');
                $selector.attr('onclick', 'zmien_wiek(1)')
            }
        },
        error() {
            alert('Wystąpił błąd. Spróbuj ponownie.')
        }
    })
}
