<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\logincontroller;
use App\Http\Controllers\Auth\registercontroller;
use App\Http\Controllers\pages\account_controller;
use App\Http\Controllers\pages\dashboardcontroller;
use App\Http\Controllers\user_role_controller;
use App\Http\Controllers\pages\user_controller;
use App\Http\Controllers\pages\error_controller;
use App\Http\Controllers\pages\add_division_controller;
use App\Http\Controllers\pages\collection_controller;
use App\Http\Controllers\pages\member_controller;
use App\Http\Controllers\pages\manage_member_controller;
use App\Http\Controllers\pages\manage_savings_controller;
use App\Http\Controllers\pages\death_manage_controller;
use App\Http\Controllers\pages\generate_controller;
use App\Http\Controllers\pages\loan_controller;
use App\Http\Controllers\pages\loan_product_controller;
use App\Http\Controllers\pages\loan_request_controller;
use App\Http\Controllers\pages\manage_direct_savings_controller;
use App\Http\Controllers\pages\manage_division_controller;
use App\Http\Controllers\pages\manage_meeting_controller;
use App\Http\Controllers\pages\manage_old_loan_controller;
use App\Http\Controllers\pages\manage_other_income_controller;
use App\Http\Controllers\pages\manage_reports_controller;
use App\Http\Controllers\pages\manage_settings_controller;
use App\Http\Controllers\pages\opening_balance_controller;
use App\Http\Controllers\pages\receipt_controller;
use App\Http\Controllers\pages\withdrawal_controller;
use App\Http\Controllers\pages\profile_controller;

//Main route
Route::get('/', [logincontroller::class, 'loginpage'])->middleware('guest');
//Main route

//login logout register
Route::get('/login', [logincontroller::class, 'loginpage'])->middleware('guest')->name('login');
Route::get('/e-login', [logincontroller::class, 'loginpageMember'])->middleware('guest')->name('e-login');
Route::get('/register', [registercontroller::class, 'registerform'])->middleware('guest');
Route::get('/logout', [logincontroller::class, 'logout']);
Route::get('/logout_member', [logincontroller::class, 'logout_member']);
Route::post('/store', [registercontroller::class, 'store']);
Route::post('/createusers', [registercontroller::class, 'createusers']);
Route::post('/updateusers', [registercontroller::class, 'updateusers']);
Route::post('/authendicate', [LoginController::class, 'authendicate']);
Route::post('/authendicate_member', [LoginController::class, 'authendicate_member']);
Route::post('/otp-verify-data', [LoginController::class, 'otpVerifyData']);
Route::get('/otp_verify/{email}/{password}', [LoginController::class, 'otpVerify'])->name('otp_verify');
//login logout register

//Dashboard
Route::get('/dashboard', [dashboardcontroller::class, 'dashboard'])->middleware('auth');
//Dashboard

//Manage users
Route::get('/user_role', [user_role_controller::class, 'userrole'])->middleware('auth');
Route::get('/manage_user_role', [user_role_controller::class, 'manageuserrole'])->middleware('auth');
Route::get('/add_users', [user_controller::class, 'addUsers'])->middleware('auth');
Route::get('/manage_users', [user_controller::class, 'manageUsers'])->middleware('auth');
Route::get('/assign_division/{id}', [user_controller::class, 'assignDivision'])->middleware('auth')->name('assign_division');
Route::get('/update_users/{id}', [user_controller::class, 'updateUsers'])->middleware('auth')->name('update_user');
Route::get('/profile_view/{id}', [user_controller::class, 'profileView'])->middleware('auth')->name('profile_view');
Route::get('/update_user_role/{id}', [user_controller::class, 'updateUserRole'])->middleware('auth')->name('update_user_role');
Route::get('/assign_permssion_update/{id}', [user_controller::class, 'assignPermissionUpdate'])->middleware('auth')->name('assign_permssion_update');

