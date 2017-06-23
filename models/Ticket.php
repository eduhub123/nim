<?php

namespace app\models;

use Yii;
use app\assets\GlobalFunctions;
use app\assets\GlobalConstants;
use app\assets\GlobalMessages;
use app\models\TicketRelationship;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $client_id
 * @property string $name
 * @property integer $response
 * @property string $status
 * @property integer $active
 * @property string $create_date
 * @property string $last_modified
 *
 * @property Message[] $messages
 * @property User $author
 * @property User $client
 * @property TicketRelationship[] $ticketRelationships
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'client_id', 'response', 'active'], 'integer'],
            [['create_date', 'last_modified'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['status'], 'string', 'max' => 10],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
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
            'author_id' => 'Author ID',
            'client_id' => 'Client ID',
            'name' => 'Name',
            'response' => 'Response',
            'status' => 'Status',
            'active' => 'Active',
            'create_date' => 'Create Date',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketRelationships()
    {
        return $this->hasMany(TicketRelationship::className(), ['ticket_id' => 'id']);
    }

    public function create($author_id, $client_id, $name, $content){
        $ticket = new Ticket;
        $ticket->author_id = $author_id;
        $ticket->client_id = $client_id;
        $ticket->name = $name;
        $ticket->create_date = GlobalFunctions::createMysqlTimestamp();
        if($ticket->save()){
            $ticketRelationship = new TicketRelationship;
            $ticketRelationship->user_id = $author_id;
            $ticketRelationship->ticket_id = $ticket->id;
            $ticketRelationship->content = $content;
            $ticketRelationship->create_date = GlobalFunctions::createMysqlTimestamp();
            if($ticketRelationship->save()){
                $response['status'] = GlobalConstants::SUCCESS;
                $response['message'] = GlobalMessages::ADD_TICKET_SUCCESS;
            }else{
                $response['status'] = GlobalConstants::ERROR;
                $response['message'] = GlobalMessages::ADD_TICKETRELATIONSHIP_ERROR;
            }
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::ADD_TICKET_ERROR;
        }
        return $response;
    }

    public function edit($id, $name, $content){
        $ticket = Ticket::findOne(['id'=>$id]);
        $ticket->name = $name;        
        $ticketRelationship = TicketRelationship::findOne(['ticket_id'=>$id]);
        $ticketRelationship->content = $content;        
        if($ticket->save() && $ticketRelationship->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::UPDATE_TICKET_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::UPDATE_TICKET_ERROR;
        }
        return $response;
    }

    public function open($id){
        $ticket = Ticket::findOne(['id'=>$id]);
        $ticket->status = GlobalConstants::TRUE;
        if($ticket->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::OPEN_TICKET_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::OPEN_TICKET_ERROR;
        }
        return $response;
    }

    public function close($id){
        $ticket = Ticket::findOne(['id'=>$id]);
        $ticket->status = GlobalConstants::FALSE;
        if($ticket->save())
        {
            $response['status'] = GlobalConstants::SUCCESS;
            $response['message'] = GlobalMessages::CLOSE_TICKET_SUCCESS;
        }else{
            $response['status'] = GlobalConstants::ERROR;
            $response['message'] = GlobalMessages::CLOSE_TICKET_ERROR;
        }
        return $response;
    }
}
