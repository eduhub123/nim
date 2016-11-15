<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\assets\GlobalConstants;
use app\assets\GlobalFunctions;
use app\models\UserAssignment;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $user_type_id
 * @property string $firstname
 * @property string $lastname
 * @property string $phone
 * @property string $address
 * @property string $birthday
 * @property string $avatar
 * @property string $salt
 * @property integer $industry_id
 * @property integer $active
 * @property string $last_modified
 * @property string $create_date
 *
 * @property AdAssignment[] $adAssignments
 * @property AdsSupport[] $adsSupports
 * @property AdsSupport[] $adsSupports0
 * @property Advertising[] $advertisings
 * @property AdvertisingPromotion[] $advertisingPromotions
 * @property Calendar[] $calendars
 * @property ContentVault[] $contentVaults
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Notification[] $notifications
 * @property Notification[] $notifications0
 * @property ServiceAssignment[] $serviceAssignments
 * @property Ticket[] $tickets
 * @property Ticket[] $tickets0
 * @property TicketRelationship[] $ticketRelationships
 * @property UserType $userType
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'salt'], 'required'],
            [['password', 'address', 'avatar'], 'string'],
            [['user_type_id', 'industry_id', 'current_client', 'active'], 'integer'],
            [['birthday', 'last_modified', 'create_date'], 'safe'],
            [['username'], 'string', 'max' => 256],
            [['firstname', 'lastname'], 'string', 'max' => 128],
            [['phone', 'salt'], 'string', 'max' => 50],
            [['user_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::className(), 'targetAttribute' => ['user_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'user_type_id' => 'User Type ID',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'avatar' => 'Avatar',
            'salt' => 'Salt',
            'industry_id' => 'Industry ID',
            'active' => 'Active',
            'last_modified' => 'Last Modified',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdAssignments()
    {
        return $this->hasMany(AdAssignment::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdsSupports()
    {
        return $this->hasMany(AdsSupport::className(), ['to_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdsSupports0()
    {
        return $this->hasMany(AdsSupport::className(), ['from_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisings()
    {
        return $this->hasMany(Advertising::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingPromotions()
    {
        return $this->hasMany(AdvertisingPromotion::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendars()
    {
        return $this->hasMany(Calendar::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentVaults()
    {
        return $this->hasMany(ContentVault::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['user_change_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['user_change_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications0()
    {
        return $this->hasMany(Notification::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceAssignments()
    {
        return $this->hasMany(ServiceAssignment::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets0()
    {
        return $this->hasMany(Ticket::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketRelationships()
    {
        return $this->hasMany(TicketRelationship::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'user_type_id']);
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * Finds user by salt
     *
     * @param  string      $salt
     * @return static|null
     */
    public static function findBySalt($salt)
    {
        return static::findOne(['salt' => $salt]);
    }

    public static function findById($id){
        return static::findOne(['id' => $id]);   
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password, $db_password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $db_password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Finds the identity based on the provided id
     *
     * @param string $id
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds the identity based on the Access Token provided
     *
     * @param string $token
     * @param string $type
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['salt' => $token]);
    }

    /**
     * Gets the user id
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the user auth key
     */
    public function getAuthKey()
    {
        return $this->salt;
    }

    /**
     * Validate the auth key
     *
     * @param string $authKey
     */
    public function validateAuthKey($authKey)
    {
        return $this->salt === $authKey;
    }

    public function setCurrentClient(){
        $user = Yii::$app->user->identity;
        if(!$user->current_client){
            if (Yii::$app->user->can(GlobalConstants::SUPERADMIN_PERMISSIONS))
                $client = User::find()->where(['user_type_id'=>GlobalConstants::CLIENT_TYPE_ID, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();        
            else if (Yii::$app->user->can(GlobalConstants::ADMIN_PERMISSIONS))
                $userAss = UserAssignment::find()->where(['admin'=>$user->id, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();
            else if (Yii::$app->user->can(GlobalConstants::ADSPECIALIST_PERMISSIONS))
                $userAss = UserAssignment::find()->where(['ad_specialist'=>$user->id, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();
            else if (Yii::$app->user->can(GlobalConstants::COPYWRITER_PERMISSIONS))
                $userAss = UserAssignment::find()->where(['copywiter'=>$user->id, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();
            else if (Yii::$app->user->can(GlobalConstants::DESIGNER_PERMISSIONS))
                $userAss = UserAssignment::find()->where(['designer'=>$user->id, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();
            else if (Yii::$app->user->can(GlobalConstants::GENERAL_PERMISSIONS))
                $userAss = UserAssignment::find()->where(['general'=>$user->id, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();
            else if (Yii::$app->user->can(GlobalConstants::MARKETINGDIRECTOR_PERMISSIONS))
                $userAss = UserAssignment::find()->where(['marketing_director'=>$user->id, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();
            else if (Yii::$app->user->can(GlobalConstants::SALEPERSON_PERMISSIONS))
                $userAss = UserAssignment::find()->where(['sale_person'=>$user->id, 'active'=>GlobalConstants::TRUE])->orderBy(['id'=>SORT_DESC])->one();

            if(isset($userAss)){
                $user->current_client = $userAss->client_id;
                $user->save();
            }
            if(isset($client)){
                $user->current_client = $client->id;
                $user->save();
            }
        }
    }
    /*
    * Remove
    */
    public function remove($user_id){
        $user = User::findOne(['id'=>$user_id]);
        $user->active = GlobalConstants::FALSE;
        $user->save();
    }
}
