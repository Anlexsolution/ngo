$(document).ready(function () {
    $('#collectionTransferTable').dataTable();
    $('.selectize').selectize();
});

$('body').on('click', '.btnApproveModal', function () {
    var collectionId = $(this).attr('data-id');
    $('#txtCollectionTransferId').val(collectionId);
    $('#collectionTransferApproveModal').modal('show');
})


//Create Profeesion
$('body').on('click', '#btnCollectionApprove', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtCollectionTransferId = $('#txtCollectionTransferId').val();
    formData.append('txtCollectionTransferId', txtCollectionTransferId);

    var txtBank = $('#txtBank').val();
    formData.append('txtBank', txtBank);

    if (txtBank == '') {
        $.alert({
            title: "Error!",
            content: "Please choose the bank",
            type: "red",
            theme: 'modern',
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red",
                    action: function () {
                        $("#loader").hide();
                    },
                },
            },
        });
        return false;
    }

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/create-collection-transfer-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            handleResponse(response);
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
