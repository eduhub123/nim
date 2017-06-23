<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;

/**
 * This is the model class for table "ticket_relationship".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ticket_id
 * @property string $content
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property Ticket $ticket
 * @property User $user
 */
class TicketRelationship extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_relationship';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'ticket_id', 'active'], 'integer'],
            [['content'], 'string'],
            [['create_date', 'last_modified'], 'safe'],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'ticket_id' => 'Ticket ID',
            'content' => 'Content',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function create($ticket_id, $user_id, $content){
        $ticketRelationship = new TicketRelationship;
        $ticketRelationship->user_id = $user_id;
        $ticketRelationship->ticket_id = $ticket_id;
        $ticketRelationship->content = $content;
        $ticketRelationship->create_date = GlobalFunctions::createMysqlTimestamp();
        if($ticketRelationship->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::ADD_TICKETRELATIONSHIP_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::ADD_TICKETRELATIONSHIP_ERROR;
        }
        return $response;
    }

    public function edit($id, $ticket_id, $user_id, $content){
        $ticketRelationship = TicketRelationship::findOne(['id'=>$id]);
        $ticketRelationship->user_id = $user_id;
        $ticketRelationship->ticket_id = $ticket_id;
        $ticketRelationship->content = $content;
        if($ticketRelationship->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_TICKETRELATIONSHIP_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_TICKETRELATIONSHIP_ERROR;
        }
        return $response;
    }

    public function remove($id){
        $ticketRelationship = TicketRelationship::findOne(['id'=>$id]);
        $ticketRelationship->active = GlobalConstants::FALSE;
        if($ticketRelationship->save()){
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::REMOVE_TICKETRELATIONSHIP_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::REMOVE_TICKETRELATIONSHIP_ERROR;
        }
        return $response;
    }
}
