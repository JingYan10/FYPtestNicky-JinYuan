<?php
    use PHPMailer\PHPMailer\PHPMailer;

    function forgetPassword($conn, $email){

        $digits = 5;
        $pinCode = rand(pow(10, $digits-1), pow(10, $digits)-1);

        $name = "Fanciado Foodo";
        $subject = "password recovery for Fanciado Foodo";
        $body = "pin :".$pinCode;

        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";

        $mail = new PHPMailer();

        //SMTP Settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "pier199981@gmail.com";
        $mail->Password = 'Nn33924401';
        $mail->Port = 465; //587
        $mail->SMTPSecure = "ssl"; //tls

        //Email Settings
        $mail->isHTML(true);
        $mail->setFrom($email, $name);
        $mail->addAddress("$email");
        $mail->Subject = $subject;
        $mail->Body = $body;

        if ($mail->send()) {
            session_start();
            $_SESSION["pinCode"]=$pinCode;
            $_SESSION["recoveryUserEmail"]=$email;
        } else {
          
        }

        //exit(json_encode(array("status" => $status, "response" => $response)));
    }
        

?>
