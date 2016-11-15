<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_vault".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $width_height
 * @property string $type
 * @property string $size
 * @property integer $is_raw
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property User $client
 */
class ContentVault extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_vault';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'name', 'url', 'create_date'], 'required'],
            [['client_id', 'is_raw', 'active'], 'integer'],
            [['url', 'description'], 'string'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 512],
            [['width_height', 'size'], 'string', 'max' => 20],
            [['type'], 'string', 'max' => 10],
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
            'name' => 'Name',
            'url' => 'Url',
            'description' => 'Description',
            'width_height' => 'Width Height',
            'type' => 'Type',
            'size' => 'Size',
            'is_raw' => 'Is Raw',
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
