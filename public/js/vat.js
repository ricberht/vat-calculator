document.addEventListener('DOMContentLoaded', () => {
    $(document).ready(function ($) {
        $('#percentage').on('keyup', function () {
            let input = $(this).val();
            let parsed = parseFloat(input);
            if (input === "") {
                console.log("Input cannot be empty");
            } else if (!isNaN(parsed) && parsed.toString() === input) {
                console.log("not a number");
            } else if (parsed > 100 || parsed < 0.01) {
                console.log("invalid percentage");
            } else {
                console.log("remove warning");
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
