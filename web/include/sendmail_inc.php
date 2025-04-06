<?php
if (filter_var($Recipient, FILTER_VALIDATE_EMAIL)){
    require '../PHPMailer/Exception.php';
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/SMTP.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 2;                                        
    $mail->SMTPAuth = false;
    $mail->Host = "mailgw.cse.ttu.edu.tw";
    $mail->Port = 26;
    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";
    $mail->WordWrap = 500;
    $mail->Username = "mailmaster@isrcttu.net";
    $mail->SetFrom('mailmaster@isrcttu.net', '郵件系統管理員');
    $mail->Subject = $Subject;
    $mail->AddAddress($Recipient, $Recipient);
    $Notice = $Recipient . " 您好\n\n" . $Message . "\n\n此信件為系統自動發出請勿回覆，謝謝！\n";
    $mail->Body = $Notice;
    $mail->Send();
    $mail->ClearAllRecipients();
}
?>