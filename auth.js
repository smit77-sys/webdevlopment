document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('auth.php');
        const data = await response.json();

        // If user is not authenticated, redirect to login page
        if (!data.authenticated) {
            window.location.href = 'login.html';
        }
    } catch (error) {
        console.error('Authentication check failed:', error);
        // Fail safe: redirect to login if the check fails
        window.location.href = 'login.html';
    }
});