<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
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

    public function video($id, $url){
        $ad_assignment = AdAssignment::findOne(['id'=>$id, 'client_id'=> Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE]);
        if(!$ad_assignment){
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::AD_UNASSIGNED;
            return $response;
        }
        $ad_assignment->type = GlobalConstants::VIDEO_TYPE;
        $ad_assignment->file_url = $url;
        if($ad_assignment->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_VIDEO_AD_SUCCESS;
            $response['image'] = GlobalFunctions::getYoutubeDetail($url)['title'];
            $response['time'] = GlobalFunctions::convertTime($url);            
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_VIDEO_AD_ERROR;
        }
        return $response;
    }

    public function image($id, $url){
        $ad_assignment = AdAssignment::findOne(['id'=>$id, 'client_id'=> Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE]);
        if(!$ad_assignment){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::AD_UNASSIGNED;
        }
        if($ad_assignment->file_url && !unlink(Yii::$app->getBasePath().'/web/'.$ad_assignment->file_url))
        {
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::REMOVE_IMAGE_AD_ERROR;
            return $response;   
        }else{
            $file = GlobalFunctions::upload('image', Yii::$app->user->identity->current_client);                        
            if(!$file){
                $response['status'] = GlobalConstants::ERROR;
                $response['message'] = GlobalMessages::UPLOAD_IMAGE_AD_ERROR;
                return $response;
            }            
            $ad_assignment->file_url = $file;                    
            $ad_assignment->type = GlobalConstants::IMAGE_TYPE;
            if($ad_assignment->save()){
                $response['status'] = GlobalConstants::SUCCESS;
                $response['message'] = GlobalMessages::UPDATE_IMAGE_AD_SUCCESS;
                $response['image'] = $file;
            }else{
                $response['status'] = GlobalConstants::ERROR;
                $response['message'] = GlobalMessages::UPDATE_IMAGE_AD_ERROR;
            }
        }
        return $response;
    }

    public function linkAd($id, $link){
        $ad_assignment = AdAssignment::findOne(['id'=>$id, 'client_id'=> Yii::$app->user->identity->current_client, 'active'=>GlobalConstants::TRUE]);
        if(!$ad_assignment){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::AD_UNASSIGNED;
        }
        $ad_assignment->link = $link;
        if($ad_assignment->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_LINK_AD_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_LINK_AD_ERROR;
        }
        return $response;
    }
}
