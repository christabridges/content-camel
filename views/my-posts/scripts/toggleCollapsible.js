function toggleCollapsible() {
    event.preventDefault();
    const icon = document.querySelector(".advanced__collapsible-icon");
    const advancedSearch = document.querySelector(".advanced__inputs");
    
    if (icon.classList.contains("fa-angle-down")) {
        icon.classList.remove("fa-angle-down");
        icon.classList.add("fa-angle-up");
        advancedSearch.style.display = "flex";
        if (window.innerWidth < 660) {
            $(".container__results").css("margin-top", "320px");
        } else if (window.innerWidth < 1340) {
            $(".container__results").css("margin-top", "280px");
        } else {
            $(".container__results").css("margin-top", "150px");
        }
    } else {
        icon.classList.remove("fa-angle-up");
        icon.classList.add("fa-angle-down");
        $(".container__results").css("margin-top", "60px");
        advancedSearch.style.display = "none";
    }
}