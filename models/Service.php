<?php

namespace app\models;
use app\assets\GlobalConstants;
use Yii;

/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $parent_id
 * @property string $icon
 * @property string $color
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property ServiceAssignment[] $serviceAssignments
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'icon'], 'string'],
            [['parent_id', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['color'], 'string', 'max' => 10],
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
            'parent_id' => 'Parent ID',
            'icon' => 'Icon',
            'color' => 'Color',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceAssignments()
    {
        return $this->hasMany(ServiceAssignment::className(), ['service_id' => 'id']);
    }

    public function remove($id){
        $service = Service::findOne(['id'=>$id]);
        if($service){
            $service->active = GlobalConstants::FALSE;
            $service->save();
        }
    }
}
