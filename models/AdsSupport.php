<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads_support".
 *
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property User $to
 * @property User $from
 */
class AdsSupport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_support';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['to_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_id' => 'id']],
            [['from_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_id']);
    }
}
