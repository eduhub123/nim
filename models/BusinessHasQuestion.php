<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_has_question".
 *
 * @property integer $id
 * @property integer $business_id
 * @property integer $question_id
 * @property string $answer
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property BusinessQuestion $question
 * @property Business $business
 */
class BusinessHasQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_has_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'question_id', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['answer'], 'string', 'max' => 256],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessQuestion::className(), 'targetAttribute' => ['question_id' => 'id']],
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
            'question_id' => 'Question ID',
            'answer' => 'Answer',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(BusinessQuestion::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusiness()
    {
        return $this->hasOne(Business::className(), ['id' => 'business_id']);
    }
}
