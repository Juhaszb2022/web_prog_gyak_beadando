function showLogin() {
    document.getElementById("login-form").style.display = "block";
    document.getElementById("register-form").style.display = "none";
}

function showRegister() {
    document.getElementById("login-form").style.display = "none";
    document.getElementById("register-form").style.display = "block";
}

// Automatikus váltás URL alapján
window.addEventListener('DOMContentLoaded', () => {
    if (window.location.hash === "#register") {
        showRegister();
    } else {
        showLogin();
    }
});
