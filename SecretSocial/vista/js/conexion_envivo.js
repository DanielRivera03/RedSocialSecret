function updateConnectionStatus() {
    fetch('../controlador/cUpdateStatus.php')
        .then(response => response.json())
        .catch(err => console.error('Error updating status:', err));
}
// Update immediately on load
updateConnectionStatus();
// And every 60 seconds
setInterval(updateConnectionStatus, 60000);
