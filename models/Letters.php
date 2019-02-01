<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "letters".
 *
 * @property int $id
 * @property string $title
 * @property string $number
 * @property string $date
 * @property int $user_id
 * @property int $contragent_id
 * @property int $status_id
 * @property int $level
 * @property int $direction
 * @property string $created
 * @property string $modified
 *
 * @property Events[] $events
 */
class Letters extends \yii\db\ActiveRecord
{
    public $users;
    public $contragent;
    public $history;
    
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
        return 'letters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'number', 'date', 'level', 'direction'], 'required'],
            [['date', 'created', 'modified', 'users'], 'safe'],
            [['contragent'], 'string'],
            [['user_id', 'contragent_id', 'status_id', 'level', 'direction'], 'integer'],
            [['title', 'number', 'registr'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Краткое описание',
            'number' => 'Номер',
            'registr' => 'Реквизиты входящего документа',
            'date' => 'Дата',
            'user_id' => 'Исполнитель',
            'contragent' => 'Контрагент',
            'contragent_id' => 'Контрагент ID',
            'status_id' => 'Статус',
            'level' => 'Уровень',
            'direction' => 'Направление',
            'created' => 'Дата создания',
            'modified' => 'Дата изменения',
            'users' => 'Ответственные сотрудникии',
            'history' => 'История'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['letter_id' => 'id']);
    }
    
    public function getProfile(){
         return $this->hasMany(Profile::className(), ['user_id' => 'user_id'])
            ->viaTable('user_letters', ['letters_id' => 'id']);
    }
    
   /* public function getContragents(){
         return $this->hasMany(Contragents::className(), ['id' => 'contragents_id'])
            ->viaTable('contragents_letters', ['letters_id' => 'id']);
    }*/
    
    public function getContragents()
    {
        return $this->hasOne(Contragents::className(), ['id' => 'contragent_id']);
    }
    
    public function getStatuses()
    {
        return $this->hasOne(Statuses::className(), ['id' => 'status_id']);
    }
    
    public function getUser()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }
}
