<?php

namespace app\assets;

use Yii;
use yii\helpers\Url;
use app\models\Timezone;
use app\models\Company;
use app\models\Country;
use app\models\Currency;
use app\models\User;
use app\models\Car;
use app\models\CarCost;
use app\assets\DateTime;
/**************************
    Global Functions
***************************/

class GlobalFunctions
{
    /******** Email Functions *********/

    // Simple email function
    public function sendMail ($name, $subject, $from_email, $to_email, $body) {
        $name='=?UTF-8?B?'.base64_encode($name).'?=';
        $subject='=?UTF-8?B?'.base64_encode($subject).'?=';
        $headers='From: $name <{$from_email}>\r\n'.
                 'Reply-To: {$from_email}\r\n'.
                 'MIME-Version: 1.0\r\n'.
                 'Content-type: text/plain; charset=UTF-8';

        mail($to_email,$subject,$body,$headers);
    }

    // Send Grid Mail Function
    public function sendGridMail($from_name, $from_email, $to_email, $subject, $body, $attachment = null) {        
        $sendGrid = Yii::$app->sendGrid;
        $message = $sendGrid->compose();
        $message->setFrom($from_email);
        if($from_email && $from_name)
            $message->setFrom([$from_email, $from_name]);
        $message->setTo($to_email)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send($sendGrid);
    }

    /*
    *  Get the POST data with the variable name.
    */
    public function getPost($name,$defaultValue=null)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        } else if (isset($_GET[$name])) {
            return $_GET[$name];
        } else if (isset($_REQUEST[$name])) {
            return $_REQUEST[$name];
        } else {
            $name = json_decode(file_get_contents('php://input'));
            if ($name) {
                return $name;
            } else {
                return $defaultValue;
            }
        }
    }

    /*
    *  This function encrypts the given string using 8 bit ECB mode.
    */
    public function encrypt($str, $key = GlobalConstants::DEFAULT_ENCRYPTION_KEY)
    {
        $block = mcrypt_get_block_size('des', 'ecb');
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);

        return mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
    }

    /*
    *  This function decrypts the given string using 8 bit ECB mode.
    */
    public function decrypt($str, $key = GlobalConstants::DEFAULT_ENCRYPTION_KEY)
    {
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);

        $block = mcrypt_get_block_size('des', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        return substr($str, 0, strlen($str) - $pad);
    }

    /*
    *   Creates a token and returns it
    */
    public function createToken ()
    {
        return rand(1000000,10000000);
    }

    /*
    *   Create a random password
    */
    public function createPassword()
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8);
    }

    /*
    *   Create a random salt
    */
    public function createSalt()
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 32);
    }

    /*
    *   Create an access token
    */
    public function createAccessToken()
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 32);
    }

    /*
    *    Upload a file into the uploads folder
    *    Restrictions: Size - MAX 3 MB
    */
    public function upload($field_name, $domain_id)
    {
        //if they DID upload a file...
        if($_FILES[$field_name]['name'])
        {
            //if no errors...
            if(!$_FILES[$field_name]['error'])
            {
                $valid_file = true;
                $file_name = $_FILES[$field_name]['name'];
                $size = $_FILES[$field_name]['size'];
                $type = $_FILES[$field_name]['type'];
                $new_file_name = strtolower($_FILES[$field_name]['tmp_name']); //rename file

                if($_FILES[$field_name]['size'] > (3072000)) //can't be larger than 3 MB
                {
                    $valid_file = false;
                    $message = 'Oops!  Your file\'s size is to large.';
                }

                //if the file has passed the test
                if($valid_file)
                {
                    $file = explode(".",$file_name);
                    $time = strtotime(date('m/d/Y h:i:sa'));
                    $path = Yii::$app->getBasePath().'/web/uploads/'.$domain_id;
                    $full_file_name = $path.'/'.$file[0].'_'.$time.'.'.$file[1];
                    if(!is_dir($path))
                        mkdir($path, 0700);
                    //move it to where we want it to be
                    move_uploaded_file($_FILES[$field_name]['tmp_name'], $full_file_name);
                    chmod($full_file_name, 0777);
                    $message = '/uploads/'.$domain_id.'/'.$file[0].'_'.$time.'.'.$file[1];                 
                }
            }
            //if there is an error...
            else
            {
                //set that to be the returned message
                $message = GlobalConstants::FALSE;
            }
        }

        return $message;
    }

    /*
    *   Generate MYSQL Timestamp
    */
    public static function createMysqlTimestamp()
    {
        return date("Y-m-d H:i:s");
    }

    /*
    *   Generate a salt and encrypt the password
    */
    public function createPasswordEncryption($password)
    {
        $salt = GlobalFunctions::createSalt();
        $encrypted_password = crypt($password, $salt);
        return array($salt, $encrypted_password);
    }

    /************************************
        EMAIL MESSAGE CREATION FUNCTIONS
    *************************************/
    // Verification Email
    public function createVerificationEmailMessage($first_name, $salt, $mobile=GlobalConstants::FALSE) {
        $message =  "Howdy ".$first_name."! <br><br>
                    Welcome to NIM. World's best productivity tool...<br><br>
                    Please click the link below to activate your account<br>";
        if (!$mobile) {
            $message = $message.Yii::app()->createAbsoluteUrl('site/verifyemail',array('salt'=>$salt));
        } else {
            $message = $message.Yii::app()->createAbsoluteUrl('api/verifyemail',array('salt'=>$salt));
        }
        $message =  $message."<br><br>
                    Thank you.<br>".GlobalConstants::ADMIN_NAME;
        return $message;
    }

    // Welcome to NIM Email
    public function sendSignupEmail($user)
    {
        $body = "Hello ".$user->firstname." ".$user->lastname.",<br/>
                         ".GlobalConstants::WELCOME."!<br/>
                         Please click <a href='".Url::toRoute(['site/signupemployee', 'salt' => $user->salt], true)."'>here</a> to complete your registration.<br/><br/>".GlobalConstants::ADMIN_NAME;
        GlobalFunctions::sendGridMail(GlobalConstants::ADMIN_NAME, GlobalConstants::ADMIN_EMAIL, $user->username, GlobalConstants::WELCOME, $body);    
        return;
    }

    //render user id has 6 digits
    public function getUserID($user_id){
        return sprintf('%06d',$user_id);
    }

    public function convertTime($url){
        $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$url);
        parse_str($content, $ytarr);
        $time = $ytarr['length_seconds'];
        if ($time > 0){
            $time_result = '';
            $hours = intval($time / 3600);
            if ($hours > 0)
                $time_result = $time_result.$hours.':';
            $time = $time % 3600;
            $minutes = intval($time / 60);
            $seconds = $time % 60;
            $time_result = $time_result.(($minutes > 9)?$minutes:'0'.$minutes).':';
            $time_result = $time_result.(($seconds > 9)?$seconds:'0'.$seconds);
        }else 
            $time_result = '0:00';        

        return $time_result;
    }

    public function getYoutubeDetail($url){
        $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$url);
        parse_str($content, $ytarr);
        //die(print_r($ytarr));
        return $ytarr;
    }
}
