$(document).ready(function () {
    $('.selectize').selectize();
    $('#txtSubCategory').selectize();
});

$('body').on('change', '#txtMainCategory', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMainCategory = $('#txtMainCategory').val();
    formData.append('txtMainCategory', txtMainCategory);

    if (txtMainCategory == '') {
        $.alert({
            title: "Error!",
            content: "Please select the main Category",
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
        url: "/get-loan-purpose-sub-cat-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            if (response.code === 200) {
                $("#txtSubCategory")[0].selectize.destroy();
                $("#txtSubCategory").empty();
                $("#txtSubCategory").append(response.getAllLoanOption);
                $("#txtSubCategory").selectize();
                $("#loader").hide();
            } else {
                $.alert({
                    title: "Alert",
                    content: "Something went wrong",
                    icon: "fa fa-exclamation-triangle",
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                            action: function () {
                                $("#page-loader").hide();
                            },
                        },
                    },
                });
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}

$('body').on('change', '#txtSubCategory', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMainCategory = $('#txtMainCategory').val();
    formData.append('txtMainCategory', txtMainCategory);

    var txtSubCategory = $('#txtSubCategory').val();
    formData.append('txtSubCategory', txtSubCategory);

    if (txtMainCategory == '') {
        $.alert({
            title: "Error!",
            content: "Please select the main Category",
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

    if (txtMainCategory == '') {
        $.alert({
            title: "Error!",
            content: "Please select the sub Category",
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
        makeAjaxRequestSub(formData);
    });

});

function makeAjaxRequestSub(formData) {
    $.ajax({
        url: "/get-loan-document-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            if (response.code === 200) {
                const documents = response.getLoanDocData;

                const container = document.getElementById('viewDocuments');
                container.innerHTML = ""; // Clear old content

                // ✅ Create Select All checkbox
                const selectAllDiv = document.createElement("div");
                selectAllDiv.innerHTML = `
                    <label>
                        <input type="checkbox" id="selectAllDocs"> Select All Documents
                    </label>
                `;
                container.appendChild(selectAllDiv);

                // ✅ Create <ul> with checkboxes
                const ul = document.createElement('ul');
                documents.forEach((doc, index) => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <label>
                            <input type="checkbox" name="documents[]" class="doc-checkbox" data-name="${doc.name}" value="${doc.id}" />
                            ${doc.name}
                        </label>
                    `;
                    ul.appendChild(li);
                });
                container.appendChild(ul);

                // ✅ Handle Select All checkbox
                document.getElementById("selectAllDocs").addEventListener("change", function () {
                    const checked = this.checked;
                    document.querySelectorAll(".doc-checkbox").forEach(cb => {
                        cb.checked = checked;
                    });
                });

            } else {
                $.alert({
                    title: "Alert",
                    content: "Something went wrong",
                    icon: "fa fa-exclamation-triangle",
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                            action: function () {
                                $("#page-loader").hide();
                            },
                        },
                    },
                });
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}


//Create loan request
$('body').on('click', '#btnCreateLoanRequest', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMember = $('#txtMember').val();
    formData.append('txtMember', txtMember);

    var txtLoanAmount = $('#txtLoanAmount').val();
    formData.append('txtLoanAmount', txtLoanAmount);

    var txtMainCategory = $('#txtMainCategory').val();
    formData.append('txtMainCategory', txtMainCategory);

    var txtSubCategory = $('#txtSubCategory').val();
    formData.append('txtSubCategory', txtSubCategory);

    var txUserType = $('#txUserType').val();
    formData.append('txUserType', txUserType);

    let selected = [];
        $(".doc-checkbox:checked").each(function () {
            selected.push({
                name: $(this).data("name")
            });
        });

    const selectedJSON = JSON.stringify(selected);
    formData.append('selected', selectedJSON);

    if(selected.length == 0){
        $.alert({
            title: "Error!",
            content: "Please Select Document",
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



    if (txUserType == '') {
        $.alert({
            title: "Error!",
            content: "Please Select user type",
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
    if (txtSubCategory == '') {
        $.alert({
            title: "Error!",
            content: "Please Select sub category",
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
    if (txtMainCategory == '') {
        $.alert({
            title: "Error!",
            content: "Please Select main category",
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

    if (txtLoanAmount == '') {
        $.alert({
            title: "Error!",
            content: "Please enter the loan amount",
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

    if (txtMember == '') {
        $.alert({
            title: "Error!",
            content: "Please Select member",
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
        makeAjaxLoanRequest(formData);
    });

});

function makeAjaxLoanRequest(formData) {
    $.ajax({
        url: "/add-loan-request-data",
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
////Create loan request

////Create loan request Approve Member
$('body').on('click', '#btnCreateLoanRequestApproveMember', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMember = $('#txtMember').val();
    formData.append('txtMember', txtMember);

    var selectedOption = $("input[name='option']:checked").val();
    formData.append('selectedOption', selectedOption);

    var txtRemarks = $('#txtRemarks').val();
    formData.append('txtRemarks', txtRemarks);

    var txtRequestId = $('#txtRequestId').val();
    formData.append('txtRequestId', txtRequestId);

    if (txtMember == '') {
        $.alert({
            title: "Error!",
            content: "Please Select member",
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

    if (selectedOption == '') {
        $.alert({
            title: "Error!",
            content: "Please Select approve option.",
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

    if (txtRemarks == '') {
        $.alert({
            title: "Error!",
            content: "Please enter the remarks.",
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
        makeAjaxLoanRequestMemberApprove(formData);
    });

});

function makeAjaxLoanRequestMemberApprove(formData) {
    $.ajax({
        url: "/add-loan-request-member-approve-data",
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
////Create loan request Approve Member


////Create loan request Approve
$('body').on('click', '#loanRequestApproval', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token
    var txtRequestId = $('#txtRequestId').val();
    formData.append('txtRequestId', txtRequestId);

      let selected = [];
        $(".document-checkbox:checked").each(function () {
            selected.push({
                name: $(this).data("name"),
            });
        });

    const selectedJSON = JSON.stringify(selected);
    formData.append('selected', selectedJSON);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxLoanRequestApprove(formData);
    });

});

function makeAjaxLoanRequestApprove(formData) {
    $.ajax({
        url: "/add-loan-request-approve-data",
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
////Create loan request Approve


////Create loan request Rejected
$('body').on('click', '#loanRequestReject', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token
    var txtRequestId = $('#txtRequestId').val();
    formData.append('txtRequestId', txtRequestId);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxLoanRequestReject(formData);
    });

});

function makeAjaxLoanRequestReject(formData) {
    $.ajax({
        url: "/add-loan-request-rejected-data",
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
////Create loan request Rejected
