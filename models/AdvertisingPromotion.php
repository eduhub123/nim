<?php

namespace app\models;

use Yii;

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
            [['target_customers', 'promotion_type'], 'string', 'max' => 128],
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
            'target_customers' => 'Target Customers',
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
}
