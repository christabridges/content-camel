function doSearch() {
    const icon = document.querySelector(".advanced__collapsible-icon");

    if (event !== undefined) {
        event.preventDefault();
    }

    $.ajax({
        method: "GET", 
        url: "getposts.php",
        data: { 
            searchValue: $("#searchValue").val(),
            dateFrom: $("#dateFrom").val(),
            dateTo: $("#dateTo").val(),
            isPosted: $("#isPosted").val(),
            category: $("#category").val()
        }
    })
    .done(function (response) {
        $(".container__results").html(response);

        if (icon.classList.contains("fa-angle-up")) {
            if (window.innerWidth < 660) {
                $(".container__results").css("margin-top", "320px");
            } else if (window.innerWidth < 1340) {
                $(".container__results").css("margin-top", "280px");
            } else {
                $(".container__results").css("margin-top", "150px");
            }
        } 
    });
}