Route::post('/upload-profile', [profile_controller::class, 'uploadProfile'])->middleware('auth');
Route::post('/update-profile-data', [profile_controller::class, 'updateProfileData'])->middleware('auth');
Route::post('/change-password', [profile_controller::class, 'changePassword'])->middleware('auth');
Route::post('/createuserrole', [user_role_controller::class, 'createuserrole'])->middleware('auth');
Route::post('/create-user-role-data', [user_role_controller::class, 'createUserRoleData'])->middleware('auth');
Route::post('/update-user-permission-data', [user_controller::class, 'updateUserPermission'])->middleware('auth');
Route::post('/updateuserrole', [user_role_controller::class, 'updateuserrole'])->middleware('auth');
Route::post('/updateuserdivisiondata', [user_controller::class, 'updateuserdivisiondata'])->middleware('auth');
Route::post('/enable_user/{id}', [user_controller::class, 'enableuser'])->middleware('auth')->name('enable_user');
Route::post('/disable_user/{id}', [user_controller::class, 'disableuser'])->middleware('auth')->name('disable_user');
Route::delete('/delete_user/{id}', [user_controller::class, 'deleteuser'])->middleware('auth')->name('delete_user');
//Manage users

//manage division
Route::get('/division_by_village', [add_division_controller::class, 'addDivision'])->middleware('auth');
Route::get('/create_division', [add_division_controller::class, 'createDivision'])->middleware('auth');
Route::get('/create_village', [add_division_controller::class, 'addVillage'])->middleware('auth');
Route::get('/create_smallgroup', [add_division_controller::class, 'addSmallGroup'])->middleware('auth');
Route::get('/division_details/{id}', [manage_division_controller::class, 'divisionDetailsView'])->middleware('auth')->name('division_details');
Route::get('/village_details/{id}', [manage_division_controller::class, 'villageDetailsView'])->middleware('auth')->name('village_details');
Route::get('/smallgroup_details/{id}', [manage_division_controller::class, 'smallgroupDetailsView'])->middleware('auth')->name('smallgroup_details');

Route::post('/createdivisiondata', [add_division_controller::class, 'createdivisiondata'])->middleware('auth');
Route::post('/createvillagedata', [add_division_controller::class, 'createvillagedata'])->middleware('auth');
Route::post('/update-division-data', [add_division_controller::class, 'updateDivisionData'])->middleware('auth');
Route::post('/createGnDivisiondata', [manage_division_controller::class, 'creategnDivisiondata'])->middleware('auth');
Route::post('/createsmallgroupdata', [add_division_controller::class, 'createsmallgroupdata'])->middleware('auth');

Route::post('/delete-division-data', [add_division_controller::class, 'deleteDivision']);

Route::post('/delete-village-data', [add_division_controller::class, 'deleteVillage']);

Route::get('/get-villages/{divisionId}', [add_division_controller::class, 'getVillages'])->middleware('auth');
Route::get('/get-gndivision/{divisionId}', [add_division_controller::class, 'getGnDivision'])->middleware('auth');
Route::get('/division_by_gn', [manage_division_controller::class, 'manageDivision'])->middleware('auth');
Route::get('/create_division_by_gn', [manage_division_controller::class, 'createDivision'])->middleware('auth');
Route::get('/create_smallgroup_by_gn', [manage_division_controller::class, 'createSmallgroupBygn'])->middleware('auth');
Route::post('/updateassignsmallgroup', [manage_division_controller::class, 'updateassignsmallgroup'])->middleware('auth');
Route::post('/get-gn-division-data', [manage_division_controller::class, 'getGnDivision'])->middleware('auth');
Route::post('/create-gndivision-smallgroup', [manage_division_controller::class, 'createGnSmallGroup'])->middleware('auth');
Route::post('/update-division-details', [manage_division_controller::class, 'updateDivisionDetails'])->middleware('auth');
Route::post('/update-village-details', [manage_division_controller::class, 'updateVillageDetails'])->middleware('auth');
Route::post('/update-smallgroup-details', [manage_division_controller::class, 'updateSmallGroupDetails'])->middleware('auth');

