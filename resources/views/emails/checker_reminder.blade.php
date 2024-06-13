<!DOCTYPE html>
<html>
<head>
    <title>Approval Reminder for Checksheet MTC - S {{$checksheetHead->machine_name}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #555;
            margin-bottom: 20px;
        }
        strong {
            color: #007bff;
        }
        a {
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Check Needed</h1>
        <p>This is a reminder to check the pending checksheet <strong>{{$checksheetHead->machine_name}}</strong>.</p>
        <p>Remarks: <strong>{{ $checksheetHead->remark }}</strong></p>
        <p>To review and check the checksheet, please click on the link below:</p>

        <p><a href="{{ url('/checksheet/checkher/'.encrypt($checksheetHead->id)) }}">Check Checksheet</a></p>

        <p>Thank you for your attention to this matter.</p>

        <p>PT.Mitsubishi Krama Yudha Motors and Manufacturing</p>
    </div>
</body>
</html>
