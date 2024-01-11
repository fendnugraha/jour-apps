// $(document).ready(function () {
//     $("table.display").DataTable();

// });
$(document).ready(function () {
    $(".datepicker").datepicker({
        dateFormat: 'yy/mm/dd',
        showOtherMonths: true,
        selectOtherMonths: true
    }).val();
});

new DataTable('.display', {
    lengthMenu: [
        [7,10, 25, 50, -1],
        [7,10, 25, 50, 'All']
    ]
});

new DataTable('table.display-no-order', {
    ordering:false,
    lengthMenu: [
        [7,10, 25, 50, -1],
        [7,10, 25, 50, 'All']
    ]
});

$(document).ready(function () {
    $("#modal-checkbox-payable").click(function () {
        if ($(this).is(":checked")) {
            $("#debt-code-payable").prop("disabled", true);
        } else {
            $("#debt-code-payable").prop("disabled", false);
        }
    });
});