Route::post('/get-village-data', [manage_division_controller::class, 'getVillageData'])->middleware('auth');
Route::post('/get-small-group-data', [manage_division_controller::class, 'getSmallGroupData'])->middleware('auth');
//manage division

//manage member
Route::get('/create_member', [member_controller::class, 'createMember'])->middleware('auth');
Route::get('/manage_member', [manage_member_controller::class, 'manageMember'])->middleware('auth');
Route::get('/view_member/{id}', [manage_member_controller::class, 'viewMember'])->middleware('auth')->name('view_member');
Route::get('/update_member/{id}', [manage_member_controller::class, 'updateMember'])->middleware('auth')->name('update_member');
Route::post('/createmembers', [member_controller::class, 'createmembers'])->middleware('auth');
Route::post('/create-member-notes', [member_controller::class, 'createmembersNote'])->middleware('auth');
Route::post('/create-member-location', [member_controller::class, 'createMemberLocation'])->middleware('auth');
Route::get('/show_member/{id}', [manage_member_controller::class, 'showMember'])->middleware('auth')->name('show_member');
Route::get('/view_saving_history_mem/{id}', [manage_member_controller::class, 'viewSavHisMem'])->middleware('auth')->name('view_saving_history_mem');
Route::get('/view_loan_details_mem/{id}', [manage_member_controller::class, 'viewLoanDetailsMem'])->middleware('auth')->name('view_loan_details_mem');
Route::get('/view_death_history_mem/{id}', [manage_member_controller::class, 'viewDeathHisMem'])->middleware('auth')->name('view_death_history_mem');

Route::post('/upload-member-documents', [member_controller::class, 'uploadMemberDocument'])->middleware('auth');
Route::post('/update-profile-image', [member_controller::class, 'updateProfileImage'])->middleware('auth');
Route::post('/update-signature-image', [member_controller::class, 'updateSignatureImage'])->middleware('auth');
Route::post('/create-member-user', [member_controller::class, 'createMemberUser'])->middleware('auth');

Route::post('/import-member-data', [member_controller::class, 'importMember'])->middleware('auth');
Route::post('/updatemembersdata', [member_controller::class, 'updatemembersdata'])->middleware('auth');
Route::delete('/delete_member/{id}', [manage_member_controller::class, 'deletemember'])->name('delete_member');
Route::get('/get-smallgroup/{villageId}/{divisionIdValue}', [member_controller::class, 'getSmallGroup']);
Route::get('/get-smallgroup-gn/{villageId}/{divisionIdValue}', [member_controller::class, 'getSmallGroupGN']);
Route::get('/get-sub-profession/{professionId}', [member_controller::class, 'getSubProfession']);
Route::get('/get-smallgroup-by-gn/{divisionIdValue}', [member_controller::class, 'getSmallGroupByGn']);
Route::get('/filter-members', [manage_member_controller::class, 'filterMembersByDivision'])->name('filter_members_by_division');
Route::get('/filter-villages', [manage_member_controller::class, 'filterMembersByVillage'])->name('filter_members_by_village');
Route::post('/get-member-saving-account-data', [member_controller::class, 'getMemberAccData'])->middleware('auth');
Route::post('/create-member-status-data', [member_controller::class, 'updateMemberStatus'])->middleware('auth');

//manage member

///Generate PDF
Route::get('/member/summary/pdf/{id}', [generate_controller::class, 'viewPdf'])->name('view_pdf');
Route::get('/member/details/pdf/{id}', [generate_controller::class, 'viewPdfPersonal'])->name('view_pdf_personal');
Route::get('/loan/pdf', [generate_controller::class, 'viewPdfLoan'])->name('view_pdf_loan');
Route::get('/member/pdf', [generate_controller::class, 'viewPdfMember'])->name('view_pdf_member');
Route::post('/export-member-pdf', [generate_controller::class, 'exportMemberPdf'])->name('export_member_pdf');
Route::get('/withdrawal/pdf', [generate_controller::class, 'viewPdfWithdrawal'])->name('view_withdrawal_report');
Route::get('/collection/pdf', [generate_controller::class, 'viewPdfCollection'])->name('view_collection_report');
Route::get('/collectionvsdeposit/pdf', [generate_controller::class, 'viewPdfCollectionvsdeposit'])->name('view_collection_vs_deposit_report');
Route::get('/loanreport/pdf', [generate_controller::class, 'viewPdfLoanReport'])->name('view_pdf_loan_report');
Route::get('/loanarreas/pdf', [generate_controller::class, 'viewPdfLoanArreas'])->name('view_pdf_loan_arreas_report');
///Generate PDF

