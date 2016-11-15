<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $website
 * @property string $established
 * @property integer $locations
 * @property string $address
 * @property string $hour_open
 * @property string $hour_close
 * @property string $slogan
 * @property string $usps
 * @property string $logo
 * @property string $banner
 * @property string $budget
 * @property string $in_demand_service
 * @property double $walk_in
 * @property double $appointment
 * @property integer $is_promotion
 * @property string $terms
 * @property string $discount
 * @property string $target_clients
 * @property double $male
 * @property double $female
 * @property double $age10_15
 * @property double $age16_30
 * @property double $age31_45
 * @property double $single
 * @property double $married
 * @property integer $high_customer
 * @property integer $medium_customer
 * @property integer $low_customer
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property BusinessBudget[] $businessBudgets
 * @property BusinessHasQuestion[] $businessHasQuestions
 * @property BusinessOption[] $businessOptions
 */
class Business extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'locations', 'is_promotion', 'high_customer', 'medium_customer', 'low_customer', 'active'], 'integer'],
            [['established', 'create_date', 'last_modified'], 'safe'],
            [['usps', 'logo', 'banner', 'terms', 'target_clients'], 'string'],
            [['walk_in', 'appointment', 'male', 'female', 'age10_15', 'age16_30', 'age31_45', 'single', 'married'], 'number'],
            [['name', 'website', 'slogan', 'in_demand_service'], 'string', 'max' => 256],
            [['address'], 'string', 'max' => 512],
            [['hour_open', 'hour_close', 'budget'], 'string', 'max' => 50],
            [['discount'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'website' => 'Website',
            'established' => 'Established',
            'locations' => 'Locations',
            'address' => 'Address',
            'hour_open' => 'Hour Open',
            'hour_close' => 'Hour Close',
            'slogan' => 'Slogan',
            'usps' => 'Usps',
            'logo' => 'Logo',
            'banner' => 'Banner',
            'budget' => 'Budget',
            'in_demand_service' => 'In Demand Service',
            'walk_in' => 'Walk In',
            'appointment' => 'Appointment',
            'is_promotion' => 'Is Promotion',
            'terms' => 'Terms',
            'discount' => 'Discount',
            'target_clients' => 'Target Clients',
            'male' => 'Male',
            'female' => 'Female',
            'age10_15' => 'Age10 15',
            'age16_30' => 'Age16 30',
            'age31_45' => 'Age31 45',
            'single' => 'Single',
            'married' => 'Married',
            'high_customer' => 'High Customer',
            'medium_customer' => 'Medium Customer',
            'low_customer' => 'Low Customer',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessBudgets()
    {
        return $this->hasMany(BusinessBudget::className(), ['business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessHasQuestions()
    {
        return $this->hasMany(BusinessHasQuestion::className(), ['business_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessOptions()
    {
        return $this->hasMany(BusinessOption::className(), ['business_id' => 'id']);
    }
}
