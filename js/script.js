
function redirectToLogin() {
    window.location.href = "login.php";
}
function redirectToRegister(){
    window.location.href="register.php";
}
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var passwordToggle = document.getElementById("password-toggle");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggle.src = "eye-open.png"; 
    } else {
        passwordInput.type = "password";
        passwordToggle.src = "eye-close.png"; 
    }
}




function displayErrorMessage(inputFieldId, errorMessage) {
    var errorContainer = document.getElementById(inputFieldId + "-error");
    if (errorContainer) {
        errorContainer.innerHTML = errorMessage;
    }
}

function clearErrorMessage(inputFieldId) {
    var errorContainer = document.getElementById(inputFieldId + "-error");
    if (errorContainer) {
        errorContainer.innerHTML = "";
    }
}



