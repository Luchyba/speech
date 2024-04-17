const recognition = new webkitSpeechRecognition(); // For Chrome
recognition.lang = 'en-US';

document.getElementById('startRecognition').addEventListener('click', () => {
    recognition.start();
});

recognition.onresult = function(event) {
    const transcript = event.results[0][0].transcript;
    document.getElementById('result').innerHTML = transcript;
    sendToBackend(transcript);
};

function sendToBackend(text) {
    // Send 'text' to backend PHP script using AJAX
    // Handle response from backend
    fetch('backend.php', {
        method: 'POST',
        body: JSON.stringify({ text: text }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response from backend:', data);
    })
    .catch(error => {
        console.error('Error sending data to backend:', error);
    });
}
