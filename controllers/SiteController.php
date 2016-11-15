<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\User;
use app\models\UserType;
use app\models\Business;
use app\models\AuthAssignment;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(){
        if (!Yii::$app->user->isGuest) {
            echo Yii::$app->user->can(GlobalConstants::CLIENT_PERMISSIONS);
            if (Yii::$app->user->can(GlobalConstants::SUPERADMIN_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::SUPERADMIN);
            else if (Yii::$app->user->can(GlobalConstants::ADMIN_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::ADMIN);
            else if (Yii::$app->user->can(GlobalConstants::ADSPECIALIST_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::ADSPECIALIST);
            else if (Yii::$app->user->can(GlobalConstants::COPYWRITER_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::COPYWRITER);
            else if (Yii::$app->user->can(GlobalConstants::DESIGNER_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::DESIGNER);
            else if (Yii::$app->user->can(GlobalConstants::GENERAL_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::GENERAL);
            else if (Yii::$app->user->can(GlobalConstants::MARKETINGDIRECTOR_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::MARKETINGDIRECTOR);
            else if (Yii::$app->user->can(GlobalConstants::SALEPERSON_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::SALEPERSON);
            else
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::CLIENT);
        } else {
            return $this->redirect(Yii::getAlias('@web').'/site/login');
        }
    }

    /**
     * 1. Login
     */
    public function actionLogin(){
        $username = GlobalFunctions::getPost('username');
        $password = GlobalFunctions::getPost('password');        
        if ($username) {
            $user = User::findOne(['username'=>$username, 'active'=>GlobalConstants::TRUE]);            
            if($user){
                $check = User::validatePassword($password, $user->password);
                if($check){
                    Yii::$app->user->login($user, 3600*24*30);
                    $response['status'] = 'success';
                    User::setCurrentClient();
                    if (Yii::$app->user->can(GlobalConstants::SUPERADMIN_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::SUPERADMIN;
                    else if (Yii::$app->user->can(GlobalConstants::ADMIN_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::ADMIN;
                    else if (Yii::$app->user->can(GlobalConstants::ADSPECIALIST_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::ADSPECIALIST;
                    else if (Yii::$app->user->can(GlobalConstants::COPYWRITER_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::COPYWRITER;
                    else if (Yii::$app->user->can(GlobalConstants::DESIGNER_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::DESIGNER;
                    else if (Yii::$app->user->can(GlobalConstants::GENERAL_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::GENERAL;
                    else if (Yii::$app->user->can(GlobalConstants::MARKETINGDIRECTOR_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::MARKETINGDIRECTOR;
                    else if (Yii::$app->user->can(GlobalConstants::SALEPERSON_PERMISSIONS))
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::SALEPERSON;
                    else
                        $response['url'] = Yii::getAlias('@web').'/'.GlobalConstants::CLIENT;
                }else{
                    $response['status'] = 'error';
                    $response['message'] = GlobalMessages::LOGIN_ERROR_1;    
                }
            }
            else{
                $response['status'] = 'error';
                $response['message'] = GlobalMessages::LOGIN_ERROR_2;
            }            
            /**** SEND RESULTS BACK TO FRONTEND ****/
            $result = json_encode($response);
            echo $result;
        } else {
            if(!Yii::$app->user->isGuest){
                if (Yii::$app->user->can(GlobalConstants::SUPERADMIN_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::SUPERADMIN);
                else if (Yii::$app->user->can(GlobalConstants::ADMIN_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::ADMIN);
                else if (Yii::$app->user->can(GlobalConstants::ADSPECIALIST_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::ADSPECIALIST);
                else if (Yii::$app->user->can(GlobalConstants::COPYWRITER_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::COPYWRITER);
                else if (Yii::$app->user->can(GlobalConstants::DESIGNER_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::DESIGNER);
                else if (Yii::$app->user->can(GlobalConstants::GENERAL_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::GENERAL);
                else if (Yii::$app->user->can(GlobalConstants::MARKETINGDIRECTOR_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::MARKETINGDIRECTOR);
                else if (Yii::$app->user->can(GlobalConstants::SALEPERSON_PERMISSIONS))
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::SALEPERSON);
                else
                    return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::CLIENT);
            }             
            return $this->render('login');
        }
    }

    /**
     * Logout
     */
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect(Yii::getAlias('@web').'/site/login');
    }

    /*
    *   2.1 Signup for Client
    */
    public function actionSignupclient(){
        $name = GlobalFunctions::getPost('name');
        $website = GlobalFunctions::getPost('website');
        $email = GlobalFunctions::getPost('email');
        $phone = GlobalFunctions::getPost('phone');
        $password = GlobalFunctions::getPost('password');
        $client = User::findOne(['username'=>strtolower($email), 'active'=>GlobalConstants::TRUE]);        
        if (!$client) {
            // Create a new user record
            $user = new User;
            $user->username = strtolower($email);
            $user->setPassword($password);            
            $user->user_type_id = GlobalConstants::CLIENT_TYPE_ID;
                        
            $user->phone = $phone;
            $user->salt = GlobalFunctions::createSalt();
            $user->active = GlobalConstants::TRUE;           
            $user->create_date = GlobalFunctions::createMysqlTimestamp();            
            if($user->save()){
                $business = new Business;
                $business->user_id = $user->id;
                $business->name = $name;
                $business->website = $website;
                $user->create_date = GlobalFunctions::createMysqlTimestamp();
                $business->save();

                // Assign a role to the user based on the user type
                $auth_assignment = new AuthAssignment;
                $auth_assignment->item_name = GlobalConstants::CLIENT;
                $auth_assignment->user_id = (string)$user->id;
                $auth_assignment->save();
                $response['status'] = 'success';
            }else{
                $response['status'] = 'error';
                $response['message'] = GlobalMessages::SIGNUP_CLIENT_ERROR_1;
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = GlobalMessages::SIGNUP_CLIENT_ERROR;            
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    /*
    *   2.2 Signup for Employee
    */
    public function actionSignupemployee($salt = null){
        if($salt == null)
            $salt = GlobalFunctions::getPost('salt');        
        $firstname = GlobalFunctions::getPost('firstname');
        $lastname = GlobalFunctions::getPost('lastname');
        $password = GlobalFunctions::getPost('password');
        $birthday = GlobalFunctions::getPost('birthday');        
        if(!Yii::$app->user->isGuest){
            if (Yii::$app->user->can(GlobalConstants::SUPERADMIN_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::SUPERADMIN);
            else if (Yii::$app->user->can(GlobalConstants::ADMIN_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::ADMIN);
            else if (Yii::$app->user->can(GlobalConstants::ADSPECIALIST_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::ADSPECIALIST);
            else if (Yii::$app->user->can(GlobalConstants::COPYWRITER_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::COPYWRITER);
            else if (Yii::$app->user->can(GlobalConstants::DESIGNER_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::DESIGNER);
            else if (Yii::$app->user->can(GlobalConstants::GENERAL_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::GENERAL);
            else if (Yii::$app->user->can(GlobalConstants::MARKETINGDIRECTOR_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::MARKETINGDIRECTOR);
            else if (Yii::$app->user->can(GlobalConstants::SALEPERSON_PERMISSIONS))
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::SALEPERSON);
            else
                return $this->redirect(Yii::getAlias('@web').'/'.GlobalConstants::CLIENT);
        }else{
            $user = User::findBySalt($salt);
            if ($user) {
                if($password){                
                    $user->firstname = $firstname;
                    $user->lastname = $lastname;
                    $user->setPassword($password);
                    $user->salt = GlobalFunctions::createSalt();
                    $user->birthday = date('Y-m-d',strtotime($birthday));                
                    $user->active = GlobalConstants::TRUE;
                    if ($user->save()) {
                        $response['status'] = 'success';
                        $response['message'] = GlobalMessages::SIGNUP_EMPLOYEE_SUCCESS;
                        $response['url'] = Yii::getAlias('@web').'/site/login';
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = GlobalMessages::SIGNUP_EMPLOYEE_ERROR;
                    }
                    /**** SEND RESULTS BACK TO FRONTEND ****/
                    $result = json_encode($response);
                    echo $result;
                }else
                    return $this->render('signupemployee', ['email'=>$user->username, 'salt'=>$salt, 'message'=>null]);
            }else{
                return $this->render('signupemployee',['message'=>GlobalMessages::PASSWORD_RECOVERY_ERROR]);
            }
        }  
    }

    /*
    *   3. Password Recovery/Setup
    */
    public function actionPasswordrecovery($salt = null){
        $password = GlobalFunctions::getPost('password');        
        $user = User::findBySalt($salt);        
        if ($user) {
            if($password){
                $user->setPassword($password);
                $user->salt = GlobalFunctions::createSalt();
                if($user->save()){
                    $response['status'] = 'success';
                    $response['message'] = GlobalMessages::PASSWORD_RECOVERY_SUCCESS;
                }else{
                    $response['status'] = 'error';
                    $response['message'] = GlobalMessages::PASSWORD_RECOVERY_ERROR_1;
                }
                /**** SEND RESULTS BACK TO FRONTEND ****/
                $result = json_encode($response);
                echo $result;
            }else
                return $this->render('passwordrecovery');
        } else {            
            return $this->redirect('passwordrecovery',['message'=>GlobalMessages::PASSWORD_RECOVERY_ERROR]);
        }        
    }

    public function actionError(){
        return $this->render('error');
    }
}
