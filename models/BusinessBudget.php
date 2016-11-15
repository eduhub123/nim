<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_budget".
 *
 * @property integer $id
 * @property integer $business_id
 * @property double $spent_amount
 * @property double $manual_budget
 * @property integer $year
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property Business $business
 */
class BusinessBudget extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_budget';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'year', 'active'], 'integer'],
            [['spent_amount', 'manual_budget'], 'number'],
            [['create_date', 'last_modified'], 'safe'],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Business::className(), 'targetAttribute' => ['business_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'business_id' => 'Business ID',
            'spent_amount' => 'Spent Amount',
            'manual_budget' => 'Manual Budget',
            'year' => 'Year',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(Business::className(), ['id' => 'business_id']);
    }
}
