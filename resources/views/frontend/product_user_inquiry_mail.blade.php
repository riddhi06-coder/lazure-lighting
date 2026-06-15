<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Inquiry</title>
    <style>
        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            background-color: #f9fafc;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .email-container {
            width:100%;
            max-width:680px;
            margin:auto;
            background:#ffffff;
            padding:35px 30px;
            border-radius:12px;
            border:1px solid #dde3e8;
            box-shadow:0px 3px 15px rgba(0,0,0,0.08);
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
        strong {
            color: #000;
        }
        .highlight-box {
            background:#f2f7fc;
            padding:22px 18px;
            border-left:4px;
            border-radius:6px;
            margin-top:12px;
            font-size: 16px;
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
        <img src="{{ asset('frontend/assets/images/home/logo.png') }}" alt="Lazure Lighting">
    </div>

    <div class="divider"></div>

    <!-- Content -->
    <div class="content">

        <h2>Thank You for Reaching Out!</h2>

        <p>Dear <strong>{{ $first_name }} {{ $last_name }}</strong>,</p>

        <p>
            We sincerely appreciate your interest in <strong>Lazure Lighting</strong>!.
            <br><br>
            Our team has received your inquiry and will get back to you shortly with assistance regarding below Products:-
        </p>

        <div class="highlight-box">
            <strong>Product:</strong> {{ $sub_product_name }}
        </div>
        
        <br>
        <p style="margin-top:15px;">
           Thank you for trusting <strong>Lazure Lighting</strong> to brighten your spaces.
            We look forward to supporting you!
        </p>
        
        <br>
        <p>Warm Regards,<br>
        <strong>Team Lazure Lighting</strong></p>

    </div>

    <div class="divider"></div>

    <!-- Footer -->
    <div class="footer">
        © {{ date('Y') }} Lazure Lighting. All Rights Reserved.
    </div>

</div>

</body>
</html>
