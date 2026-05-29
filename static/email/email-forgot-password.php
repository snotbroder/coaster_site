<?php

/** @var string $reset_link */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 560px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: #1a1a2e;
            padding: 32px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
        }

        .body {
            padding: 32px;
            color: #333333;
        }

        .body p {
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            margin: 24px 0;
            padding: 14px 28px;
            background: #e63946;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .footer {
            padding: 16px 32px;
            background: #f4f4f4;
            color: #999999;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Coaster Codex</h1>
        </div>
        <div class="body">
            <p>Hi,</p>
            <p>We received a request to reset your password. Click the button below to choose a new one. This link expires in <strong>1 hour</strong>.</p>
            <a href="<?= htmlspecialchars($reset_link) ?>" class="btn">Reset my password</a>
            <p>If you didn't request a password reset, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            &copy; <?= date("Y") ?> Coaster Codex &mdash; This is an automated message, please do not reply.
        </div>
    </div>
</body>

</html>