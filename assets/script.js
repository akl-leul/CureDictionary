function sendMessage(event) {
    event.preventDefault(); // Prevent the default form submission

    // Gather input values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    // Prepare the request
    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, email, message }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to send message.');
        }
        return response.json();
    })
    .then(data => {
        alert(data.success); // Show success message
    })
    .catch(error => {
        alert(error.message); // Show error message
    });
}
