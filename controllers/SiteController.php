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
use app\models\BusinessCategory;
use app\models\BusinessQuestion;
use app\models\BusinessHasQuestion;
use app\models\BusinessOption;
use app\models\BusinessHour;
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

    public function actionUpdateinformation(){
        $salt = GlobalFunctions::getPost('salt');
        $type = GlobalFunctions::getPost('type');
        if(!Yii::$app->user->isGuest && $salt){
            $client = User::findOne(['salt'=>$salt, 'active'=> GlobalConstants::TRUE]);
            if($client)
                return $this->render('updateinformation',['client'=>$client]);
            else return $this->redirect('/');
        }else return $this->redirect('/');
    }

    public function actionUpdatebusiness(){
        $salt = GlobalFunctions::getPost('salt');
        $step = GlobalFunctions::getPost('step');
        $client = User::findOne(['salt'=>$salt, 'user_type_id'=> GlobalConstants::CLIENT_TYPE_ID, 'active'=> GlobalConstants::TRUE]);
        if($client){
            $business = Business::findOne(['user_id'=>$client->id]);
            $client->current_step = $step;
            if($client->save()){
                $response['status'] = GlobalConstants::SUCCESS;
                $response['message'] = '';
            }else{
                $response['status'] = GlobalConstants::ERROR;
                $response['message'] = '';
            }
            switch ($step) {
                case 1: break;
                case 2:
                    $name = GlobalFunctions::getPost('name');
                    $business->name = $name;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 3:
                    $month = GlobalFunctions::getPost('month');
                    $year = GlobalFunctions::getPost('year');
                    $business->month = $month;
                    $business->year = $year;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 4:
                    $locations = GlobalFunctions::getPost('locations');                    
                    $business->locations = $locations;                    
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 5:
                    $list_address = GlobalFunctions::getPost('list_address');
                    BusinessOption::deleteAll(['business_id'=>$business->id, 'tag'=>'locations']);
                    $number = 0;
                    foreach ($list_address as $item) {
                        $number++;
                        $bo = new BusinessOption;
                        $bo->business_id = $business->id;
                        $bo->tag = 'locations';
                        $bo->name = 'Address '.$number;
                        $bo->content = $item['address'];
                        $bo->create_date = GlobalFunctions::createMysqlTimestamp();
                        $bo->save();
                    }
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 6:
                    $list_hours = GlobalFunctions::getPost('list_hours');
                    $always_open = GlobalFunctions::getPost('always_open');
                    if($always_open == GlobalConstants::FALSE)
                        BusinessHour::deleteAll(['business_id'=>$business->id]);
                        foreach ($list_hours as $item) {
                            $bh = new BusinessHour;
                            $bh->business_id = $business->id;
                            $bh->day = $item['day'];
                            $bh->time_open = $item['time_open'];
                            $bh->time_close = $item['time_close'];
                            $bh->status = $item['status'];
                            $bh->create_date = GlobalFunctions::createMysqlTimestamp();
                            $bh->save();
                        }
                    $business->always_open = $always_open;
                    $business->save();
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 7:
                    $slogan = GlobalFunctions::getPost('slogan');                    
                    $business->slogan = $slogan;                    
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 8:
                    $list_usp = GlobalFunctions::getPost('list_usp');
                    BusinessOption::deleteAll(['business_id'=>$business->id, 'tag'=>'usp']);
                    $number = 0;
                    foreach ($list_usp as $item) {
                        $number++;
                        $bo = new BusinessOption;
                        $bo->business_id = $business->id;
                        $bo->tag = 'usp';
                        $bo->name = 'USP '.$number;
                        $bo->content = $item;
                        $bo->create_date = GlobalFunctions::createMysqlTimestamp();
                        $bo->save();
                    }
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 9:
                    $logo = GlobalFunctions::getPost('logo');
                    $banner = GlobalFunctions::getPost('banner');
                    if($logo)
                        $business->logo = $logo;
                    if($banner)
                        $business->banner = $banner;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 10:
                    $budget = GlobalFunctions::getPost('budget');                    
                    $business->budget = $budget;                    
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 11:
                    $primary_services = GlobalFunctions::getPost('primary_services');
                    BusinessOption::deleteAll(['business_id'=>$business->id, 'tag'=>'primary_services']);                    
                    foreach ($primary_services as $primary_service) {                        
                        $bo = new BusinessOption;
                        $bo->business_id = $business->id;
                        $bo->tag = 'primary_services';
                        $bo->name = $primary_service['primary_service'];
                        $bo->content = $primary_service['average_price'];
                        $bo->create_date = GlobalFunctions::createMysqlTimestamp();
                        $bo->save();
                    }
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 12:
                    $in_demand_service = GlobalFunctions::getPost('in_demand_service');
                    $business->in_demand_service = $in_demand_service;                    
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 13:
                    $walk_in = GlobalFunctions::getPost('walk_in');
                    $appointment = GlobalFunctions::getPost('appointment');
                    $business->walk_in = $walk_in;
                    $business->appointment = $appointment;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 14:
                    $list_percent_each_month = GlobalFunctions::getPost('list_percent_each_month');
                    $business_questions = BusinessQuestion::findAll(['category_id'=>GlobalConstants::INDICATE_THE_DEMAND]);
                    foreach ($business_questions as $business_question)
                        BusinessHasQuestion::deleteAll(['business_id'=>$business->id, 'question_id'=>$business_question->id]);
                    foreach ($list_percent_each_month as $item) {
                        $data = new BusinessHasQuestion;
                        $data->business_id = $business->id;
                        $data->question_id = $item['id'];
                        $data->answer = $item['answer'];
                        $data->create_date = GlobalFunctions::createMysqlTimestamp();
                        $data->save();
                    }
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 15:
                    $is_promotion = GlobalFunctions::getPost('is_promotion');
                    $promotion_description = GlobalFunctions::getPost('promotion_description');
                    $business->is_promotion = $is_promotion;
                    $business->promotion_description = $promotion_description;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 16:
                    $list_holidays = GlobalFunctions::getPost('list_holidays');
                    $business_questions = BusinessQuestion::findAll(['category_id'=>GlobalConstants::PROFITABLE_HOLIDAYS]);
                    foreach ($business_questions as $business_question)
                        BusinessHasQuestion::deleteAll(['business_id'=>$business->id, 'question_id'=>$business_question->id]);
                    foreach ($list_holidays as $item) {
                        $data = new BusinessHasQuestion;
                        $data->business_id = $business->id;
                        $data->question_id = $item['id'];
                        $data->answer = $item['answer'];
                        $data->create_date = GlobalFunctions::createMysqlTimestamp();
                        $data->save();
                    }
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 17:
                    $male = GlobalFunctions::getPost('male');
                    $female = GlobalFunctions::getPost('female');
                    $business->male = $male;
                    $business->female = $female;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 18:
                    $target_customers = GlobalFunctions::getPost('target_customers');
                    $business_questions = BusinessQuestion::findAll(['category_id'=>GlobalConstants::TARGET_CUSTOMER]);
                    foreach ($business_questions as $business_question)
                        BusinessHasQuestion::deleteAll(['business_id'=>$business->id, 'question_id'=>$business_question->id]);
                    foreach ($target_customers as $item) {
                        $data = new BusinessHasQuestion;
                        $data->business_id = $business->id;
                        $data->question_id = $item['id'];
                        $data->answer = $item['answer'];
                        $data->create_date = GlobalFunctions::createMysqlTimestamp();
                        $data->save();
                    }
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 19:
                    $customer_relationships = GlobalFunctions::getPost('customer_relationships');
                    $business_questions = BusinessQuestion::findAll(['category_id'=>GlobalConstants::CUSTOMER_RELATIONSHIP]);
                    foreach ($business_questions as $business_question)
                        BusinessHasQuestion::deleteAll(['business_id'=>$business->id, 'question_id'=>$business_question->id]);
                    foreach ($customer_relationships as $item) {
                        $data = new BusinessHasQuestion;
                        $data->business_id = $business->id;
                        $data->question_id = $item['id'];
                        $data->answer = $item['answer'];
                        $data->create_date = GlobalFunctions::createMysqlTimestamp();
                        $data->save();
                    }
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
                case 20:
                    $segment_level = GlobalFunctions::getPost('segment_level');                    
                    $business->segment_level = $segment_level;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                case 21:
                    $purchasing_behavior = GlobalFunctions::getPost('purchasing_behavior');                    
                    $business->purchasing_behavior = $purchasing_behavior;
                    if($business->save()){
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = '';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
                        $response['message'] = '';
                    }
                    break;
                default:
                    $response['status'] = GlobalConstants::SUCCESS;
                    $response['message'] = '';
                    break;
            }
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = '';
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result; 
    }

    public function actionUploadfile(){
        $salt = GlobalFunctions::getPost('salt');
        $client = User::findOne(['salt'=>$salt, 'user_type_id'=> GlobalConstants::CLIENT_TYPE_ID, 'active'=> GlobalConstants::TRUE]);
        if($client){            
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalFunctions::upload('image', $client->id);
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = "You cannot access this function";   
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result; 
    }

    public function actionUpdateavatar(){
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $avatar = GlobalFunctions::upload('image', $user->id);
            $user->avatar = $avatar;
            $user->save();
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = $avatar;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = "You cannot access this function";  
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result; 
    }
}
