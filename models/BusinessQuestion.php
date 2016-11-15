<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_question".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property BusinessHasQuestion[] $businessHasQuestions
 * @property BusinessCategory $category
 */
class BusinessQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 512],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessHasQuestions()
    {
        return $this->hasMany(BusinessHasQuestion::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BusinessCategory::className(), ['id' => 'category_id']);
    }
}
