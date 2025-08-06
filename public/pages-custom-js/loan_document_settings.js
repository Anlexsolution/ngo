$(document).ready(function () {
    $('.selectize').selectize();
    $('#loanDocTable').DataTable();
    $("#txtSubCategory").selectize();
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





  let docList = [];
  let docIndex = 1;

  $('#btnAddDoc').on('click', function () {
    const docName = $('#txtDocumentName').val().trim();

    if (!docName) {
        $.alert({
            title: "Error!",
            content: "Please enter a document name",
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

    docList.push(docName);

    $('#docNameTable tbody').append(`
      <tr data-index="${docIndex}">
        <td>${docIndex}</td>
        <td>${docName}</td>
        <td><button class="btn btn-sm btn-danger btnRemoveDoc">Remove</button></td>
      </tr>
    `);

    docIndex++;
    $('#txtDocumentName').val('');
  });

  // Remove a document row
  $(document).on('click', '.btnRemoveDoc', function () {
    const row = $(this).closest('tr');
    const index = row.index();
    docList.splice(index, 1);
    row.remove();
  });


  //Create Document
$('body').on('click', '#btnCreateDocument', function () {
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

    if (docList.length === 0) {
        $.alert({
            title: "Error!",
            content: "add atleast one document",
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
    console.log(docList);
    formData.append('docList', JSON.stringify(docList));

    if (txtDocumentName == '') {
        $.alert({
            title: "Error!",
            content: "Please fill the document name",
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

      if (txtSubCategory == '') {
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
        makeAjaxRequestDoc(formData);
    });

});

function makeAjaxRequestDoc(formData) {
    $.ajax({
        url: "/add-loan-document-data",
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
////Create Document
