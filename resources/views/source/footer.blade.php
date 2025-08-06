<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../../assets/vendor/libs/popper/popper.js"></script>
<script src="../../assets/vendor/js/bootstrap.js"></script>
<script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../../assets/vendor/libs/i18n/i18n.js"></script>
<script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../../assets/vendor/js/menu.js"></script>
<script src="../../assets/vendor/js/menu.js"></script>

<!-- jQuery Confirm JS -->
<script src="https://cdn.rawgit.com/craftpip/jquery-confirm/master/dist/jquery-confirm.min.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="../../assets/vendor/libs/swiper/swiper.js"></script>
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>

<!-- Vendors JS -->
<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

<!-- Page JS -->
<script src="../../assets/js/pages-auth.js"></script>

<!-- Page JS -->
<script src="../../assets/js/dashboards-analytics.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let alertElements = document.querySelectorAll('.success-alert');
            alertElements.forEach(function(alertElement) {
                alertElement.style.display = 'none';
            });
        }, 4000);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    	<!-- Selectize JS -->
	<script src="../../source/selectize/js/standalone/selectize.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
$('.datatableView').DataTable({
    dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    buttons: [
        {
            extend: 'excelHtml5',
            className: 'btn btn-success btn-sm'
        },
        {
            extend: 'pdfHtml5',
            className: 'btn btn-danger btn-sm'
        }
    ],
    // scrollX: true,
    responsive: true,
    fixedHeader: true,
});


    $('#loanTableView').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Loan Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ],
    });


$('.selectizeFilter').selectize();
    })

        $(document).ready(function () {
       // Initialize DataTable
        var table = $('#savingReportTable').DataTable({
            responsive: true,
            ordering: true,
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove formatting & convert to float
                var parseValue = function (i) {
                    return typeof i === 'string'
                        ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                        : typeof i === 'number'
                        ? i
                        : 0;
                };

                // Calculate total over this page
                var total = api
                    .column(2, { search: 'applied' })
                    .data()
                    .reduce(function (a, b) {
                        return parseValue(a) + parseValue(b);
                    }, 0);

                // Update footer
                $('#totalAmountFooter').html(total.toFixed(2));
            }
        });

        // Filter by Month
        $('#monthFilter').on('change', function () {
            var selectedMonth = $(this).val(); // Format: "2025-06"
            if (selectedMonth) {
                table.column(1).search('^' + selectedMonth, true, false).draw();
            } else {
                table.column(1).search('').draw();
            }
        });
    });
</script>

<script>
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            // Force a reload if the page was loaded from the browser cache
            window.location.reload();
        }
    });
</script>

<script
  src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
  integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>


@php
$pageName = request()->segment(1);
@endphp

<script>

function getLocation() {
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    });
                },
                (error) => {
                    console.error("Geolocation error:", error);
                    showAlert("Error!", "Unable to retrieve location. Please try again.");
                    reject(error);
                }
            );
        } else {
            showAlert("Error!", "Geolocation is not supported by your browser.");
            reject(new Error("Geolocation not supported"));
        }
    });
}

async function getUserLocation() {
    try {
        const location = await getLocation();
        return {
            latitude: location.latitude,
            longitude: location.longitude,
        };
    } catch (error) {
        console.error("Error getting location:", error);
        return { latitude: '', longitude: '' };
    }
}
</script>

{{-- header page design script --}}
@if ($pageName == 'manage_profession')
<script src="pages-custom-js/manage_profession.js?v=<?= date('His') ?>"></script>
@endif
{{-- header page design script --}}

{{-- header page design script --}}
@if ($pageName == 'meeting_category')
<script src="pages-custom-js/meeting_category.js?v=<?= date('His') ?>"></script>
@endif
{{-- header page design script --}}

{{-- division design script --}}
@if ($pageName == 'create_division')
<script src="pages-custom-js/manage_division.js?v=<?= date('His') ?>"></script>
@endif
{{-- division design script --}}

{{-- village design script --}}
@if ($pageName == 'create_village')
<script src="pages-custom-js/manage_village.js?v=<?= date('His') ?>"></script>
@endif
{{-- village design script --}}

