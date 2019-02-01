<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use yii;
use dektrium\user\controllers\AdminController as BaseAdminController;
use dektrium\user\models\Profile;
use app\models\LettersSearch;
use app\models\Letters;
use app\models\UserLetters;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Description of UserController
 *
 * @author USER-777
 */
class SelfController extends BaseAdminController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel(Yii::$app->user->identity->id);
        if(!$user){
            throw new \yii\web\HttpException(404, 'Такой страницы нет');
        }
        $user->scenario = 'update';
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_UPDATE, $event);
        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Account details have been updated'));
            $this->trigger(self::EVENT_AFTER_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('_account', [
            'user' => $user,
        ]);
    }
    
    public function actionUpdateProfile()
    {
        Url::remember('', 'actions-redirect');
        $user    = $this->findModel(Yii::$app->user->identity->id);
        $profile = $user->profile;

        if ($profile == null) {
            $profile = \Yii::createObject(Profile::className());
            $profile->link('user', $user);
        }
        $event = $this->getProfileEvent($profile);

        $this->performAjaxValidation($profile);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);

        if ($profile->load(\Yii::$app->request->post()) && $profile->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Profile details have been updated'));
            $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('_profile', [
            'user'    => $user,
            'profile' => $profile,
        ]);
    }
    
    public function actionInfo()
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel(Yii::$app->user->identity->id);

        return $this->render('_info', [
            'user' => $user,
        ]);
    }
    
    public function actionLetters()
    {
        $id_arr = $this->getArr(UserLetters::find()->where(['user_id' => Yii::$app->user->identity->id])->all());
       
        $letters_arr = Letters::find()->where(['id' => $id_arr])->asArray()->all();
    //    exit(print_r($letters_arr));
        if(empty($letters_arr))
            $letters_arr = 0;
        $searchModel = new LettersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, null, $letters_arr);
        $title = 'Моя корреспонденция';

        return $this->render('letters', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        $model = Letters::findOne($id);
        
        $user_arr = array();
        foreach($model->profile as $key => $value){
            $user_arr[] = $value->user_id;
        }
        if(!in_array(Yii::$app->user->identity->id, $user_arr)){
            throw new NotFoundHttpException('У вас нет доступа для просмотра этой страницы');
        }
        if ($model !== null) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
   
    public function getArr($old_arr = array())
    {
        $new_arr = array();
        foreach($old_arr as $key => $value){
            $new_arr[] = $value['letters_id'];
        }
        if(empty($new_arr))
            return 0;
        return $new_arr;
    }
}
