<?php

namespace app\models;

use Yii;

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
}
