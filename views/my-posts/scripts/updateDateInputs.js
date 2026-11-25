const dateFrom = document.querySelector("#dateFrom");
const dateTo = document.querySelector("#dateTo");

function updateDateTo() {
    if (dateTo.value === "") {
        dateTo.value = dateFrom.value;
        dateTo.required = true;
    }

    if (dateFrom.value === "" && dateTo.value === "") {
        dateFrom.required = false;
        dateTo.required = false;
    }
}

function updateDateFrom() {
    if (dateFrom.value === "") {
        dateFrom.value = dateTo.value;
        dateFrom.required = true;
    }

    if (dateFrom.value === "" && dateTo.value === "") {
        dateFrom.required = false;
        dateTo.required = false;
    }
}