//Manage Account
Route::get('/create_account', [account_controller::class, 'createAccount'])->middleware('auth');
Route::get('/manage_account', [account_controller::class, 'manageAccount'])->middleware('auth');
Route::get('/view_account_details/{id}', [account_controller::class, 'viewAccountDetails'])->middleware('auth')->name('view_account_details');

Route::post('/add-account-data', [account_controller::class, 'addAccount'])->middleware('auth');
Route::post('/add-expensive-income-data', [account_controller::class, 'addExpensiveIncome'])->middleware('auth');
Route::post('transfer-account-data', [account_controller::class, 'transferAccount'])->middleware('auth');
Route::post('account-account-transfer-data', [account_controller::class, 'transferAccountToAccount'])->middleware('auth');
//Manage Account

//manage savings
Route::post('import-saving-history-data', [manage_savings_controller::class, 'importSavingsData'])->middleware('auth');
Route::get('/manage_savings', [manage_savings_controller::class, 'manageSavings'])->middleware('auth');
Route::get('/view_saving_history/{id}', [manage_savings_controller::class, 'viewSavingsHistory'])->middleware('auth')->name('view_saving_history');
Route::get('/view_savings_histories/{id}', [manage_savings_controller::class, 'viewSavingsHistories'])->middleware('auth')->name('view_savings_histories');
//manage savings

//Loan Request
Route::get('/view_loan_request/{id}', [loan_request_controller::class, 'viewLoanRequest'])->middleware('auth')->name('view_loan_request');
Route::get('/view_request/{id}', [loan_request_controller::class, 'viewRequest'])->middleware('auth')->name('view_request');

Route::post('/get-loan-purpose-sub-cat-data', [loan_request_controller::class, 'getPurposeSubCat'])->middleware('auth');
Route::post('/add-loan-request-data', [loan_request_controller::class, 'addLoanRequest'])->middleware('auth');
Route::post('/add-loan-request-approve-data', [loan_request_controller::class, 'addLoanRequestApprove'])->middleware('auth');
Route::post('/add-loan-request-member-approve-data', [loan_request_controller::class, 'addLoanRequestApproveMember'])->middleware('auth');
Route::post('/add-loan-request-rejected-data', [loan_request_controller::class, 'addLoanRequestRejected'])->middleware('auth');
Route::post('/get-loan-request-amount-data', [loan_request_controller::class, 'getLoanAmount'])->middleware('auth');
Route::post('/get-loan-request-amount-data-new', [loan_request_controller::class, 'getLoanAmountNew'])->middleware('auth');
Route::post('/loan-interest-wise-data', [loan_request_controller::class, 'loanInterestWiseData'])->middleware('auth');
Route::post('/loan-write-off-data', [loan_request_controller::class, 'loanWriteOffData'])->middleware('auth');
//Loan Request

