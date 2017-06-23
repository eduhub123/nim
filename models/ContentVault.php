<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
/**
 * This is the model class for table "content_vault".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $type
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
            [['client_id', 'active'], 'integer'],
            [['url', 'description'], 'string'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 512],
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
            'type' => 'Type',
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

    public function create($client_id, $name, $description, $url, $type){        
        $item = new ContentVault;
        $item->client_id = $client_id;
        $item->name = $name;
        $item->description = $description;
        $item->url = $url;
        $item->type = $type;
        $item->create_date = GlobalFunctions::createMysqlTimestamp();        
        if($item->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            if($type == GlobalConstants::IMAGE_TYPE){
                $response['message'] = GlobalMessages::ADD_IMAGE_SUCCESS;
                $response['data']['id'] = $item->id;
                $response['data']['name'] = $item->name;
                $response['data']['url'] = $item->url;
            }
            else if($type == GlobalConstants::VIDEO_TYPE){
                $response['message'] = GlobalMessages::ADD_VIDEO_SUCCESS;
                $response['data']['id'] = $item->id;
                $response['data']['name'] = $item->name;
                $response['data']['url'] = $item->url;
                $response['data']['time'] = GlobalFunctions::convertTime($item->url);
            }
            else if($type == GlobalConstants::ARTICLE_TYPE){
                $response['message'] = GlobalMessages::ADD_ARTICLE_SUCCESS;
                $response['data']['id'] = $item->id;
                $response['data']['name'] = $item->name;
                $response['data']['description'] = $item->description;
            }
        }else{
            $response['status'] = GlobalConstants::ERROR;
            if($type == GlobalConstants::IMAGE_TYPE)
                $response['message'] = GlobalMessages::ADD_IMAGE_ERROR;
            else if($type == GlobalConstants::VIDEO_TYPE)
                $response['message'] = GlobalMessages::ADD_VIDEO_ERROR;
            else if($type == GlobalConstants::ARTICLE_TYPE)
                $response['message'] = GlobalMessages::ADD_ARTICLE_ERROR;
        }
        return $response;
    }

    public function edit($id, $client_id, $name, $description, $url, $type){
        $item = ContentVault::findOne(['id'=>$id]);
        $item->client_id = $client_id;
        $item->name = $name;
        $item->description = $description;
        $item->url = $url;
        $item->type = $type;    
        if($item->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            if($type == GlobalConstants::IMAGE_TYPE){
                $response['message'] = GlobalMessages::UPDATE_IMAGE_SUCCESS;
                $response['data']['id'] = $item->id;
                $response['data']['name'] = $item->name;
                $response['data']['url'] = $item->url;
            }
            else if($type == GlobalConstants::VIDEO_TYPE){
                $response['message'] = GlobalMessages::UPDATE_VIDEO_SUCCESS;
                $response['data']['id'] = $item->id;
                $response['data']['name'] = $item->name;
                $response['data']['url'] = $item->url;
                $response['data']['time'] = GlobalFunctions::convertTime($item->url);
            }
            else if($type == GlobalConstants::ARTICLE_TYPE){
                $response['message'] = GlobalMessages::UPDATE_ARTICLE_SUCCESS;
                $response['data']['id'] = $item->id;
                $response['data']['name'] = $item->name;
                $response['data']['description'] = $item->description;
            }
        }else{
            $response['status'] = GlobalConstants::ERROR;
            if($type == GlobalConstants::IMAGE_TYPE)
                $response['message'] = GlobalMessages::UPDATE_IMAGE_ERROR;
            else if($type == GlobalConstants::VIDEO_TYPE)
                $response['message'] = GlobalMessages::UPDATE_VIDEO_ERROR;
            else if($type == GlobalConstants::ARTICLE_TYPE)
                $response['message'] = GlobalMessages::UPDATE_ARTICLE_ERROR;
        }
        return $response;
    }

    public function remove($id){
        $item = ContentVault::findOne(['id'=>$id]);
        $item->active = GlobalConstants::FALSE;
        if($item->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            if($item->type == GlobalConstants::IMAGE_TYPE)
                $response['message'] = GlobalMessages::REMOVE_IMAGE_SUCCESS;
            else if($item->type == GlobalConstants::VIDEO_TYPE)
                $response['message'] = GlobalMessages::REMOVE_VIDEO_SUCCESS;
            else if($item->type == GlobalConstants::ARTICLE_TYPE)
                $response['message'] = GlobalMessages::REMOVE_ARTICLE_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            if($item->type == GlobalConstants::IMAGE_TYPE)
                $response['message'] = GlobalMessages::REMOVE_IMAGE_ERROR;
            else if($item->type == GlobalConstants::VIDEO_TYPE)
                $response['message'] = GlobalMessages::REMOVE_VIDEO_ERROR;
            else if($item->type == GlobalConstants::ARTICLE_TYPE)
                $response['message'] = GlobalMessages::REMOVE_ARTICLE_ERROR;
        }
        return $response;
    }

    public function editImage($id, $name){
        $item = ContentVault::findOne(['id'=>$id]);        
        $item->name = $name;
        if($item->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_IMAGE_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_IMAGE_ERROR;
        }
        return $response;
    }
}
