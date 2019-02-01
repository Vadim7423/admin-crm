<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $title
 * @property int $letter_id
 * @property int $user_id
 * @property string $created
 * @property string $modified
 *
 * @property Letters $letter
 * @property User $user
 */
class Events extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'modified'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modified'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'letter_id', 'user_id'], 'required'],
            [['letter_id', 'user_id'], 'integer'],
            [['created', 'modified'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['letter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Letters::className(), 'targetAttribute' => ['letter_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Событие',
            'letter_id' => 'Письмо',
            'user_id' => 'Пользователь',
            'created' => 'Дата создания',
            'modified' => 'Дата изменения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLetter()
    {
        return $this->hasOne(Letters::className(), ['id' => 'letter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
