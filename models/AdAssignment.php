<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ad_assignment".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property integer $client_id
 * @property string $file_url
 * @property string $type
 * @property string $link
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property Ads $ad
 * @property User $client
 */
class AdAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id', 'client_id', 'active'], 'integer'],
            [['file_url', 'link'], 'string'],
            [['create_date', 'last_modified'], 'safe'],
            [['type'], 'string', 'max' => 20],
            [['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::className(), 'targetAttribute' => ['ad_id' => 'id']],
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
            'ad_id' => 'Ad ID',
            'client_id' => 'Client ID',
            'file_url' => 'File Url',
            'type' => 'Type',
            'link' => 'Link',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ads::className(), ['id' => 'ad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }
}
