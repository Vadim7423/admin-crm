<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use Yii;
use app\models\Profile;


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
    public $position_id;
    //put your code here
    
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['name', 'required'];
        $rules[] = ['sername', 'required'];
        $rules[] = ['parent_name', 'required'];
        $rules[] = ['position_id', 'required'];
        $rules[] = ['name', 'string', 'max' => 255];
        $rules[] = ['sername', 'string', 'max' => 255];
        $rules[] = ['parent_name', 'string', 'max' => 255];
        $rules[] = ['position_id', 'integer'];
        return $rules;
    }
    
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = \Yii::t('user', 'Name');
        $labels['sername'] = 'Фамилия';
        $labels['parent_name'] = 'Отчество';
        $labels['position_id'] = 'Должность';
        return $labels;
    }
    
    public function loadAttributes(User $user)
    {
        // here is the magic happens
        $user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
        ]);
        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'name' => $this->name,
            'sername' => $this->sername,
            'parent_name' => $this->parent_name,
            'position_id' => $this->position_id,
        ]);
        $user->setProfile($profile);
    }
    
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $this->loadAttributes($user);

        if (!$user->register()) {
            return false;
        }

        Yii::$app->session->setFlash(
            'info',
            'Аккаунт создан. Обратитесь к администратору системы для активации профиля'
        );

        return true;
    }
}