{{-- user design script --}}
@if ($pageName == 'add_users')
<script src="pages-custom-js/manage_users.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'update_users')
<script src="../pages-custom-js/manage_users.js?v=<?= date('His') ?>"></script>
@endif
{{-- user design script --}}

{{-- village design script --}}
@if ($pageName == 'opening_balance' || $pageName == 'opening_balance_report')
<script src="pages-custom-js/opening_balance.js?v=<?= date('His') ?>"></script> @endif
{{-- village design script --}}

{{-- village design script --}}
@if ($pageName == 'view_saving_history' || $pageName == 'view_saving_history_mem')
<script src="../pages-custom-js/manage_history.js?v=<?= date('His') ?>"></script> @endif
{{-- village design script --}}

{{-- village design script --}}
@if ($pageName == 'view_death_history')
<script src="../pages-custom-js/manage_death_history.js?v=<?= date('His') ?>"></script> @endif
{{-- village design script --}}

{{-- village design script --}}
@if ($pageName == 'manage_other_incomes')
<script src="../pages-custom-js/manage_other_income.js?v=<?= date('His') ?>"></script> @endif
{{-- village design script --}}

{{-- GN Division script --}}
@if ($pageName == 'create_division_by_gn' || $pageName == 'create_smallgroup_by_gn')
<script src="pages-custom-js/gn_division.js?v=<?= date('His') ?>"></script>
@endif
{{-- GN Division script --}}

{{-- Permission script --}}
@if ($pageName == 'assign_permssion_update')
<script src="../pages-custom-js/manage_permissionss.js?v=<?= date('His') ?>"></script>
@endif
{{-- Permission script --}}

{{-- oan Document script --}}
@if ($pageName == 'loan_document_settings')
<script src="../pages-custom-js/loan_document_settings.js?v=<?= date('His') ?>"></script>
@endif
{{-- loan Document script --}}

@if ($pageName == 'user_role')
<script src="pages-custom-js/manage_user_role.js?v=<?= date('His') ?>"></script>
@endif


@if ($pageName == 'member_report')
<script src="pages-custom-js/manage_report.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_loan_request')
<script src="pages-custom-js/manage_loan_request.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'view_loan_request')
<script src="../pages-custom-js/manage_loan_request.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'direct_savings')
<script src="pages-custom-js/direct_savings.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'collection_deposit')
<script src="pages-custom-js/collection_deposit.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'create_loan_product')
<script src="pages-custom-js/loan_product.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'create_old_loan')
<script src="pages-custom-js/manage_old_loan.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'create_loan_request')
<script src="../
pages-custom-js/create_loan_request.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'create_loan' || $pageName == 'manage_loan_purpose')
<script src="pages-custom-js/manage_loan.js?v=<?= date('His') ?>"></script>
@endif
@if ($pageName == 'loan_follower')
<script src="../pages-custom-js/manage_loan-folower.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'view_loan_approval')
<script src="../../pages-custom-js/manage_loan-approval.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_death_donation')
<script src="../../pages-custom-js/manage_death_donation.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_relative_settings')
<script src="../../pages-custom-js/manage_relative_settings.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_account_settings')
<script src="../../pages-custom-js/manage_account_settings.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'view_death_donation_recommand')
<script src="../../pages-custom-js/view_death_donation_recommand.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'view_death_donation_approve')
<script src="../../pages-custom-js/view_death_donation_approve.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'view_death_donation_distribute')
<script src="../../pages-custom-js/view_death_donation_distribute.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_approval_settings')
<script src="../../pages-custom-js/manage_loan-approval-settings.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'division_details')
<script src="../../pages-custom-js/manage_division_details.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'village_details')
<script src="../../pages-custom-js/manage_village_details.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'smallgroup_details')
<script src="../../pages-custom-js/manage_smallgroup_details.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'create_account' || $pageName == 'manage_account' || $pageName == 'view_account_details')
<script src="../../pages-custom-js/manage_account.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'view_member')
<script src="../../pages-custom-js/manage_view_member.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'loan_repayment')
<script src="../../pages-custom-js/manage_loan_repayment.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_interest_settings')
<script src="../../pages-custom-js/manage_interest_settings.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_savings')
<script src="../../pages-custom-js/manage_savings.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'view_withdrawal_request')
<script src="../../pages-custom-js/withdrawal.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'manage_member')
<script src="../../pages-custom-js/manage_member.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'collection_reports')
<script src="../../pages-custom-js/collection_reports.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'withrawal_approve_reports')
<script src="../../pages-custom-js/withrawal_approve_reports.js?v=<?= date('His') ?>"></script>
@endif

