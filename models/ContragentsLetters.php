<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contragents_letters".
 *
 * @property int $contragents_id
 * @property int $letters_id
 *
 * @property Contragents $contragents
 * @property Letters $letters
 */
class ContragentsLetters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contragents_letters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contragents_id', 'letters_id'], 'required'],
            [['contragents_id', 'letters_id'], 'integer'],
            [['contragents_id', 'letters_id'], 'unique', 'targetAttribute' => ['contragents_id', 'letters_id']],
            [['contragents_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contragents::className(), 'targetAttribute' => ['contragents_id' => 'id']],
            [['letters_id'], 'exist', 'skipOnError' => true, 'targetClass' => Letters::className(), 'targetAttribute' => ['letters_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contragents_id' => 'Contragents ID',
            'letters_id' => 'Letters ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContragents()
    {
        return $this->hasOne(Contragents::className(), ['id' => 'contragents_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLetters()
    {
        return $this->hasOne(Letters::className(), ['id' => 'letters_id']);
    }
}
