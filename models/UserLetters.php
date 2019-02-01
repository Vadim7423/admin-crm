<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_letters".
 *
 * @property int $user_id
 * @property int $letters_id
 *
 * @property Letters $letters
 * @property User $user
 */
class UserLetters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_letters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'letters_id'], 'required'],
            [['user_id', 'letters_id'], 'integer'],
            [['user_id', 'letters_id'], 'unique', 'targetAttribute' => ['user_id', 'letters_id']],
            [['letters_id'], 'exist', 'skipOnError' => true, 'targetClass' => Letters::className(), 'targetAttribute' => ['letters_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'letters_id' => 'Letters ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLetters()
    {
        return $this->hasOne(Letters::className(), ['id' => 'letters_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
