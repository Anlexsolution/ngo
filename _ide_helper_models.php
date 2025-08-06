<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $userType
 * @property string|null $fullName
 * @property string|null $nic
 * @property string|null $phoneNumber
 * @property string|null $DOB
 * @property string|null $professional
 * @property int|null $epfNo
 * @property string|null $gender
 * @property string|null $permissions
 * @property string|null $division
 * @property string|null $village
 * @property string|null $active
 * @property string|null $memberPermision
 * @property string|null $profileImage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $verify
 * @property int|null $otpCode
 * @property-read \App\Models\userRole|null $role
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereDOB($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereEpfNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereMemberPermision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereNic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereProfessional($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Users whereVillage($value)
 */
	class Users extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $branch
 * @property int $accountNumber
 * @property string $registerDate
 * @property string $status
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $balance
 * @property string|null $accountType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereRegisterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|account whereUpdatedAt($value)
 */
	class account extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $accountId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $balance
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accountsetting whereUpdatedAt($value)
 */
	class accountsetting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $collectionBy
 * @property int $memberId
 * @property string $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $status
 * @property int|null $accountId
 * @property string|null $balance
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereCollectionBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransectionhistory whereUpdatedAt($value)
 */
	class accounttransectionhistory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $userId
 * @property string $fromAccountId
 * @property string $toAccountId
 * @property string $transferAmount
 * @property string $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $fromAccountBalance
 * @property string|null $toAccountBalance
 * @property string|null $date
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereFromAccountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereFromAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereToAccountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereToAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereTransferAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|accounttransferhistory whereUserId($value)
 */
	class accounttransferhistory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $depositBy
 * @property string $amount
 * @property string $slipNo
 * @property string $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit whereDepositBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit whereSlipNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|collectiondeposit whereUpdatedAt($value)
 */
	class collectiondeposit extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $memberId
 * @property string $totalAmount
 * @property string $deathId
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\member|null $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription whereDeathId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathsubscription whereUpdatedAt($value)
 */
	class deathsubscription extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $deathId
 * @property string $memberId
 * @property string $type
 * @property string $balance
 * @property string $randomId
 * @property int $userId
 * @property string $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $accountId
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereDeathId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereRandomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|deathtransectionhistory whereUserId($value)
 */
	class deathtransectionhistory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $divisionName
 * @property int $deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division whereDivisionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|division whereUpdatedAt($value)
 */
	class division extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $divisionId
 * @property int|null $divisionHead
 * @property int|null $dmName
 * @property int|null $rcName
 * @property string|null $foName
 * @property string|null $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereDivisionHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereDmName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereFoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereRcName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|divisiondetail whereUpdatedAt($value)
 */
	class divisiondetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $divisionId
 * @property string $gnDivisionName
 * @property string|null $assignSmallGroup
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision whereAssignSmallGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision whereGnDivisionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivision whereUpdatedAt($value)
 */
	class gndivision extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $divisionId
 * @property string $gnDivisionId
 * @property string $smallGroupName
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup whereGnDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup whereSmallGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|gndivisionsmallgroup whereUpdatedAt($value)
 */
	class gndivisionsmallgroup extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|importfun whereUpdatedAt($value)
 */
	class importfun extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $memberId
 * @property int $loanProductId
 * @property string $principal
 * @property string|null $loanterm
 * @property string|null $repaymentFrequency
 * @property string|null $interestRate
 * @property string|null $repaymentPeriod
 * @property string|null $per
 * @property string|null $interestType
 * @property int|null $loanOfficer
 * @property string|null $loanPurpose
 * @property string|null $firstRepaymentDate
 * @property string|null $gurrantos
 * @property string|null $followerName
 * @property string|null $followerAddress
 * @property string|null $followerNic
 * @property string|null $followerNicIssueDate
 * @property string|null $followerPhone
 * @property string|null $followerProfession
 * @property int $createStatus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $approval
 * @property string|null $loanStatus
 * @property int|null $approvalStatus
 * @property string|null $loanId
 * @property string|null $loanType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereApprovalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereCreateStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereFirstRepaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereFollowerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereFollowerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereFollowerNic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereFollowerNicIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereFollowerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereFollowerProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereGurrantos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereInterestType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereLoanOfficer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereLoanProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereLoanPurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereLoanStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereLoanType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereLoanterm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan wherePer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan wherePrincipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereRepaymentFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereRepaymentPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loan whereUpdatedAt($value)
 */
	class loan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $memberId
 * @property string $selectedOption
 * @property string|null $remarks
 * @property int $requestId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval whereSelectedOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanRequestmemberApproval whereUpdatedAt($value)
 */
	class loanRequestmemberApproval extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $loanId
 * @property int $userId
 * @property string $approvalType
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $approvalStatus
 * @property string|null $reason
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereApprovalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereApprovalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapproval whereUserId($value)
 */
	class loanapproval extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $minimum
 * @property string $maximum
 * @property string $howManyApproval
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting whereHowManyApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting whereMaximum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting whereMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanapprovalsetting whereUpdatedAt($value)
 */
	class loanapprovalsetting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $productName
 * @property string|null $description
 * @property int|null $defaultPrincipal
 * @property int|null $minimumPrincipal
 * @property int|null $maximumPrincipal
 * @property int|null $defaultLoanTerm
 * @property int|null $minimumLoanTerm
 * @property int|null $maximumLoanTerm
 * @property string|null $repaymentFrequency
 * @property string|null $repaymentPeriod
 * @property int|null $defaultInterest
 * @property int|null $minimumInterest
 * @property int|null $maximumInterest
 * @property int|null $appprovalCount
 * @property string|null $per
 * @property string|null $active
 * @property string|null $interestType
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereAppprovalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereDefaultInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereDefaultLoanTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereDefaultPrincipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereInterestType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereMaximumInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereMaximumLoanTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereMaximumPrincipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereMinimumInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereMinimumLoanTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereMinimumPrincipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct wherePer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereRepaymentFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereRepaymentPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanproduct whereUpdatedAt($value)
 */
	class loanproduct extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurpose newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurpose newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurpose query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurpose whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurpose whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurpose whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurpose whereUpdatedAt($value)
 */
	class loanpurpose extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $mainCatId
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub whereMainCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanpurposesub whereUpdatedAt($value)
 */
	class loanpurposesub extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $loanId
 * @property string $repaymentDate
 * @property string $repaymentAmount
 * @property string $lastLoanBalance
 * @property string $interest
 * @property string $principalAmount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $memberId
 * @property string $transectionId
 * @property int $userId
 * @property int|null $days
 * @property string|null $savingAmount
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereLastLoanBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment wherePrincipalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereRepaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereRepaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereSavingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereTransectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrepayment whereUserId($value)
 */
	class loanrepayment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $memberId
 * @property int $loanAmount
 * @property int $mainCategoryId
 * @property int $subCategoryId
 * @property int $userTypeId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereLoanAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereMainCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanrequest whereUserTypeId($value)
 */
	class loanrequest extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $loanId
 * @property int|null $month
 * @property string $paymentDate
 * @property float $monthlyPayment
 * @property float $principalPayment
 * @property float $interestPayment
 * @property float $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereInterestPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereMonthlyPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule wherePrincipalPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loanschedule whereUpdatedAt($value)
 */
	class loanschedule extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $location
 * @property string|null $country
 * @property string $ipAddress
 * @property string|null $loginTime
 * @property string|null $logoutTime
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereLogoutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|loginactivitylog whereUpdatedAt($value)
 */
	class loginactivitylog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $firstName
 * @property string|null $lastName
 * @property string|null $address
 * @property string $nicNumber
 * @property string|null $nicIssueDate
 * @property string $newAccountNumber
 * @property string|null $oldAccountNumber
 * @property string|null $profession
 * @property string $gender
 * @property string|null $maritalStatus
 * @property string|null $phoneNumber
 * @property string|null $divisionId
 * @property string|null $villageId
 * @property string|null $smallGroupStatus
 * @property string|null $gnDivStatus
 * @property string|null $gnDivisionId
 * @property string|null $smallGroupId
 * @property string|null $followerName
 * @property string|null $followerAddress
 * @property string|null $followerNicNumber
 * @property string|null $followerIssueDate
 * @property string|null $dateOfBirth
 * @property string|null $profiePhoto
 * @property string|null $signature
 * @property string $uniqueId
 * @property int $deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $login
 * @property string|null $password
 * @property string|null $status
 * @property string|null $statusType
 * @property-read \App\Models\division|null $division
 * @property-read \App\Models\smallgroup|null $smallgroup
 * @property-read \App\Models\village|null $village
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereFollowerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereFollowerIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereFollowerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereFollowerNicNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereGnDivStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereGnDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereNewAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereNicIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereNicNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereOldAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereProfiePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereSmallGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereSmallGroupStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereStatusType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|member whereVillageId($value)
 */
	class member extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $memberId
 * @property string $documentName
 * @property string $documentPath
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument whereDocumentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|memberdocument whereUpdatedAt($value)
 */
	class memberdocument extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $memberId
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|membernote whereUpdatedAt($value)
 */
	class membernote extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $memberId
 * @property string $totalAmount
 * @property string $incomId
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\member|null $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome whereIncomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincome whereUpdatedAt($value)
 */
	class otherincome extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $incomId
 * @property string $memberId
 * @property string $type
 * @property string $balance
 * @property string $randomId
 * @property int $userId
 * @property string $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereIncomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereRandomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|otherincomehistory whereUserId($value)
 */
	class otherincomehistory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|profession whereUpdatedAt($value)
 */
	class profession extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $memberId
 * @property string $totalAmount
 * @property string $savingsId
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\member|null $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|saving whereUpdatedAt($value)
 */
	class saving extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $savingId
 * @property string $balance
 * @property string $randomId
 * @property int $userId
 * @property string $memberId
 * @property string $type
 * @property string $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereRandomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereSavingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|savingtransectionhistory whereUserId($value)
 */
	class savingtransectionhistory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $divisionId
 * @property string $villageId
 * @property string $smallGroupName
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup whereSmallGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroup whereVillageId($value)
 */
	class smallgroup extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $smallgroupId
 * @property int|null $groupLeader
 * @property int|null $secretary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail whereGroupLeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail whereSecretary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail whereSmallgroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|smallgroupdetail whereUpdatedAt($value)
 */
	class smallgroupdetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $userId
 * @property string $type
 * @property string $activity
 * @property string $className
 * @property string $ipAddress
 * @property string $location
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|systemactivitylog whereUserId($value)
 */
	class systemactivitylog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $userType
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tbl_userType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tbl_userType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tbl_userType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tbl_userType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tbl_userType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tbl_userType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tbl_userType whereUserType($value)
 */
	class tbl_userType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $roleName
 * @property string $permission
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|userRole whereUpdatedAt($value)
 */
	class userRole extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $divisionId
 * @property string $villageName
 * @property int $deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|village whereVillageName($value)
 */
	class village extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $villageId
 * @property int|null $foName
 * @property int|null $villageLeader
 * @property int|null $secretary
 * @property string|null $staff
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $phone
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereFoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereSecretary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereVillageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|villagedetail whereVillageLeader($value)
 */
	class villagedetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $userId
 * @property string $amount
 * @property int $request
 * @property string $status
 * @property string $memberId
 * @property string $savingId
 * @property string $withdrawalId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $bankAccount
 * @property string|null $approveUserType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereApproveUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereSavingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawal whereWithdrawalId($value)
 */
	class withdrawal extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $memberId
 * @property string $savingId
 * @property string $withdrawalId
 * @property string $amount
 * @property string $status
 * @property string $userId
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $request
 * @property string|null $approveUserType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereApproveUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereSavingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|withdrawalhistory whereWithdrawalId($value)
 */
	class withdrawalhistory extends \Eloquent {}
}

