(function () {
    "use strict";

    // Litepicker Initialization
    $(".datepicker").each(function () {
        let options = {
            autoApply: false,
            singleMode: false,
            numberOfColumns: 2,
            numberOfMonths: 2,
            showWeekNumbers: true,
            format: "D MMM, YYYY",
            dropdowns: {
                minYear: 1990,
                maxYear: null,
                months: true,
                years: true,
            },
        };

        if ($(this).data("single-mode")) {
            options.singleMode = true;
            options.numberOfColumns = 1;
            options.numberOfMonths = 1;
        }

        if ($(this).data("format")) {
            options.format = $(this).data("format");
        }

        // Only set a default value if the field already has a value
        if ($(this).val() === "") {
            $(this).val("");
        }

        new Litepicker({
            element: this,
            ...options,
        });
    });
})();