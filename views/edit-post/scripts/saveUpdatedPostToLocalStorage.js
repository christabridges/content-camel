function saveUpdatedPostToLocalStorage() {
    const titleInput = document.querySelector(".container__title-input");
    const title = titleInput.value;
    const contentInput = document.querySelector(".container__content-input");
    const content = contentInput.value;
    const categoryInput = document.querySelector(".form__select-category");
    const category = categoryInput.value;
    const isPostedInput = document.querySelector(".form__select-is-posted");
    const isPosted = isPostedInput.value;
    localStorage.setItem("title", title);
    localStorage.setItem("content", content);
    localStorage.setItem("category", category);
    localStorage.setItem("isPosted", isPosted);
}