<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;

/**
 * This is the model class for table "advertising_promotion".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $create_ad
 * @property string $target_customers
 * @property string $promotion_type
 * @property string $discount
 * @property string $discount_type
 * @property string $service_productname
 * @property string $service_productname_2
 * @property string $service_productname_3
 * @property double $average_cost
 * @property double $budget
 * @property string $ultimate_reason
 * @property string $start_date
 * @property string $end_date
 * @property integer $anualy_reocuring
 * @property integer $active
 * @property string $create_date
 * @property string $last_modfied
 *
 * @property User $client
 */
class AdvertisingPromotion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_promotion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'create_ad', 'anualy_reocuring', 'active'], 'integer'],
            [['average_cost', 'budget'], 'number'],
            [['ultimate_reason'], 'string'],
            [['start_date', 'end_date', 'create_date', 'last_modfied'], 'safe'],
            [['promotion_type'], 'string', 'max' => 128],
            [['discount'], 'string', 'max' => 50],
            [['discount_type'], 'string', 'max' => 20],
            [['service_productname', 'service_productname_2', 'service_productname_3'], 'string', 'max' => 256],
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
            'create_ad' => 'Create Ad',
            'promotion_type' => 'Promotion Type',
            'discount' => 'Discount',
            'discount_type' => 'Discount Type',
            'service_productname' => 'Service Productname',
            'service_productname_2' => 'Service Productname 2',
            'service_productname_3' => 'Service Productname 3',
            'average_cost' => 'Average Cost',
            'budget' => 'Budget',
            'ultimate_reason' => 'Ultimate Reason',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'anualy_reocuring' => 'Anualy Reocuring',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modfied' => 'Last Modfied',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }

    public function create($create_ad, $new_customer, $exist_customer, $lost_customer, $promotion_type, $discount, $discount_type, $service_productname, $service_productname_2 = null, $service_productname_3 = null, $average_cost, $budget, $ultimate_reason, $start_date, $end_date, $anualy_reocuring){
        $advertising_promotion = new AdvertisingPromotion;
        $advertising_promotion->client_id = Yii::$app->user->identity->current_client;
        $advertising_promotion->create_ad = $create_ad;
        $advertising_promotion->new_customer = ($new_customer == 'on')?GlobalConstants::TRUE:GlobalConstants::FALSE;
        $advertising_promotion->exist_customer = ($exist_customer == 'on')?GlobalConstants::TRUE:GlobalConstants::FALSE;
        $advertising_promotion->lost_customer = ($lost_customer == 'on')?GlobalConstants::TRUE:GlobalConstants::FALSE;
        $advertising_promotion->promotion_type = $promotion_type;
        $advertising_promotion->discount = $discount;
        $advertising_promotion->discount_type = $discount_type;
        $advertising_promotion->service_productname = $service_productname;
        if($service_productname_2)
            $advertising_promotion->service_productname_2 = $service_productname_2;
        if($service_productname_3)
            $advertising_promotion->service_productname_3 = $service_productname_3;
        $advertising_promotion->average_cost = $average_cost;
        $advertising_promotion->budget = $budget;
        $advertising_promotion->ultimate_reason = $ultimate_reason;
        $advertising_promotion->start_date = $start_date;
        $advertising_promotion->end_date = $end_date;
        $advertising_promotion->anualy_reocuring = $anualy_reocuring;
        $advertising_promotion->create_date = GlobalFunctions::createMysqlTimestamp();        
        if($advertising_promotion->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::ADD_ADVERTISING_PROMOTION_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::ADD_ADVERTISING_PROMOTION_ERROR;
        }            
        return $response;
    }

    public function edit($id, $create_ad, $new_customer, $exist_customer, $lost_customer, $promotion_type, $discount, $discount_type, $service_productname, $service_productname_2 = null, $service_productname_3 = null, $average_cost, $budget, $ultimate_reason, $start_date, $end_date, $anualy_reocuring){
        $advertising_promotion = AdvertisingPromotion::findOne(['id'=>$id, 'client_id'=>Yii::$app->user->identity->current_client]);
        if($advertising_promotion){
            $advertising_promotion->create_ad = $create_ad;
            $advertising_promotion->new_customer = ($new_customer == 'on')?GlobalConstants::TRUE:GlobalConstants::FALSE;
            $advertising_promotion->exist_customer = ($exist_customer == 'on')?GlobalConstants::TRUE:GlobalConstants::FALSE;
            $advertising_promotion->lost_customer = ($lost_customer == 'on')?GlobalConstants::TRUE:GlobalConstants::FALSE;
            $advertising_promotion->promotion_type = $promotion_type;
            $advertising_promotion->discount = $discount;
            $advertising_promotion->discount_type = $discount_type;
            $advertising_promotion->service_productname = $service_productname;
            if($service_productname_2)
                $advertising_promotion->service_productname_2 = $service_productname_2;
            if($service_productname_3)
                $advertising_promotion->service_productname_3 = $service_productname_3;
            $advertising_promotion->average_cost = $average_cost;
            $advertising_promotion->budget = $budget;
            $advertising_promotion->ultimate_reason = $ultimate_reason;
            $advertising_promotion->start_date = $start_date;
            $advertising_promotion->end_date = $end_date;
            $advertising_promotion->anualy_reocuring = $anualy_reocuring;
            $advertising_promotion->active = GlobalConstants::TRUE;
            if($advertising_promotion->save()){
                $response['status'] = GlobalConstants::SUCCESS;
                $response['message'] = GlobalMessages::UPDATE_ADVERTISING_PROMOTION_SUCCESS;
            }else{
                $response['status'] = GlobalConstants::ERROR;
                $response['message'] = GlobalMessages::UPDATE_ADVERTISING_PROMOTION_ERROR;
            }
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_ADVERTISING_PROMOTION_ERROR;
        }
        return $response;   
    }

    public function remove($id){
        $advertising_promotion = AdvertisingPromotion::findOne(['id'=>$id, 'client_id'=>Yii::$app->user->identity->current_client]);
        $advertising_promotion->active = GlobalConstants::FALSE;
        if($advertising_promotion->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::REMOVE_ADVERTISING_PROMOTION_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::REMOVE_ADVERTISING_PROMOTION_ERROR;
        }            
        return $response;
    }
}
