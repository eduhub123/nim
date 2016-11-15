<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_assignment".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $admin
 * @property integer $ad_specialist
 * @property integer $marketing_director
 * @property integer $copywriter
 * @property integer $designer
 * @property integer $general
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 */
class UserAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'admin', 'ad_specialist', 'marketing_director', 'copywriter', 'designer', 'general', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
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
            'admin' => 'Admin',
            'ad_specialist' => 'Ad Specialist',
            'marketing_director' => 'Marketing Director',
            'copywriter' => 'Copywriter',
            'designer' => 'Designer',
            'general' => 'General',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }
}
