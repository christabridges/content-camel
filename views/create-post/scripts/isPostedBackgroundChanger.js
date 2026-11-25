const isPostedSelect = document.querySelector("select");
isPostedSelect.addEventListener("input", () => {
    changeIsPostedBackground();
});

function changeIsPostedBackground() {
    if (isPostedSelect.value === "0") {
        isPostedSelect.style.backgroundColor = "#FFAA4D";
        isPostedSelect.style.color = "#68441E";
        isPostedSelect.style.borderColor = "#68441E"
    } else {
        isPostedSelect.style.backgroundColor = "#77DD77";
        isPostedSelect.style.color = "#213B21";
        isPostedSelect.style.borderColor = "#213B21";
    }
}