@if ($pageName == 'loan_report')
<script src="../../pages-custom-js/loan_report.js?v=<?= date('His') ?>"></script> @endif

@if ($pageName == 'loan_arreas_report')
<script src="../../pages-custom-js/loan_arreas_report.js?v=<?= date('His') ?>"></script> @endif

@if ($pageName == 'collection_vs_deposit_reports')
<script src="../../pages-custom-js/collection_vs_deposit_reports.js?v=<?= date('His') ?>"></script> @endif

@if ($pageName == 'add_meeting')
<script src="../../pages-custom-js/manage_meetings.js?v=<?= date('His') ?>"></script> @endif

@if ($pageName == 'collection_transfer')
<script src="../../pages-custom-js/collection_transfer.js?v=<?= date('His') ?>"></script> @endif

@if ($pageName == 'profile_view')
<script src="../../pages-custom-js/manage_profile.js?v=<?= date('His') ?>"></script> @endif

@if ($pageName == 'view_loan_details')
<script src="../../pages-custom-js/view_loan_details.js?v=<?= date('His') ?>"></script> @endif

<script>

    //Handle Alert
function handleResponse(response) {
    if (response.code == 200) {
        let message = response.success;
        showAlertSuccess(" Success", message); }else if (response.code==201) { let message=response.success; let
    transectionId=response.transectionId; showAlertSuccessTransection("Success", message, transectionId) }else if
    (response.code==204) { let message=response.success; let transectionId=response.transId;
    showAlertSuccessTransectionRepay("Success", message, transectionId) }else if (response.code==202) { let
    message=response.success; let redirectUrl=response.redirectUrl; showAlertSuccessRedirect("Success", message,
    redirectUrl); } else{ let message=response.error || "Something went wrong. Please try again." ; showAlert("Error!",
    message); } } function showAlert(title, content) { $.alert({ title: title, content: content, type: "red" ,
    theme: 'modern' , buttons: { okay: { text: "Okay" , btnClass: "btn-red" , action: function () { $("#loader").hide();
    }, }, }, }); } function showAlertSuccessRedirect(title, content, url) { $.alert({ title: title, content: content,
    type: "green" , icon: "fa fa-check-circle" , theme: 'modern' , buttons: { okay: { text: "Okay" ,
    btnClass: "btn-green" , action: function() { location.href=url; $("#page-loader").hide(); }, }, }, }); } function
    showAlertSuccessTransection(title, content, transectionId) { $.alert({ title: title, content: content, type: "green"
    , theme: 'modern' , buttons: { okay: { text: "Okay" , btnClass: "btn-green" , action: function () {
    location.reload(); $("#loader").hide(); }, }, print: { text: "Print" , btnClass: "btn-blue" , action: function () {
    window.open(`{{ route('direct_saving_receipt', ':id') }}`.replace(':id', transectionId)); location.reload();
    $("#loader").hide(); }, }, }, }); } function showAlertSuccessTransectionRepay(title, content, transectionId) {
    $.alert({ title: title, content: content, type: "green" , theme: 'modern' , buttons: { okay: { text: "Okay" ,
    btnClass: "btn-green" , action: function () { location.reload(); $("#loader").hide(); }, }, print: { text: "Print" ,
    btnClass: "btn-blue" , action: function () { window.open(`{{ route('repayment_receipt', ':id') }}`.replace(':id',
    transectionId)); location.reload(); $("#loader").hide(); }, }, }, }); } function showAlertSuccess(title, content) {
    $.alert({ title: title, content: content, type: "green" , theme: 'modern' , buttons: { okay: { text: "Okay" ,
    btnClass: "btn-green" , action: function () { location.reload(); $("#loader").hide(); }, }, }, }); } //Handle Alert
    </script>
