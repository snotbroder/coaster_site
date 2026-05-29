<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once ROOT . "/vendor/autoload.php";

function send_mail(string $to, string $subject, string $body): bool
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = "send.one.com";
    $mail->SMTPAuth   = true;
    $mail->Username   = "contact@voorde.dk";
    $mail->Password   = "";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom("contact@voorde.dk", "Coaster Codex");
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    return $mail->send();
}
