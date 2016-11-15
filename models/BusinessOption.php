<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_option".
 *
 * @property integer $id
 * @property integer $business_id
 * @property string $name
 * @property string $content
 * @property string $tag
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property Business $business
 */
class BusinessOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'active'], 'integer'],
            [['content'], 'string'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['tag'], 'string', 'max' => 50],
            [['business_id'], 'exist', 'skipOnError' => true, 'targetClass' => Business::className(), 'targetAttribute' => ['business_id' => 'id']],
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
            'name' => 'Name',
            'content' => 'Content',
            'tag' => 'Tag',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(Business::className(), ['id' => 'business_id']);
    }
}
