function savePostToLocalStorage(title, content, category, isPosted) {
    localStorage.setItem("title", title);
    localStorage.setItem("content", content);
    localStorage.setItem("category", category);
    localStorage.setItem("isPosted", isPosted);
}
