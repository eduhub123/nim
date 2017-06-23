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
 * @property integer $month
 * @property integer $year
 * @property integer $locations
 * @property string $slogan
 * @property string $logo
 * @property string $banner
 * @property string $budget
 * @property string $in_demand_service
 * @property double $walk_in
 * @property double $appointment
 * @property integer $is_promotion
 * @property string $promotion_description
 * @property string $discount
 * @property integer $segment level
 * @property double $male
 * @property double $female
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
            [['user_id', 'month', 'year', 'locations', 'is_promotion', 'segment_level', 'active'], 'integer'],
            [['logo', 'banner', 'promotion_description'], 'string'],
            [['walk_in', 'appointment', 'male', 'female'], 'number'],
            [['create_date', 'last_modified'], 'safe'],
            [['name', 'website', 'slogan', 'in_demand_service'], 'string', 'max' => 256],
            [['budget'], 'string', 'max' => 50],        
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
            'month' => 'Month',
            'year' => 'Year',
            'locations' => 'Locations',
            'slogan' => 'Slogan',
            'logo' => 'Logo',
            'banner' => 'Banner',
            'budget' => 'Budget',
            'in_demand_service' => 'In Demand Service',
            'walk_in' => 'Walk In',
            'appointment' => 'Appointment',
            'is_promotion' => 'Is Promotion',
            'promotion_description' => 'Promotion Description',            
            'segment_level' => 'Segment Level',
            'male' => 'Male',
            'female' => 'Female',
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
