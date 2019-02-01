<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use Yii;

/**
 * Description of RegistrationForm
 *
 * @author Вадим
 */
class RegistrationForm extends BaseRegistrationForm
{
    public $name;
    public $sername;
    public $parent_name;
    public $code_id;
    //put your code here
    public function attributeLabels()
    {
        return [
            'email'    => Yii::t('user', 'Email'),
            'username' => Yii::t('user', 'Username'),
            'password' => Yii::t('user', 'Password'),
            'name' => 'Имя',
            'sername' => 'Фамилия',
            'parent_name' => 'Отчество',
            'position_id' => 'Промо код',
        ];
    }
}
