$(document).ajaxComplete(function() {
    $('#check-all').click(function() {
        if ($(this).prop("checked")) {
            $(".check-all").prop("checked", true);
        } else {
            $(".check-all").prop("checked", false);
        }
    });

    $('.check-all').click(function() {
        if ($(".check-all").length == $(".check-all:checked").length) {
            $("#check-all").prop("checked", true);
        } else {
            $("#check-all").prop("checked", false);
        }
    });
});

$('#datatable').on('draw.dt', function() {
    if ($('#check-all:checked').length > 0) {
        $('#check-all').prop('checked', false);
    }
});

function submitBulkAction() {
    var action = $('#bulk_action').val();
    var checkbox = $('input[name="checkbox[]"]:checked').length;

    if (action == '') {
        Codebase.helpers('notify', {
            type: 'danger',               // 'info', 'success', 'warning', 'danger'
            icon: 'fa fa-times mr-5',    // Icon class
            message: 'Please select bulk action'
        });

        return false;
    } else if(checkbox == 0) {
        Codebase.helpers('notify', {
            type: 'danger',               // 'info', 'success', 'warning', 'danger'
            icon: 'fa fa-times mr-5',    // Icon class
            message: 'Please select at least one checkbox'
        });

        return false;
    }
}
