<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;

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

    public function edit($plan, $intensity, $pause, $spent_amount = null, $annual_budget = null){
        $advertising = Advertising::findOne(['client_id'=>Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE]);
        if(!$advertising){
            $advertising = new Advertising;
            $advertising->client_id = Yii::$app->user->identity->current_client;
            $advertising->create_date = GlobalFunctions::createMysqlTimestamp();
        }
        $advertising->plan = $plan;
        $advertising->intensity = intval($intensity);
        $advertising->pause = ($pause == 'on')?GlobalConstants::TRUE:GlobalConstants::FALSE;
        if($spent_amount)
            $advertising->spent_amount = $spent_amount;
        if($annual_budget)
            $advertising->annual_budget = $annual_budget;
        if($advertising->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_ADVERTISING_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_ADVERTISING_ERROR;
        }
        return $response;
    }    
}
