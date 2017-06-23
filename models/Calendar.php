<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\CalendarAds;
use app\models\AdsType;
use app\models\Ads;
use app\models\AdAssignment;
use app\models\Service;
use app\models\ServiceAssignment;


/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $type_id
 * @property integer $type
 * @property string $start_date
 * @property string $end_date
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property User $client
 * @property CalendarAds[] $calendarAds
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'type_id', 'active'], 'integer'],
            [['start_date', 'end_date', 'create_date', 'last_modified'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'type_id' => 'Type ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarAds()
    {
        return $this->hasMany(CalendarAds::className(), ['calendar_id' => 'id']);
    }

    public function create($start_date, $end_date, $type_id, $ads){
        $calendar = new Calendar;
        $calendar->client_id = Yii::$app->user->identity->current_client;
        $calendar->type_id = $type_id;
        $calendar->start_date = date('Y-m-d', strtotime($start_date));
        $calendar->end_date = date('Y-m-d', strtotime($end_date));
        $calendar->create_date = GlobalFunctions::createMysqlTimestamp();
        if($calendar->save())
        {
            foreach ($ads as $inde => $ad) {
                $calendar_ad = new CalendarAds;
                $calendar_ad->calendar_id = $calendar->id;
                $calendar_ad->ad_id = $ad;
                $calendar_ad->create_date = GlobalFunctions::createMysqlTimestamp();
                if(!$calendar_ad->save()){
                    $response['status'] = GlobalConstants::ERROR;
                    $response['message'] = GlobalMessages::ADD_CALENDAR_AD_ERROR;
                    return $response;
                }
            }
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::ADD_CALENDAR_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::ADD_CALENDAR_ERROR;
        }
        return $response;
    }

    public function edit($id, $start_date, $end_date, $type_id, $ads){
        $calendar = Calendar::findOne(['id'=>$id, 'client_id'=>Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE]);
        $calendar->client_id = Yii::$app->user->identity->current_client;
        $calendar->type_id = $type_id;
        $calendar->start_date = date('Y-m-d', strtotime($start_date));
        $calendar->end_date = date('Y-m-d', strtotime($end_date));
        $calendar->create_date = GlobalFunctions::createMysqlTimestamp();
        if($calendar->save())
        {
            foreach ($ads as $inde => $ad) {
                $calendar_ad = new CalendarAds;
                $calendar_ad->calendar_id = $calendar->id;
                $calendar_ad->ad_id = $ad;
                $calendar_ad->create_date = GlobalFunctions::createMysqlTimestamp();
                if(!$calendar_ad->save()){
                    $response['status'] = GlobalConstants::ERROR;
                    $response['message'] = GlobalMessages::ADD_CALENDAR_AD_ERROR;
                    return $response;
                }
            }
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_CALENDAR_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_CALENDAR_ERROR;
        }
        return $response;
    }

    public function remove($id){
        $calendar = Calendar::findOne(['id'=>$id, 'client_id'=>Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE]);
        $calendar->active = GlobalConstants::FALSE;
        if($calendar->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::REMOVE_CALENDAR_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::REMOVE_CALENDAR_ERROR;
        }
        return $response;
    }

    public function getCalendar($client_id, $start_date, $end_date){
        $end_date = date('m/d/Y', strtotime('+1 month', strtotime($end_date)));  
        $total_date = strtotime($end_date) - strtotime($start_date);
        $total_date = $total_date/86400;
        $total_date = intval($total_date);
        $response = array();
        for ($i = 0; $i < $total_date; $i++) {
            $date = date('Y-m-d', strtotime('+'.$i.' day', strtotime($start_date)));
            $response[$i]['date'] = date('m-d-Y', strtotime('+'.$i.' day', strtotime($start_date)));;
            $response[$i]['list'] = array();
            $response[$i]['ads'] = '<div class="ui-ads"><ul class="ads-list">';
            $calendar = Yii::$app->db->createCommand("select id, type_id from calendar where client_id = ".$client_id." and active = ".GlobalConstants::TRUE." and start_date <= '".$date."' and end_date >= '".$date."'")->queryAll();
            if($calendar) 
                foreach ($calendar as $item) {
                    $data['id'] = $item['id'];
                    $data['color'] = AdsType::findOne(['id'=>$item['type_id']])->color;
                    $response[$i]['ads'].= '<li class="'.$data['color'].'" data-id="'.$data['id'].'"></li>';
                    array_push($response[$i]['list'], $data);
                }
            $response[$i]['ads'].= '</ul></div>';
        }        
        return $response;
    }

    public function detail($id){
        $calendar = Calendar::findOne(['id'=>$id, 'active'=>GlobalConstants::TRUE]);
        $response = array();
        if($calendar){
            $response['id'] = $calendar->id;
            $response['type_id'] = $calendar->type_id;
            $response['start_date'] = date('m/d/Y',strtotime($calendar->start_date));
            $response['end_date'] = date('m/d/Y',strtotime($calendar->end_date));
            $response['list'] = array();
            $ads = CalendarAds::findAll(['calendar_id'=>$calendar->id, 'active'=>GlobalConstants::TRUE]);
            foreach ($ads as $ad) {
                $item['id'] = $ad->ad_id;
                if($calendar->type_id == GlobalConstants::AD_TYPE_MARKETING_ACTIVITES){
                    $sa = ServiceAssignment::findOne(['id'=>$ad->ad_id, 'active'=>GlobalConstants::TRUE]);                    
                    if($sa){
                        $service = Service::findOne(['id'=>$sa->service_id, 'active'=>GlobalConstants::TRUE]);
                        if($service)
                            $item['content'] = '<li data-id="'.$ad->ad_id.'" data-type="'.$calendar->type_id.'"><i class="fa fa-globe"></i>'.$service->name.'<span class="btn-remove">×</span></li>';        
                    }
                }else{
                    $check = AdAssignment::findOne(['id'=>$ad->ad_id, 'active'=>GlobalConstants::TRUE]);
                    //$item['test'] = $check->toArra();
                    if($check)
                    {
                        $child = Ads::findOne(['id'=>$check->ad_id, 'active'=>GlobalConstants::TRUE]);
                        if($child){
                            $parent = Ads::findOne(['id'=>$child->parent_id, 'active'=>GlobalConstants::TRUE]);
                            if($parent)
                                $item['content'] = '<li data-id="'.$ad->ad_id.'" data-type="'.$calendar->type_id.'"><i class="fa '.$parent->icon.'"></i>'.$child->name.'<span class="btn-remove">×</span></li>';
                        }
                    }
                }                
                array_push($response['list'], $item);
            }
        }
        return $response;
    }
}
