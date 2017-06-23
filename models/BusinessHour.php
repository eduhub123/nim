<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_hour".
 *
 * @property integer $id
 * @property integer $business_id
 * @property string $day
 * @property string $time_open
 * @property string $time_close
 * @property integer $status
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 */
class BusinessHour extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_hour';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'status', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['day', 'time_open', 'time_close'], 'string', 'max' => 20],
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
            'day' => 'Day',
            'time_open' => 'Time Open',
            'time_close' => 'Time Close',
            'status' => 'Status',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }
}