//Manage Loan
Route::get('/manage_loan_product', [loan_product_controller::class, 'manageLoanProduct'])->middleware('auth');
Route::get('/create_loan_product', [loan_product_controller::class, 'createLoanProduct'])->middleware('auth');
Route::get('/list_of_loan', [loan_controller::class, 'listOfLoan'])->middleware('auth');
Route::get('/create_loan', [loan_controller::class, 'createLoan'])->middleware('auth');
Route::post('/get-loan-product-data', [loan_controller::class, 'getLoanProduct'])->middleware('auth');
Route::get('/manage_loan_purpose', [loan_controller::class, 'manageLoanPurpose'])->middleware('auth');
Route::get('/loan_follower/{id}', [loan_controller::class, 'loanFollower'])->middleware('auth')->name('loan_follower');
Route::get('/view_loan_approval/{id1}/{id2}', [loan_controller::class, 'viewLoanApproval'])->middleware('auth')->name('view_loan_approval');
Route::get('/view_loan_details/{id}', [loan_controller::class, 'viewLoanDetails'])->middleware('auth')->name('view_loan_details');
Route::get('/loan_repayment', [loan_product_controller::class, 'manageLoanRepayment'])->middleware('auth');
Route::get('/manage_loan_request', [loan_product_controller::class, 'manageLoanRequest'])->middleware('auth');
Route::get('/manage_approval_settings', [loan_product_controller::class, 'manageApprovalSettings'])->middleware('auth');
Route::get('/create_loan_request/{id}', [loan_controller::class, 'createLoanRequest'])->middleware('auth')->name('create_loan_request');

Route::post('/create-product-data', [loan_product_controller::class, 'createProduct'])->middleware('auth');
Route::post('/add-purpose-data', [loan_product_controller::class, 'addPurpose'])->middleware('auth');
Route::post('/create-new-loan', [loan_controller::class, 'createLoanFinal'])->middleware('auth');
Route::post('/create-loan-first-step', [loan_product_controller::class, 'createLoanFirst'])->middleware('auth');
Route::post('/create-loan-guarantors-step', [loan_product_controller::class, 'createLoanGuarantors'])->middleware('auth');
Route::post('/get-loan-product-data-check', [loan_product_controller::class, 'getLoanProductData'])->middleware('auth');
Route::post('/add-loan-approval-data', [loan_controller::class, 'loanApprovalData'])->middleware('auth');
Route::post('/calculate-loan-amount', [loan_controller::class, 'calculateLoanAmount'])->middleware('auth');
Route::post('/get-member-loan-data', [loan_controller::class, 'getMemberLoanData'])->middleware('auth');
Route::post('/get-loan-repayment-data', [loan_controller::class, 'getLoanRepaymentData'])->middleware('auth');
Route::post('/add-approval-settings-data', [loan_product_controller::class, 'createApprovalSettings'])->middleware('auth');
Route::post('/add-sub-category-data', [loan_product_controller::class, 'createSubCatData'])->middleware('auth');
Route::post('/pay-repayment-data', [loan_product_controller::class, 'payRepaymentData'])->middleware('auth');
Route::post('/import-repayment-data', [loan_product_controller::class, 'importRepaymentData'])->middleware('auth');
Route::post('/get-loan-document-data', [loan_product_controller::class, 'loanDocumentData'])->middleware('auth');

Route::get('/create_old_loan', [manage_old_loan_controller::class, 'createOldLoan'])->middleware('auth');
Route::post('/get-old-loan-gurantos-data', [manage_old_loan_controller::class, 'getGurrandas'])->middleware('auth');
Route::post('/create-old-loan-data', [manage_old_loan_controller::class, 'createOldLoanData'])->middleware('auth');
Route::post('/update-purpose-main-cat-data', [manage_old_loan_controller::class, 'updatePurposeMaincatData'])->middleware('auth');
//Manage loan

//Receipt
Route::get('/direct_saving_receipt/{id}', [receipt_controller::class, 'directSavingReceipt'])->middleware('auth')->name('direct_saving_receipt');
Route::get('/repayment_receipt/{id}', [receipt_controller::class, 'repaymentReceipt'])->middleware('auth')->name('repayment_receipt');
//Receipt

