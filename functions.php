<?php

function removeParam($url, $param) {
    $url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*$/', '', $url);
    $url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*&/', '$1', $url);
    return $url;
}

function generateRandomString($length = 10, $type = true) {
    if($type) 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    else
        $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function isMobile() {
    return preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function excerpt ($string, $length=100, $end='...'){
    $string = strip_tags($string);
    if (strlen($string) > $length) {
        $stringCut = substr($string, 0, $length);
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).$end;
    }
    return $string;
}

function sendMail ($mail, $to, $subject, $html, $txt){
    try {
        $mail->isSMTP();
        $mail->Host       = 'email.server.address.here';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'real@smtp-email.here';
        $mail->Password   = 'password_for_SMTP';
        $mail->Port       = 25;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('real@smtp-email.here', 'Email title');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $html;
        $mail->AltBody = $txt;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

?>