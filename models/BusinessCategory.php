<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property BusinessQuestion[] $businessQuestions
 */
class BusinessCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessQuestions()
    {
        return $this->hasMany(BusinessQuestion::className(), ['category_id' => 'id']);
    }
}
