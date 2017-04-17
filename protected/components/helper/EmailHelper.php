<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EmailHelper {

    public static function sendMail($data) {
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        // $mail->SMTPDebug = 2;
        $mail->IsSMTP();                                      // Set mailer to use SMTP
        $mail->Host = Yii::app()->setting->getItem('smtpHost');  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = Yii::app()->setting->getItem('smtpUsername');                 // SMTP username
        $mail->Password = Yii::app()->setting->getItem('smtpPassword');                           // SMTP password
        $mail->SMTPSecure = Yii::app()->setting->getItem('encryption');
        $mail->Port = Yii::app()->setting->getItem('smtpPort');                                    // TCP port to connect to

        $mail->SetFrom(Yii::app()->setting->getItem('smtpUsername'), Yii::app()->setting->getItem('mailSenderName'));

        if (is_array($data['to'])) {
            foreach ($data['to'] as $item) {
                if (trim($item) != "")
                    $mail->AddAddress(trim($item), '');
            }
        } else if ($data['to'] != ''){
            $mail->AddAddress($data['to'], '');
        }

        if (isset($data['cc']) && !empty($data['cc']) && strpos($data['cc'], ',')) {
            $data['cc'] = explode(',', $data['cc']);
        }
        
        if (isset($data['cc']) && !empty($data['cc']) && is_array($data['cc'])) {
            foreach ($data['cc'] as $item) {
                $mail->AddCC($item);
            }
        } else if (isset($data['cc']) && !empty($data['cc'])) {
            $mail->AddCC($data['cc']);
        }
        // $mail->AddCC('xu5000vnd@gmail.com');
        if (isset($data['attach']) && !empty($data['attach']) && is_array($data['attach'])) {
            foreach ($data['attach'] as $item) {
                $mail->AddAttachment($item['path'], $item['name']);
            }
        }

        $mail->AddReplyTo(Yii::app()->setting->getItem('smtpUsername'), 'Information');

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $data['subject'];
        $mail->Body    = $data['message'];
        $mail->AltBody = $data['message'];
        $mail->Send();
    }

}

?>
