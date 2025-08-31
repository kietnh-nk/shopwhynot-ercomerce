// Price formatting utility
(function ($) {
    "use strict";

    // Format number with commas
    function formatNumber(num) {
        if (num === null || num === undefined || num === "") {
            return "";
        }

        // Remove all non-numeric characters except decimal point
        let cleanNum = num.toString().replace(/[^\d.]/g, "");

        // Ensure only one decimal point
        const parts = cleanNum.split(".");
        if (parts.length > 2) {
            cleanNum = parts[0] + "." + parts.slice(1).join("");
        }

        // Split into integer and decimal parts
        const [integerPart, decimalPart] = parts;

        // Add commas to integer part
        const formattedInteger = integerPart.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            ","
        );

        // Return formatted number
        return decimalPart
            ? formattedInteger + "." + decimalPart
            : formattedInteger;
    }

    // Parse formatted number back to numeric value
    function parseFormattedNumber(formattedNum) {
        if (!formattedNum) return "";
        return formattedNum.toString().replace(/[^\d.]/g, "");
    }

    // Initialize price formatting
    function initPriceFormatting() {
        // Format existing values on page load
        $(".price-input").each(function () {
            const $input = $(this);
            const value = $input.val();
            if (value && value !== "0") {
                $input.val(formatNumber(value));
            }
        });

        // Handle input events
        $(document).on("input", ".price-input", function () {
            const $input = $(this);
            const cursorPos = $input[0].selectionStart;
            const value = $input.val();

            // Get the numeric value
            const numericValue = parseFormattedNumber(value);

            // Format the number
            const formattedValue = formatNumber(numericValue);

            // Update input value
            $input.val(formattedValue);

            // Restore cursor position (approximate)
            const newCursorPos = Math.min(cursorPos, formattedValue.length);
            $input[0].setSelectionRange(newCursorPos, newCursorPos);
        });

        // Handle focus events
        $(document).on("focus", ".price-input", function () {
            const $input = $(this);
            const value = $input.val();
            if (value) {
                // Show numeric value when focused for easier editing
                const numericValue = parseFormattedNumber(value);
                $input.data("original-value", value);
                $input.val(numericValue);
            }
        });

        // Handle blur events
        $(document).on("blur", ".price-input", function () {
            const $input = $(this);
            const value = $input.val();
            if (value) {
                // Format the number when leaving the field
                const formattedValue = formatNumber(value);
                $input.val(formattedValue);
            }
        });

        // Handle form submission - convert formatted values to numeric
        $(document).on("submit", "form", function () {
            $(".price-input").each(function () {
                const $input = $(this);
                const value = $input.val();
                if (value) {
                    const numericValue = parseFormattedNumber(value);
                    $input.val(numericValue);
                }
            });
        });
    }

    // Initialize when document is ready
    $(document).ready(function () {
        initPriceFormatting();
    });

    // Export functions for global use
    window.PriceFormatter = {
        format: formatNumber,
        parse: parseFormattedNumber,
        init: initPriceFormatting,
    };
})(jQuery);