//manage death
Route::get('/manage_death', [death_manage_controller::class, 'manageDeath'])->middleware('auth');
Route::get('/manage_death_donation', [death_manage_controller::class, 'manageDeathDonation'])->middleware('auth');
Route::get('/view_death_history/{id}', [death_manage_controller::class, 'viewDeathHistory'])->middleware('auth')->name('view_death_history');
Route::get('/view_death_donation_recommand/{id}', [death_manage_controller::class, 'viewDeathDonationRecommand'])->middleware('auth')->name('view_death_donation_recommand');
Route::get('/view_death_donation_approve/{id}', [death_manage_controller::class, 'viewDeathDonationApprove'])->middleware('auth')->name('view_death_donation_approve');
Route::get('/view_death_donation_distribute/{id}', [death_manage_controller::class, 'viewDeathDonationDistribute'])->middleware('auth')->name('view_death_donation_distribute');
Route::get('/view_death_donation_history/{id}', [death_manage_controller::class, 'viewDeathDonationHistory'])->middleware('auth')->name('view_death_donation_history');

Route::post('/import-death-history-data', [death_manage_controller::class, 'deathHistoryData'])->middleware('auth');
Route::post('/add-death-donation-data', [death_manage_controller::class, 'deathDonationData'])->middleware('auth');
Route::post('/add-death-recommand-data', [death_manage_controller::class, 'deathRecommandData'])->middleware('auth');
Route::post('/add-donation-rejected-data', [death_manage_controller::class, 'donationRejectedData'])->middleware('auth');
Route::post('/add-death-approve-data', [death_manage_controller::class, 'deathApproveData'])->middleware('auth');
Route::post('/add-death-distribute-data', [death_manage_controller::class, 'deathDistributeData'])->middleware('auth');
//manage death


//Manage Other Income
Route::get('/manage_other_incomes', [manage_other_income_controller::class, 'manageOtherIncomes'])->middleware('auth');

Route::post('/import-other-income-data', [manage_other_income_controller::class, 'otherIncomeImportData'])->middleware('auth');
//Manage Other Income

//Opening Balance
Route::get('/opening_balance', [opening_balance_controller::class, 'openingBalance'])->middleware('auth');

Route::post('/create-opening-savings-balance', [opening_balance_controller::class, 'saveOpeningBalance'])->middleware('auth');
//Opening Balance

//Manage direct savings
Route::get('/direct_savings', [manage_direct_savings_controller::class, 'directSavings'])->middleware('auth');

Route::post('/insert-direct-savings', [manage_direct_savings_controller::class, 'insertDirectSavings'])->middleware('auth');
Route::post('/get-member-details', [manage_direct_savings_controller::class, 'memberDetails'])->middleware('auth');
//Manage direct savings

//collection
Route::get('/collection_deposit', [collection_controller::class, 'collectionDeposit'])->middleware('auth');
Route::get('/collection_transfer', [collection_controller::class, 'collectionTransfer'])->middleware('auth');
Route::get('/collection_vs_deposit_reports', [collection_controller::class, 'collectionvsdeposit'])->middleware('auth');

Route::post('/insert-collection-deposit', [collection_controller::class, 'depositCollection'])->middleware('auth');
Route::post('/create-collection-transfer-data', [collection_controller::class, 'createCollectionTransferData'])->middleware('auth');
//collection


//manage withdrawal
Route::post('/create-withdrawal-data', [withdrawal_controller::class, 'createWithdrawal'])->middleware('auth');
Route::post('/add-first-approve-data', [withdrawal_controller::class, 'firstApproval'])->middleware('auth');
Route::post('/add-second-approve-data', [withdrawal_controller::class, 'secondApproval'])->middleware('auth');
Route::post('/add-third-approve-data', [withdrawal_controller::class, 'thirdApproval'])->middleware('auth');
Route::post('/add-forth-approve-data', [withdrawal_controller::class, 'forthApproval'])->middleware('auth');
Route::get('/withrawal_approve_reports', [withdrawal_controller::class, 'withApproveStatus'])->middleware('auth');

Route::get('/view_withdrawal_request/{id}', [withdrawal_controller::class, 'approveWithdrawal'])->middleware('auth')->name('view_withdrawal_request');
Route::get('/view_withdrawal_history/{id}', [withdrawal_controller::class, 'viewWithHistory'])->middleware('auth')->name('view_withdrawal_history');
//manage withdrawal

