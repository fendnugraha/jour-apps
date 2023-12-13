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
        [5,10, 25, 50, -1],
        [5,10, 25, 50, 'All']
    ]
});

new DataTable('table.display-noorder', {
    ordering:false,
    lengthMenu: [
        [5,10, 25, 50, -1],
        [5,10, 25, 50, 'All']
    ]
});