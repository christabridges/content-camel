const titleInput = document.querySelector(".container__title-input");
const contentInput = document.querySelector(".container__content-input");
const characterCountOutputs = document.querySelectorAll(".container__character-count");

titleInput.addEventListener("keyup", () => {
    characterCountOutputs[0].innerText = `${titleInput.value.length}/60`;
});

contentInput.addEventListener("keyup", () => {
    characterCountOutputs[1].innerText = `${contentInput.value.length}/3000`;
});