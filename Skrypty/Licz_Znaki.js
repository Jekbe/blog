function checkLength() {
    const textarea = document.getElementById('info');
    const charCount = document.getElementById('charCount');
    const errorMessage = document.getElementById('errorMessage');
    const submitBtn = document.getElementById('sButton');

    if (textarea.value.length > 300) {
        errorMessage.style.display = 'block';
        submitBtn.disabled = true;
    } else {
        errorMessage.style.display = 'none';
        submitBtn.disabled = false;
    }

    charCount.textContent = textarea.value.length + "/300";
}