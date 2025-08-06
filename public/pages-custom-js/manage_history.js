$(document).ready(function () {
    $(".selectize").selectize();
        var tablewith= $('#viewWithTable').DataTable();
    var table= $('#viewTransTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7]
                }
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7]
                }
            }

        ],
        columnDefs: [
            {
                targets: 6,
                render: function (data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        return parseFloat(data).toFixed(2);
                    }
                    return data;
                }
            }
        ]
    });

    $("#txtType").on("change", function () {
        var status = $(this).val();
        console.log(status);
        table.column(5).search(status).draw();
      });

       //date range filter
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        var min = $("#fromdate").val();
        var max = $("#todate").val();
        var date = new Date(data[2]);

        if (
          (min === "" || new Date(min) <= date) &&
          (max === "" || new Date(max) >= date)
        ) {
          return true;
        }
        return false;
      });

      $("#fromdate, #todate").change(function () {
        table.draw();
      });


      $('#fromAmount, #toAmount').on('keyup change', function() {
        var fromAmount = parseFloat($('#fromAmount').val()) || 0;
        var toAmount = parseFloat($('#toAmount').val()) || Infinity;

        table.rows().every(function() {
            var data = this.data();
            var amount = parseFloat(data[6]) || 0;

            if (amount >= fromAmount && amount <= toAmount) {
                this.node().style.display = '';
            } else {
                this.node().style.display = 'none';
            }
        });

        table.draw();
    });
  });


////Create Import
$('body').on('click', '#btnImportSavingHistory', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   let fileInput = document.getElementById('txtImportFile');
   let file = fileInput.files[0];

   if (!file) {
    $.alert({
        title: "Error!",
        content: "Please Select the file",
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
   formData.append("file", file);

   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxRequest(formData);
   });

});

function makeAjaxRequest(formData) {
   $.ajax({
       url: "/import-saving-history-data",
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
////Create Import


//Create Transfer
$('body').on('click', '#btnTransferAccount', function(){
     $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMemberUniqueId = $('#txtMemberUniqueId').val();
    formData.append('txtMemberUniqueId', txtMemberUniqueId);

        var txtSelectAcccount = $('#txtSelectAcccount').val();
    formData.append('txtSelectAcccount', txtSelectAcccount);

        var txtAmount = $('#txtAmount').val();
    formData.append('txtAmount', txtAmount);

          var txtRemarks = $('#txtRemarks').val();
    formData.append('txtRemarks', txtRemarks);

    if(txtMemberUniqueId == ''){
        $.alert({
            title: "Error!",
            content: "Please enter Member Unique Id",
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

        if(txtSelectAcccount == ''){
        $.alert({
            title: "Error!",
            content: "Please select Account",
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

        if(txtAmount == ''){
        $.alert({
            title: "Error!",
            content: "Please enter Amount",
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
        makeAjaxRequestTransfer(formData);
    });

});

function makeAjaxRequestTransfer(formData) {
    $.ajax({
        url: "/account-account-transfer-data",
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
////Create Transfer
