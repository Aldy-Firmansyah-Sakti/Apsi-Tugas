// Real-time clock for admin panel
function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const timeString = `${hours}.${minutes}`;
    
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Initialize real-time clock
document.addEventListener('DOMContentLoaded', function() {
    // Update immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { updateTime };
}