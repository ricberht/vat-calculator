document.addEventListener('DOMContentLoaded', () => {
    $(document).ready(function ($) {
        function addAlert(message) {
            $("#btn-save").prop('disabled', true);
            let messageHtml = "<p><strong>Error:</strong> " + message + "</p>";
            if ($(".alert.alert-danger").length) {
                $(".alert.alert-danger").html(messageHtml);
            } else {
                $("#vatForm").prepend('<div class="alert alert-danger">' + messageHtml + '</div>')
            }
        }

        $("#vatForm").on('mouseup keyup click mousemove', function () {
            let inputPercent = $("#percentage").val().trim();
            let parsedPercent = parseFloat(inputPercent);
            let inputVal = $("#value").val().trim();
            let parsedVal = parseFloat(inputVal);
            if (inputVal === "") {
                addAlert("Monetary value cannot be empty");
            } else if (isNaN(parsedVal) && parsedVal.toString() !== inputVal) {
                addAlert("Monetary value must be a number");
            } else if (parsedVal < 0.01) {
                addAlert("Monetary value must be 0.01 or greater!");
            } else if (inputPercent === "") {
                addAlert("Percentage input cannot be empty");
            } else if (isNaN(parsedPercent) && parsedPercent.toString() !== inputPercent) {
                addAlert("Percentage must be a number");
            } else if (parsedPercent > 100 || parsedPercent < 0.01) {
                addAlert("Percentage must be between 0.01% and 100%.");
            } else {
                if ($(".alert.alert-danger").length) {
                    $(".alert.alert-danger").remove();
                }
                $("#btn-save").prop('disabled', false);
            }
        });

        $('#btn-add').on("click", function () {
            $('#vatForm').trigger("reset");
            $('#formModal').modal('show');
        });

        $("#btn-delete").on("click", function () {
            $.ajax({url: 'clear',}).done(function () {
                $('tbody#grid').empty();
            });
        });

        $("#btn-save").on("click", function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            let value = parseFloat($('#value').val());
            let percent = parseFloat($('#percentage').val());
            let included = $('#included').is(':checked');
            let display = "No";
            let vatSubtracted = '';
            let vatIncluded = '';
            let vatCost = ((value / 100) * percent).toFixed(2);
            if (included) {
                display = "Yes";
                vatSubtracted = ((value / (percent + 100)) * 100).toFixed(2);
                vatCost = (value - vatSubtracted).toFixed(2);
                vatSubtracted = "£" + vatSubtracted;
            } else {
                vatIncluded = (value + vatCost).toFixed(2);
                vatIncluded = "£" + vatIncluded;
            }
            //turn to int from bool
            included = Number(included);
            $.ajax({
                type: "POST",
                url: '/vat',
                data: {
                    value: value,
                    percentage: percent,
                    included: included,
                },
                dataType: 'json',
            });
            let newVat = '<tr id="calculation-1">';
            newVat += '<td>£' + value + '</td>';
            newVat += '<td>' + percent + '%</td>';
            newVat += '<td>' + display + '</td>';
            newVat += '<td>' + vatSubtracted + '</td>';
            newVat += '<td>' + vatIncluded + '</td>';
            newVat += '<td>£' + vatCost + '</td>';
            newVat += '</tr>';
            $('tbody#grid').append(newVat);
            $('#vatForm').trigger("reset");
            $('#formModal').modal('hide');
        });
    });
});
