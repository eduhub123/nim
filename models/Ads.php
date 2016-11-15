<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;

/**
 * This is the model class for table "ads".
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
 * @property AdAssignment[] $adAssignments
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['parent_id', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['icon'], 'string', 'max' => 50],
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
    public function getAdAssignments()
    {
        return $this->hasMany(AdAssignment::className(), ['ad_id' => 'id']);
    }

    public function create($name, $parent_id = null, $color, $icon, $description){
        $ad = new Ads;
        $ad->name = $name;
        $ad->color = $color;
        $ad->icon = $icon;
        $ad->description = $description;
        $ad->create_date = GlobalFunctions::createMysqlTimestamp();        
        if($parent_id)
            $ad->parent_id = $parent_id;
        if($ad->save()){
            $response['status'] = 'success';
            $response['message'] = GlobalMessages::ADD_ADS_SUCCESS;
            $response['url'] = '/superadmin/adsmanagement';
        }else{
            $response['status'] = 'error';
            $response['message'] = GlobalMessages::ADD_ADS_ERROR;
        }
        return $response;
    }

    public function update($id, $name, $parent_id = null, $color, $icon, $description){
        $ad = Ads::findOne(['id'=>$id]);
        $ad->name = $name;
        $ad->color = $color;
        $ad->icon = $icon;
        $ad->description = $description;                    
        if($parent_id)
            $ad->parent_id = $parent_id;
        if($ad->save()){
            $response['status'] = 'success';
            $response['message'] = GlobalMessages::UPDATE_ADS_SUCCESS;
            $response['url'] = '/superadmin/adsmanagement';
        }else{
            $response['status'] = 'error';
            $response['message'] = GlobalMessages::UPDATE_ADS_ERROR;
        }
        return $response;
    }

    public function remove($id){
        $ad = Ads::findOne(['id'=>$id]);
        $ad->active = GlobalConstants::FALSE;
        if($ad->save()){
            $response['status'] = 'success';
            $response['message'] = GlobalMessages::REMOVE_ADS_SUCCESS;
        }else{
            $response['status'] = 'error';
            $response['message'] = GlobalMessages::REMOVE_ADS_ERROR;
        }            
        return $response;
    }
}
