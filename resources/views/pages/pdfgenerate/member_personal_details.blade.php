<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Member Details</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            position: relative;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 10px;
        }

        .profile-image,
        .signature-image {
            display: block;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            object-fit: cover;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        .label {
            font-weight: bold;
            width: 30%;
        }

        .value {
            width: 70%;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-style: italic;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('assets/img/logo.png') }}" width="100" height="50">
    </div>
    <div class="company-info">
        <div>Sagama Road, Akkaraipattu</div>
        <div>Phone: 0123456789</div>
        <div>Date: {{ now()->format('Y-m-d H:i:s') }}</div>
    </div>
    <hr>
    <h3 class="header">Member Personal Details</h3>

    <div style="text-align: center; margin-bottom: 10px;">
        <img src="{{ public_path('memberimages/' . $member->profiePhoto) }}" width="100" height="100"
            class="profile-image">
    </div>

    <table>
        <tr>
            <td class="label">Title</td>
            <td class="value">{{ $member->title }}</td>
        </tr>
        <tr>
            <td class="label">First Name</td>
            <td class="value">{{ $member->firstName }}</td>
        </tr>
        <tr>
            <td class="label">Last Name</td>
            <td class="value">{{ $member->lastName }}</td>
        </tr>
        <tr>
            <td class="label">Address</td>
            <td class="value">{{ $member->address }}</td>
        </tr>
        <tr>
            <td class="label">NIC</td>
            <td class="value">{{ $member->nicNumber }}</td>
        </tr>
        <tr>
            <td class="label">NIC Issue Date</td>
            <td class="value">{{ $member->nicIssueDate }}</td>
        </tr>
        <tr>
            <td class="label">New Account Number</td>
            <td class="value">{{ $member->newAccountNumber }}</td>
        </tr>
        <tr>
            <td class="label">Old Account Number</td>
            <td class="value">{{ $member->oldAccountNumber }}</td>
        </tr>
        <tr>
            <td class="label">Profession</td>
            <td class="value">{{ $member->profession }}</td>
        </tr>
        <tr>
            <td class="label">Gender</td>
            <td class="value">{{ $member->gender }}</td>
        </tr>
        <tr>
            <td class="label">Marital Status</td>
            <td class="value">{{ $member->maritalStatus }}</td>
        </tr>
        <tr>
            <td class="label">Phone Number</td>
            <td class="value">{{ $member->phoneNumber }}</td>
        </tr>
        <tr>
            <td class="label">Follower Name</td>
            <td class="value">{{ $member->followerName }}</td>
        </tr>
        <tr>
            <td class="label">Follower Address</td>
            <td class="value">{{ $member->followerAddress }}</td>
        </tr>
        <tr>
            <td class="label">Follower NIC</td>
            <td class="value">{{ $member->followerNicNumber }}</td>
        </tr>
        <tr>
            <td class="label">Follower NIC Issue Date</td>
            <td class="value">{{ $member->followerIssueDate }}</td>
        </tr>
        <tr>
            <td class="label">Division</td>
            <td class="value">{{ $member->division->divisionName ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Village</td>
            <td class="value">{{ $member->village->villageName ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Small Group</td>
            <td class="value">{{ $member->smallgroup->smallGroupName ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title" style="text-align: right">Signature</div>
    <div style="text-align: right; margin-bottom: 10px;">
        <img src="{{ public_path('memberimages/' . $member->signature) }}" width="80" height="80">
    </div>



    <div class="footer">
        This is an auto-generated document.
    </div>

</body>

</html>
