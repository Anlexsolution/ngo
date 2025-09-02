$(document).on("click", ".btnEditSmallGroup", function () {
    let id = $(this).data("id");
    let divisionId = $(this).data("division");
    let villageId = $(this).data("village");
    let name = $(this).data("name");

    // Fill values
    $("#editSmallGroupId").val(id);
    $("#editSmallGroupName").val(name);

    // Set division
    $("#editDivisionId").val(divisionId);

    // Load villages for selected division
    fetch(`/get-villages/${divisionId}`)
        .then(response => response.json())
        .then(data => {
            let villageSelect = $("#editVillageId");
            villageSelect.html('<option value="">Select Village</option>');

            data.forEach(function (village) {
                let selected = (village.id == villageId) ? "selected" : "";
                villageSelect.append(
                    `<option value="${village.id}" ${selected}>${village.villageName}</option>`
                );
            });
        });

    // Show modal
    $("#smallGroupEditModal").modal("show");
});



    ////Smallgroup Update
    $('body').on('click', '#updateSmallGroupBtn', function() {
        $("#loader").show();
        var formData = new FormData();

        // Get the CSRF token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        formData.append("_token", CSRF_TOKEN);
        // Get the CSRF token

        var editSmallGroupId = $('#editSmallGroupId').val();
        formData.append('editSmallGroupId', editSmallGroupId);

        var editDivisionId = $('#editDivisionId').val();
        formData.append('editDivisionId', editDivisionId);

        var editVillageId = $('#editVillageId').val();
        formData.append('editVillageId', editVillageId);

        var editSmallGroupName = $('#editSmallGroupName').val();
        formData.append('editSmallGroupName', editSmallGroupName);

        if (editSmallGroupName == '') {
            $('#editSmallGroupName').focus();
            $.alert({
                title: "Error!",
                content: "Please fill the smallgroup name",
                type: "red",
                theme: 'modern',
                buttons: {
                    okay: {
                        text: "Okay",
                        btnClass: "btn-red",
                        action: function() {
                            $("#loader").hide();
                        },
                    },
                },
            });
            return false;
        }

        // AJAX request
        $.ajax({
            url: "/updatesmallgroupdata",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("#loader").show();
            },
            success: function(response) {
                $("#loader").hide();
                if (response.code == 200) {
                    $.alert({
                        title: "Success!",
                        content: "smallgroup Updated successfully!",
                        type: "green",
                        theme: 'modern',
                        buttons: {
                            okay: {
                                text: "Okay",
                                btnClass: "btn-green",
                                action: function() {
                                    location.reload();
                                },
                            },
                        },
                    });
                } else if (response.code == 403) {
                    $.alert({
                        title: "Error!",
                        content: "CSRF Error Try Again",
                        type: "red",
                        theme: 'modern',
                        buttons: {
                            okay: {
                                text: "Okay",
                                btnClass: "btn-red",
                                action: function() {
                                    $("#loader").hide();
                                },
                            },
                        },
                    });
                } else if (response.code == 500) {
                    $.alert({
                        title: "Error!",
                        content: response.error,
                        type: "red",
                        theme: 'modern',
                        buttons: {
                            okay: {
                                text: "Okay",
                                btnClass: "btn-red",
                                action: function() {
                                    $("#loader").hide();
                                },
                            },
                        },
                    });
                } else {
                    $.alert({
                        title: "Error!",
                        content: "Something went wrong!",
                        type: "red",
                        theme: 'modern',
                        buttons: {
                            okay: {
                                text: "Okay",
                                btnClass: "btn-red",
                                action: function() {
                                    $("#loader").hide();
                                },
                            },
                        },
                    });
                }
            },
            error: function(xhr, status, error) {
                $("#loader").hide();
                console.error("Error:", error);
                $.alert({
                    title: "Error!",
                    content: "Something went wrong!",
                    type: "red",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                            action: function() {
                                $("#loader").hide();
                                location.reload();
                            },
                        },
                    },
                });
            },
        });

    });
    ////Smallgroup Update
