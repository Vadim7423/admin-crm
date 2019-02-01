<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "redirects".
 *
 * @property int $id
 * @property int $letter_id
 * @property int $user_id
 * @property int $parent_id
 * @property string $created
 * @property string $modified
 *
 * @property Letters $letter
 * @property User $user
 */
class Redirects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'redirects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['letter_id', 'user_id', 'parent_id', 'created', 'modified'], 'required'],
            [['letter_id', 'user_id', 'parent_id'], 'integer'],
            [['created', 'modified'], 'safe'],
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
            'letter_id' => 'Letter ID',
            'user_id' => 'User ID',
            'parent_id' => 'Parent ID',
            'created' => 'Created',
            'modified' => 'Modified',
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
