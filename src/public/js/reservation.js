document.addEventListener("DOMContentLoaded", function() {
        const selectDateElement = document.querySelector(".reservation__date");
        const selectedDateElement = document.getElementById("selected_date");
        const selectTimeElement = document.querySelector(".reservation__time");
        const selectedTimeElement = document.getElementById("selected_time");
        const selectNumberElement = document.querySelector(".reservation__number");
        const selectedNumberElement = document.getElementById("selected_number");

        selectDateElement.addEventListener("change", function() {
            const selectedDateValue = this.value;
            selectedDateElement.innerText = selectedDateValue;
        });

        selectTimeElement.addEventListener("change", function() {
            const selectedTimeValue = this.value;
            selectedTimeElement.innerText = selectedTimeValue;
        });

        selectNumberElement.addEventListener("change", function() {
            const selectedNumberValue = this.value;
            const selectedNumberWithUnit = selectedNumberValue + '人';
            selectedNumberElement.innerText = selectedNumberWithUnit;
    });
    });