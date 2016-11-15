<?php

namespace app\models;

use Yii;

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
            [['client_id', 'type_id', 'type', 'active'], 'integer'],
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
            'type' => 'Type',
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
}
