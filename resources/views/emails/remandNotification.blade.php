<!DOCTYPE html>
<html>
<head>
    <title>Checksheet Remand Notification</title>
</head>
<body>
    <h1>Checksheet Remand Notification</h1>
    <p>The checksheet with Machine Name {{ $checksheet->machine_name }} has been remanded.</p>
    <p>Remarks: {{ $remarks }}</p>

    <p>To review and approve the checksheet, please click on the link below:</p>

    <strong><a href="{{ url('/checksheet/update/'.encrypt($checksheet->id)) }}">Update Checksheet</a></strong>
</body>
</html>
