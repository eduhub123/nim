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
use app\models\AdAssignment;
use app\models\ServiceAssignment;
use app\models\Ticket;
use app\models\TicketRelationship;
use app\models\ContentVault;
use app\models\Advertising;
use app\models\AdvertisingPromotion;
use app\models\Calendar;
use app\models\AdsType;

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
                                    'adsmanagement', 'addad', 'updatead', 'removead', 'reports',
                                    'marketingservices', 'support', 'ticketdetail', 'sendfeedback', 'openticket', 'closeticket',
                                    'businessprofile', 'contentvault', 'addimage', 'updateimage', 'removecontentvault',
                                    'addvideo', 'updatevideo', 'addarticle', 'updatearticle', 'advertising', 'updatepromotion', 'removepromotion', 'promotiondetail',
                                    'ads', 'adsconfig', 'imagead', 'videoad', 'linkad', 'marketingcalendar', 'adautocomplete',
                                    'addadtocalendar', 'updateadtocalendar', 'removeadtocalendar', 'getcalendar', 'getcalendardetail', 'userprofile', 'updateuser',
                                    'getclientsearch', 'updatecurrentclient'],
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
        $response['status'] = GlobalConstants::SUCCESS;
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
            $response['status'] = GlobalConstants::ERROR;
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
                $response['status'] = GlobalConstants::SUCCESS;
                $response['message'] = GlobalMessages::ADD_EMPLOYEE_SUCCESS;
            }else{
                $response['status'] = GlobalConstants::ERROR;
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
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_CUSTOMER_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
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
                $response['status'] = GlobalConstants::SUCCESS;
                $response['message'] = GlobalMessages::ADD_SERVICE_SUCCESS;
                $response['url'] = '/superadmin/services';
            }else{
                $response['status'] = GlobalConstants::ERROR;
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
                        $response['status'] = GlobalConstants::SUCCESS;
                        $response['message'] = GlobalMessages::UPDATE_SERVICE_SUCCESS;
                        $response['url'] = '/superadmin/services';
                    }else{
                        $response['status'] = GlobalConstants::ERROR;
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
        $response['status'] = GlobalConstants::SUCCESS;
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
                    $response = Ads::edit($id, $name, $parent_id, $color, $icon, $description);
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
        if(Yii::$app->user->identity->current_client){
            $services = GlobalFunctions::getPost('service');
            if($services){
                ServiceAssignment::deleteAll(['client_id'=>Yii::$app->user->identity->current_client]);
                foreach ($services as $service) {
                    $sa = new ServiceAssignment;
                    $sa->client_id = Yii::$app->user->identity->current_client;
                    $sa->service_id = $service;
                    $sa->create_date = GlobalFunctions::createMysqlTimestamp();
                    $sa->save();
                }
            }
            return $this->render('marketingservices');
        }else return $this->redirect('/');
    }

    //========================= SUPPORT =========================//
    public function actionSupport(){
        if(Yii::$app->user->identity->current_client){
            $search = GlobalFunctions::getPost('search');
            $start_item = GlobalFunctions::getPost('start_item');

            $total_ticket = count(Ticket::findAll(['client_id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE]));        
            if($start_item){
                $response['data'] = array();
                $tickets = Ticket::find()->where(['client_id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE])
                            ->andWhere(['like', 'name', $search ])->orderBy(['id'=>SORT_DESC])
                            ->limit(GlobalConstants::LIMIT_ROW)->offset($start_item)->all();            
                if($tickets) foreach ($tickets as $ticket) {
                    $item['id'] = $ticket->id;
                    $item['name'] = $ticket->name;
                    $item['date'] = Date('d/m/Y', strtotime($ticket->create_date)).' at '.Date('g:i A', strtotime($ticket->create_date));
                    $item['status'] = $ticket->status;
                    $item['response'] = $ticket->response;
                    array_push($response['data'], $item);
                }
                $response['loadmore_status'] = (($total_ticket - $start_item) > GlobalConstants::LIMIT_ROW)?GlobalConstants::TRUE:GlobalConstants::FALSE;
                /**** SEND RESULTS BACK TO FRONTEND ****/
                $result = json_encode($response);
                echo $result;
            }else
                return $this->render('support', ['total_ticket'=>$total_ticket]);
        }else return $this->redirect('/');
    }

    public function actionTicketdetail($id = null){
        if(Yii::$app->user->identity->current_client){
            if($id){
                $id = GlobalFunctions::getPost('id');
                $ticket = Ticket::findOne(['id'=>$id, 'active'=>GlobalConstants::TRUE]);
                if($ticket)
                    return $this->render('ticketdetail', ['modal'=>$ticket]);
                else
                    return $this->redirect('/superadmin/support');    
            }else{
                return $this->redirect('/superadmin/support');
            }
        }else return $this->redirect('/');
    }

    public function actionSendfeedback(){
        $id = GlobalFunctions::getPost('id');
        $comment = GlobalFunctions::getPost('comment-html');
        $response = TicketRelationship::create($id, Yii::$app->user->identity->getId(), $comment);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }    

    public function actionCloseticket(){
        $id = GlobalFunctions::getPost('id');
        $response = Ticket::close($id);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionOpenticket(){
        $id = GlobalFunctions::getPost('id');
        $response = Ticket::open($id);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= BUSINESS PROFILE =========================//
    public function actionBusinessprofile(){
        if(Yii::$app->user->identity->current_client) return $this->render('businessprofile');
        else return $this->redirect('/');
    }

    //========================= CONTENT VAULT =========================//
    public function actionContentvault(){
        if(Yii::$app->user->identity->current_client) return $this->render('contentvault');
        else return $this->redirect('/');
    }

    public function actionAddimage(){
        $name = GlobalFunctions::getPost('name');
        $url = GlobalFunctions::upload('url', Yii::$app->user->identity->current_client);
        $response = ContentVault::create(Yii::$app->user->identity->current_client, $name, $name, $url, GlobalConstants::IMAGE_TYPE); 
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionAddvideo(){
        $url = GlobalFunctions::getPost('url');
        $detail = GlobalFunctions::getYoutubeDetail($url);
        $response = ContentVault::create(Yii::$app->user->identity->current_client, $detail['title'], '', $url, GlobalConstants::VIDEO_TYPE); 
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionAddarticle(){
        $name = GlobalFunctions::getPost('name');
        $description = GlobalFunctions::getPost('description-html');        
        $response = ContentVault::create(Yii::$app->user->identity->current_client, $name, $description, 'none', GlobalConstants::ARTICLE_TYPE); 
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionUpdateimage(){
        $id = GlobalFunctions::getPost('id');
        $name = GlobalFunctions::getPost('name');
        $response = ContentVault::editImage($id, $name); 
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    public function actionUpdatearticle(){
        $id = GlobalFunctions::getPost('id');
        $name = GlobalFunctions::getPost('name');
        $description = GlobalFunctions::getPost('description-html');    
        $response = ContentVault::edit($id, Yii::$app->user->identity->current_client, $name, $description, 'none', GlobalConstants::ARTICLE_TYPE); 
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    public function actionRemovecontentvault(){
        $id = GlobalFunctions::getPost('id');
        $response = ContentVault::remove($id);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= ADVERTISING =========================//
    public function actionAdvertising(){
        if(Yii::$app->user->identity->current_client){
            $plan = GlobalFunctions::getPost('plan');
            $intensity = GlobalFunctions::getPost('intensity');
            $pause = GlobalFunctions::getPost('pause');
            $spent_amount = GlobalFunctions::getPost('spent_amount');
            $annual_budget = GlobalFunctions::getPost('annual_budget');
            if($plan){
                $response = Advertising::edit($plan, $intensity, $pause, $spent_amount, $annual_budget);
                /**** SEND RESULTS BACK TO FRONTEND ****/
                $result = json_encode($response);
                echo $result;           
            }else 
                return $this->render('advertising');
        }
        else 
            return $this->redirect('/');
    }

    public function actionPromotiondetail(){
        if(Yii::$app->user->identity->current_client){
            $id = GlobalFunctions::getPost('id');
            if($id){                
                $promotion = AdvertisingPromotion::find()->where(['id'=>$id])->andWhere('active <> '.GlobalConstants::FALSE)->one();
                if($promotion)
                    return $this->render('promotiondetail', ['modal'=>$promotion]);
                else
                    return $this->redirect('/superadmin/advertising');    
            }else{
                return $this->redirect('/superadmin/advertising');
            }
        }else return $this->redirect('/');
    }

    public function actionUpdatepromotion(){
        $id = GlobalFunctions::getPost('id');
        $create_ad = GlobalFunctions::getPost('create_ad');
        $new_customer = GlobalFunctions::getPost('new_customer');
        $exist_customer = GlobalFunctions::getPost('exist_customer');
        $lost_customer = GlobalFunctions::getPost('lost_customer');
        $promotion_type = GlobalFunctions::getPost('promotion_type');
        $discount = GlobalFunctions::getPost('discount');
        $discount_type = GlobalFunctions::getPost('discount_type');
        $service_productname = GlobalFunctions::getPost('service_productname');
        $service_productname_2 = GlobalFunctions::getPost('service_productname_2');
        $service_productname_3 = GlobalFunctions::getPost('service_productname_3');
        $average_cost = GlobalFunctions::getPost('average_cost');
        $budget = GlobalFunctions::getPost('budget');
        $ultimate_reason = GlobalFunctions::getPost('ultimate_reason');
        $start_date = GlobalFunctions::getPost('start_date');
        $end_date = GlobalFunctions::getPost('end_date');
        $anualy_reocuring = GlobalFunctions::getPost('anualy_reocuring');
        $response = AdvertisingPromotion::edit($id, $create_ad, $new_customer, $exist_customer, $lost_customer, $promotion_type, $discount, $discount_type, $service_productname, $service_productname_2, $service_productname_3, $average_cost, $budget, $ultimate_reason, $start_date, $end_date, $anualy_reocuring);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionRemovepromotion(){
        $id = GlobalFunctions::getPost('id');
        $response = AdvertisingPromotion::remove($id);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= ADS =========================//
    public function actionAds(){
        if(Yii::$app->user->identity->current_client) return $this->render('ads');
        else return $this->redirect('/');
    }

    public function actionAdsconfig(){
        if(Yii::$app->user->identity->current_client){
            $ads = GlobalFunctions::getPost('ad');
            if($ads){
                AdAssignment::deleteAll(['client_id'=>Yii::$app->user->identity->current_client]);
                foreach ($ads as $ad) {
                    $sa = new AdAssignment;
                    $sa->client_id = Yii::$app->user->identity->current_client;
                    $sa->ad_id = $ad;
                    $sa->create_date = GlobalFunctions::createMysqlTimestamp();
                    $sa->save();
                }
            }
            return $this->render('adsconfig');
        }
        else return $this->redirect('/');   
    }

    public function actionImagead(){
        $id = GlobalFunctions::getPost('id');
        $url = GlobalFunctions::getPost('url');
        //die($_FILES['image']['name']);
        $response = AdAssignment::image($id, $url);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionVideoad(){
        $id = GlobalFunctions::getPost('id');
        $url = GlobalFunctions::getPost('url');
        $response = AdAssignment::video($id, $url);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionLinkad(){
        $id = GlobalFunctions::getPost('id');
        $link = GlobalFunctions::getPost('link');
        $response = AdAssignment::linkAd($id, $link);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    //========================= MARKETING CALENDAR =========================//

    public function actionMarketingcalendar(){
        if(Yii::$app->user->identity->current_client) return $this->render('marketingcalendar');
        else return $this->redirect('/');
    }

    public function actionAdautocomplete(){
        $id = GlobalFunctions::getPost('id');
        $key = GlobalFunctions::getPost('key');
        $response = array();
        if($id == GlobalConstants::AD_TYPE_MARKETING_ACTIVITES){
            $service_assigns = ServiceAssignment::find()->where(['client_id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE])->orderBy(['service_id'=>SORT_DESC])->all();
            foreach ($service_assigns as $index => $service_assign) {
                $service = Service::find()->where(['id'=>$service_assign->service_id, 'active'=>GlobalConstants::TRUE])->andWhere(['like', 'name', $key ])->one();
                if($service){
                    $item = array();
                    $item['id'] = $service_assign->id;
                    $item['name'] = $service->name;
                    $item['icon'] = 'fa-globe';
                    array_push($response, $item);
                }
            }
        }else{
            $ad_assignments = AdAssignment::find()->where(['client_id'=> Yii::$app->user->identity->current_client,'active'=>GlobalConstants::TRUE])->orderBy(['ad_id'=>SORT_DESC])->all();
            foreach ($ad_assignments as $index => $ad_assignment) {
                $ad = Ads::find()->where(['id'=>$ad_assignment->ad_id, 'active'=>GlobalConstants::TRUE])->andWhere(['like', 'name', $key ])->andWhere(['<>', 'parent_id', 0])->one();
                if($ad){
                    $item = array();
                    $item['id'] = $ad_assignment->id;
                    $item['name'] = $ad->name;
                    $item['icon'] = Ads::findOne(['id'=>$ad->parent_id])->icon;
                    array_push($response, $item);
                }
            }
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionGetcalendar(){
        $start_date = GlobalFunctions::getPost('start_date');
        $end_date = GlobalFunctions::getPost('end_date');
        $client_id = Yii::$app->user->identity->current_client;
        $response = Calendar::getCalendar($client_id, $start_date, $end_date);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    public function actionGetcalendardetail(){
        $id = GlobalFunctions::getPost('id');
        $response = Calendar::detail($id);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    public function actionAddadtocalendar(){
        $start_date = GlobalFunctions::getPost('start_date');
        $end_date = GlobalFunctions::getPost('end_date');
        $type_id = GlobalFunctions::getPost('type_id');
        $ads = GlobalFunctions::getPost('ads');
        $response = Calendar::create($start_date, $end_date, $type_id, $ads);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    public function actionUpdateadtocalendar(){
        $id = GlobalFunctions::getPost('id');
        $start_date = GlobalFunctions::getPost('start_date');
        $end_date = GlobalFunctions::getPost('end_date');
        $type_id = GlobalFunctions::getPost('type_id');
        $ads = GlobalFunctions::getPost('ads');
        $response = Calendar::edit($id, $start_date, $end_date, $type_id, $ads);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    public function actionRemoveadtocalendar(){
        $id = GlobalFunctions::getPost('id');
        $start_date = GlobalFunctions::getPost('start_date');
        $end_date = GlobalFunctions::getPost('end_date');
        $type_id = GlobalFunctions::getPost('type_id');
        $ads = GlobalFunctions::getPost('ads');
        $response = Calendar::remove($id);
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    //========================= REPORT =========================//
    public function actionReports(){
        if(Yii::$app->user->identity->current_client) return $this->render('reports');
        else return $this->redirect('/');
    }

    //========================= USER PROFILE =========================//
    public function actionUserprofile(){                
        return $this->render('userprofile');
    }

    public function actionUpdateuser(){
        $firstname = GlobalFunctions::getPost('firstname');
        $lastname = GlobalFunctions::getPost('lastname');
        $industry = GlobalFunctions::getPost('industry');
        $phone = GlobalFunctions::getPost('phone');
        $address = GlobalFunctions::getPost('address');
        $birthday = GlobalFunctions::getPost('birthday');
        $is_change = GlobalFunctions::getPost('is-change');
        $old_password = GlobalFunctions::getPost('old-password');
        $new_password = GlobalFunctions::getPost('new-password');
        if($is_change == 'on'){
            if(User::validatePassword($old_password, Yii::$app->user->identity->password))
                $response = User::edit($firstname, $lastname, $industry, $phone, $address, $birthday, $is_change, $new_password);
            else{
                $response['status'] = GlobalConstants::ERROR;
                $response['message'] = GlobalMessages::INVALID_USER_PASSWORD;
            }    
        }else
            $response = User::edit($firstname, $lastname, $industry, $phone, $address, $birthday, $is_change, $new_password);

        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;   
    }

    public function actionGetclientsearch(){
        $search = GlobalFunctions::getPost('search');
        $response = array();
        if(!$search)
            $clients = User::findAll(['user_type_id'=>GlobalConstants::CLIENT_TYPE_ID, 'active'=>GlobalConstants::TRUE]);
        else
            $clients = User::find()->where(['user_type_id'=>GlobalConstants::CLIENT_TYPE_ID, 'active'=>GlobalConstants::TRUE])->andWhere(['or',['like', 'firstname', $search], ['like', 'lastname', $search], ['like', 'id', $search]])->all();
        foreach ($clients as $client) {
            $item = array();
            $item['id'] = GlobalFunctions::getUserID($client->id);
            $item['name'] = $client->firstname.' '.$client->lastname;
            $item['salt'] = $client->salt;
            $item['active'] = GlobalConstants::FALSE;
            if($client->id == Yii::$app->user->identity->current_client)
                $item['active'] = GlobalConstants::TRUE;
            array_push($response, $item);
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }

    public function actionUpdatecurrentclient(){
        $salt = GlobalFunctions::getPost('salt');
        $check = User::findOne(['salt'=>$salt, 'active'=> GlobalConstants::TRUE]);
        if($check){
            $user = Yii::$app->user->identity;
            $user->current_client = $check->id;
            $user->save();
            $response['status'] = GlobalConstants::SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = 'User not exist in system';
        }
        /**** SEND RESULTS BACK TO FRONTEND ****/
        $result = json_encode($response);
        echo $result;
    }


}
