<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_ads".
 *
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $ad_id
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property Calendar $calendar
 */
class CalendarAds extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_id', 'ad_id', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['calendar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calendar_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calendar_id' => 'Calendar ID',
            'ad_id' => 'Ad ID',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendar()
    {
        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id']);
    }
}
