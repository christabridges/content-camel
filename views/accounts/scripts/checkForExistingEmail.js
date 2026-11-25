const emailInput = document.querySelector("input[name=email]");
emailInput.addEventListener("keyup", checkForExistingEmail);


function checkForExistingEmail() {
    $.ajax({
        method: "GET", 
        url: "./checkforexistingemail.php",
        data: {
            emailAddress: $("input[name=email]").val()
        }
    })
    .done(function (response) {
        if (response === "1") {
            $("#emailExists").css("display", "block");
            emailInput.setCustomValidity("Cannot register using previously-used email");
        } else {
            $("#emailExists").css("display", "none");
            emailInput.setCustomValidity("");
        }
    });
}