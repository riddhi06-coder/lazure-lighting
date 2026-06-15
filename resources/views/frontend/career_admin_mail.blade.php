<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Submission</title>
    <style>
        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            background-color: #f9fafc;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }
        .header {
            background-color: #0f1010;
            padding: 30px 30px;
            text-align: center;
        }
        .header img {
            width: 160px;
        }
        .content {
            padding: 30px;
        }
        h2 {
            font-size: 20px;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 25px;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
            margin: 8px 0;
        }
       
        .divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 0;
        }
        .footer {
            background-color: #f2f5f8;
            padding: 18px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="email-container">

    <!-- Header -->
    <div class="header">
        <img src="{{ asset('frontend/assets/images/home/logo.png') }}" alt="Logo">
    </div>

    <div class="divider"></div>

    <!-- Content -->
    <div class="content">

        <h2>New Job Application: <strong>{{ $positionApplied }}</strong></h2>

        <p><strong>Position:</strong> {{ $positionApplied }}</p>
        <p><strong>Name:</strong> {{ $fullName }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Phone:</strong> {{ $phone }}</p>
        
        @if($userMessage != 'N/A')
        <p><strong>Message:</strong> {{ $userMessage }}</p>
        @endif

    </div>

    <div class="divider"></div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} Lazure Lighting. All rights reserved.
    </div>

</div>

</body>
</html>