//Manage settings
Route::get('/manage_settings', [manage_settings_controller::class, 'manageSettings'])->middleware('auth');
Route::get('/manage_profession', [manage_settings_controller::class, 'manageProfession'])->middleware('auth');
Route::get('/create_profession', [manage_settings_controller::class, 'createProfession'])->middleware('auth');
Route::get('/manage_activitylog', [manage_settings_controller::class, 'manageActivitylog'])->middleware('auth');
Route::get('/manage_account_settings', [manage_settings_controller::class, 'manageAccountSettings'])->middleware('auth');
Route::get('/manage_interest_settings', [manage_settings_controller::class, 'manageInterstSettings'])->middleware('auth');
Route::get('/meeting_category', [manage_settings_controller::class, 'meetingCategory'])->middleware('auth');
Route::get('/loan_document_settings', [manage_settings_controller::class, 'loanDocumentSettings'])->middleware('auth');
Route::get('/manage_relative_settings', [manage_settings_controller::class, 'relativeSettings'])->middleware('auth');

Route::post('/add-profession-data', [manage_settings_controller::class, 'addProfession'])->middleware('auth');
Route::post('/add-sub-profession-data', [manage_settings_controller::class, 'addSubProfession'])->middleware('auth');
Route::post('/add-relative-data', [manage_settings_controller::class, 'addRelative'])->middleware('auth');
Route::post('/add-meeting-category-data', [manage_settings_controller::class, 'addMeetingCategory'])->middleware('auth');
Route::post('/update-profession-data', [manage_settings_controller::class, 'updateProfession'])->middleware('auth');
Route::post('/update-meeting-category-data', [manage_settings_controller::class, 'updateMeetingCategory'])->middleware('auth');
Route::post('/delete-profession-data', [manage_settings_controller::class, 'deleteProfession'])->middleware('auth');
Route::post('/update-account-details', [manage_settings_controller::class, 'updateAccountDetails'])->middleware('auth');
Route::post('/add-interest-settings-data', [manage_settings_controller::class, 'interestSettingData'])->middleware('auth');
Route::post('/add-loan-document-data', [manage_settings_controller::class, 'loanDocData'])->middleware('auth');
//Manage Settings

//manage reports
Route::get('/manage_reports', [manage_reports_controller::class, 'manageReports'])->middleware('auth');
Route::get('/collection_reports', [manage_reports_controller::class, 'collectionReport'])->middleware('auth');
Route::get('/member_report', [manage_reports_controller::class, 'memberReport'])->middleware('auth');
Route::get('/opening_balance_report', [manage_reports_controller::class, 'openingBalanceReport'])->middleware('auth');
Route::get('/loan_report', [manage_reports_controller::class, 'loanReport'])->middleware('auth');
Route::get('/loan_arreas_report', [manage_reports_controller::class, 'loanArreasReport'])->middleware('auth');
Route::get('/group_report', [manage_reports_controller::class, 'groupReport'])->middleware('auth');
Route::get('/group_leader_report', [manage_reports_controller::class, 'groupLeaderReport'])->middleware('auth');
Route::get('/member_savings_report', [manage_reports_controller::class, 'memberSavingReport'])->middleware('auth');
Route::get('/view_member_saving_report/{id}', [manage_reports_controller::class, 'viewMemberSavingReport'])->middleware('auth')->name('view_member_saving_report');
//manage reports

//Member Login
//Member Login

//Manage Meetings
Route::get('/add_meeting', [manage_meeting_controller::class, 'addMeetings'])->middleware('auth');

Route::post('/get-meeting-village-data', [manage_meeting_controller::class, 'getMeetingVillageData'])->middleware('auth');
Route::post('/get-meeting-smallgroup-data', [manage_meeting_controller::class, 'getMeetingSmallgroupData'])->middleware('auth');
//Manage Meetings

Route::get('/error401', [error_controller::class, 'error401']);

