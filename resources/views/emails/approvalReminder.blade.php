<!DOCTYPE html>
<html>
<head>
    <title>Approval Reminder for Checksheet <strong>{{$checksheetHead->machine_name}}</strong></title>
</head>
<body>
    <h1>Approval Needed</h1>
    <p>This is a reminder to approve the pending checksheet <strong>{{$checksheetHead->machine_name}}</strong> </p>
    <p>To review and approve the checksheet, please click on the link below:</p>

    <strong><a href="{{ url('/checksheet/approve/'.encrypt($checksheetHead->id)) }}">Approve Checksheet</a></strong>

     <p>Thank you for your attention to this matter.</p>
</body>
</html>
