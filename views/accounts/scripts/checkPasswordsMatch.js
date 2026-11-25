const passwordFields = document.querySelectorAll(".form__password-input");
const passwordErrorLabel = document.querySelector("#passwordMatch");

for (const passwordField of passwordFields) {
    passwordField.addEventListener("input", () => {
        checkPasswordsMatch();
    });
}

function checkPasswordsMatch() {
    if (passwordFields.length > 1) {
        if (passwordFields[0].value !== passwordFields[1].value) {
            passwordErrorLabel.style.display = "block";
            passwordFields[1].setCustomValidity("Passwords should match");
        } else {
            passwordErrorLabel.style.display = "none";
            passwordFields[1].setCustomValidity("");
        }
    }
}