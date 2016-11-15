<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_change_id
 * @property string $text
 * @property integer $status
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property User $userChange
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_change_id', 'status', 'active'], 'integer'],
            [['text'], 'string'],
            [['create_date', 'last_modified'], 'safe'],
            [['user_change_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_change_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_change_id' => 'User Change ID',
            'text' => 'Text',
            'status' => 'Status',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserChange()
    {
        return $this->hasOne(User::className(), ['id' => 'user_change_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
