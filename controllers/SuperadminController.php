<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\AuthAssignment;
use app\models\User;
use app\models\UserType;
use app\models\UserAssignment;
use app\models\Business;
use app\models\Service;
use app\models\Ads;

class SuperadminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),             
                'rules' => [
                    [
                        'actions' => ['index', 'employees', 'removeemployee', 'addemployee', 'customers', 'customerdetail', 'updatecustomer',
                                    'services', 'addservice', 'updateservice', 'removeservice',
                                    'adsmanagement', 'addad', 'updatead', 'removead',
                                    'marketingservices'],
                        'allow' => true,
                        'roles' => [GlobalConstants::SUPERADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
        return $this->render('index');
    }

    //========================= EMPLOYEES =========================//
    public function actionEmployees(){
        return $this->render('employees');
    }

    public function actionRemoveemployee(){
        $id = GlobalFunctions::getPost('id');        
        User::remove($id);
        $response['status'] = 'success';
        $response['message'] = GlobalMessages::REMOVE_EMPLOYEE_SUCCESS;                 
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionAddemployee(){
        $email = GlobalFunctions::getPost('email');
        $user_type = GlobalFunctions::getPost('user_type');
        $user = User::findOne(['username'=>strtolower($email), 'active'=>GlobalConstants::TRUE]);
        if($user){
            $response['status'] = 'error';
            $response['message'] = GlobalMessages::ADD_EMPLOYEE_ERROR;  
        }else{
            // Create a new user record
            $user = new User;
            $user->username = strtolower($email);
            $user->setPassword(GlobalFunctions::createPassword());          
            $user->user_type_id = $user_type;

            $user->salt = GlobalFunctions::createSalt();            
            $user->create_date = GlobalFunctions::createMysqlTimestamp();            
            if($user->save()){            
                // Assign a role to the user based on the user type
                $auth_assignment = new AuthAssignment;
                $auth_assignment->item_name = UserType::findOne(['id'=>$user_type])->slug;
                $auth_assignment->user_id = (string)$user->id;
                $auth_assignment->save();
                GlobalFunctions::sendSignupEmail($user);
                $response['status'] = 'success';
                $response['message'] = GlobalMessages::ADD_EMPLOYEE_SUCCESS;
            }else{
                $response['status'] = 'error';
                $response['message'] = GlobalMessages::ADD_EMPLOYEE_ERROR_1;
            }
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= CUSTOMERS =========================//
    public function actionCustomers(){
        return $this->render('customers');
    }

    public function actionCustomerdetail($id=null){
        if($id){
            $user = User::findOne(['id'=>$id, 'user_type_id'=>GlobalConstants::CLIENT_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
            if($user)
                return $this->render('customerdetail', ['modal'=>$user]);
            else
                return $this->redirect('/superadmin/customers');
        }else
            return $this->redirect('/superadmin/customers');
    }

    public function actionUpdatecustomer(){
        $client_id = GlobalFunctions::getPost('client_id');
        $admin = GlobalFunctions::getPost('admin');
        $ad_specialist = GlobalFunctions::getPost('ad_specialist');
        $marketing_director = GlobalFunctions::getPost('marketing_director');
        $copywriter = GlobalFunctions::getPost('copywriter');
        $designer = GlobalFunctions::getPost('designer');
        $general = GlobalFunctions::getPost('general');

        $ua = UserAssignment::findOne(['client_id'=>$client_id, 'active'=>GlobalConstants::TRUE]);
        if(!$ua)
            $ua = new UserAssignment;
        $ua->admin = $admin;
        $ua->ad_specialist = $ad_specialist;
        $ua->marketing_director = $marketing_director;
        $ua->copywriter = $copywriter;
        $ua->designer = $designer;
        $ua->general = $general;
        if($ua->save()){
            $response['status'] = 'success';
            $response['message'] = GlobalMessages::UPDATE_CUSTOMER_SUCCESS;
        }else{
            $response['status'] = 'error';
            $response['message'] = GlobalMessages::UPDATE_CUSTOMER_ERROR;
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= SERVICES =========================//
    public function actionServices(){
        return $this->render('services');
    }

    public function actionAddservice(){
        $name = GlobalFunctions::getPost('name');
        $parent_id = GlobalFunctions::getPost('parent_id');
        $color = GlobalFunctions::getPost('color');
        $description = GlobalFunctions::getPost('description-html');
        if($name){
            $service = new Service;
            $service->name = $name;
            $service->color = $color;
            if($_FILES['icon']['name'])
                $service->icon = GlobalFunctions::upload('icon', 'services');
            $service->description = $description;
            $service->create_date = GlobalFunctions::createMysqlTimestamp();
            if($parent_id)
                $service->parent_id = $parent_id;
            if($service->save()){
                $response['status'] = 'success';
                $response['message'] = GlobalMessages::ADD_SERVICE_SUCCESS;
                $response['url'] = '/superadmin/services';
            }else{
                $response['status'] = 'error';
                $response['message'] = GlobalMessages::ADD_SERVICE_ERROR;
            }
            /**** SEND RESULTS BACK TO FRONTEND ****/
            $result = json_encode($response);
            echo $result;            
        }else
            return $this->render('addservice');   
    }

    public function actionUpdateservice($id = null){
        if($id){
            $service = Service::findOne(['id'=>$id, 'active'=>GlobalConstants::TRUE]);
            if($service){
                $name = GlobalFunctions::getPost('name');
                $parent_id = GlobalFunctions::getPost('parent_id');
                $color = GlobalFunctions::getPost('color');
                $description = GlobalFunctions::getPost('description-html');
                if($name){
                    $service->name = $name;
                    $service->color = $color;
                    if($_FILES['icon']['name'])
                        $service->icon = GlobalFunctions::upload('icon', 'services');
                    $service->description = $description;                    
                    if($parent_id)
                        $service->parent_id = $parent_id;
                    if($service->save()){
                        $response['status'] = 'success';
                        $response['message'] = GlobalMessages::UPDATE_SERVICE_SUCCESS;
                        $response['url'] = '/superadmin/services';
                    }else{
                        $response['status'] = 'error';
                        $response['message'] = GlobalMessages::UPDATE_SERVICE_ERROR;
                    }
                    /**** SEND RESULTS BACK TO FRONTEND ****/
                    $result = json_encode($response);
                    echo $result;            
                }else return $this->render('updateservice', ['modal'=>$service]);
            }
            else
                return $this->redirect('/superadmin/services');
        }else{
            return $this->redirect('/superadmin/services');
        }
    }

    public function actionRemoveservice(){
        $id = GlobalFunctions::getPost('id');        
        Service::remove($id);
        $response['status'] = 'success';
        $response['message'] = GlobalMessages::REMOVE_SERVICE_SUCCESS;                 
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= ADS MANAGEMENT =========================//
    public function actionAdsmanagement(){         
        return $this->render('adsmanagement');
    }

    public function actionAddad(){
        $name = GlobalFunctions::getPost('name');
        $parent_id = GlobalFunctions::getPost('parent_id');
        $color = GlobalFunctions::getPost('color');
        $icon = GlobalFunctions::getPost('icon');
        $description = GlobalFunctions::getPost('description-html');
        if($name){
            $response = Ads::create($name, $parent_id, $color, $icon, $description);
            /**** SEND RESULTS BACK TO FRONTEND ****/
            $result = json_encode($response);
            echo $result;            
        }else
            return $this->render('addad');
    }

    public function actionUpdatead($id = null){
        if($id){
            $ad = Ads::findOne(['id'=>$id, 'active'=>GlobalConstants::TRUE]);
            if($ad){
                $name = GlobalFunctions::getPost('name');
                $parent_id = GlobalFunctions::getPost('parent_id');
                $color = GlobalFunctions::getPost('color');
                $icon = GlobalFunctions::getPost('icon');
                $description = GlobalFunctions::getPost('description-html');
                if($name){
                    $response = Ads::update($id, $name, $parent_id, $color, $icon, $description);
                    /**** SEND RESULTS BACK TO FRONTEND ****/
                    $result = json_encode($response);
                    echo $result;            
                }else return $this->render('updatead', ['modal'=>$ad]);
            }
            else
                return $this->redirect('/superadmin/adsmanagement');
        }else{
            return $this->redirect('/superadmin/adsmanagement');
        }
    }

    public function actionRemovead(){
        $id = GlobalFunctions::getPost('id');        
        $response = Ads::remove($id);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= MARKETING SERVICES =========================//
    public function actionMarketingservices(){
        $service = GlobalFunctions::getPost('service');
        if($service)
            print_r($service);
        else
            return $this->render('marketingservices');
    }
}
