window.addEventListener("resize", () => {
    const icon = document.querySelector(".advanced__collapsible-icon");

    if (icon.classList.contains("fa-angle-up")) {
        if (window.innerWidth < 660) {
            $(".container__results").css("margin-top", "320px");
        } else if (window.innerWidth < 1340) {
            $(".container__results").css("margin-top", "280px");
        } else {
            $(".container__results").css("margin-top", "150px");
        }
    } else {
        $(".container__results").css("margin-top", "60px");
    }
});