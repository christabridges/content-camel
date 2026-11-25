function loadPost() {
    const titleInput = document.querySelector(".container__title-input");
    titleInput.value = localStorage.getItem("title");
    const contentInput = document.querySelector(".container__content-input");
    contentInput.value = localStorage.getItem("content");
    const isPostedInput = document.querySelector(".form__select-is-posted");
    isPostedInput.value = localStorage.getItem("isPosted");
    const categoryInput = document.querySelector(".form__select-category");
    categoryInput.value = localStorage.getItem("category");
    changeIsPostedBackground();

    const characterCountOutputs = document.querySelectorAll(".container__character-count");
    characterCountOutputs[0].innerText = `${titleInput.value.length}/60`;
    characterCountOutputs[1].innerText = `${contentInput.value.length}/3000`;
}