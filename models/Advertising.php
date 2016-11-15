<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advertising".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $plan
 * @property integer $intensity
 * @property integer $pause
 * @property double $spent_amount
 * @property double $annual_budget
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property User $client
 */
class Advertising extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'intensity', 'pause', 'active'], 'integer'],
            [['spent_amount', 'annual_budget'], 'number'],
            [['create_date', 'last_modified'], 'safe'],
            [['plan'], 'string', 'max' => 128],
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
            'plan' => 'Plan',
            'intensity' => 'Intensity',
            'pause' => 'Pause',
            'spent_amount' => 'Spent Amount',
            'annual_budget' => 'Annual Budget',
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
}
