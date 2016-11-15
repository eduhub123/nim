<?php

namespace app\models;

use Yii;

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
}
