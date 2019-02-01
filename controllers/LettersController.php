<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Letters;
use app\models\LettersSearch;
use app\models\Profile;
use app\models\Events;
use app\models\Contragents;
use app\models\ContragentsLetters;
use app\models\UserLetters;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class LettersController extends AppController
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
                        'actions' => ['error', 'index', 'category', 'view', 'jobup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'secretar'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Lists all Letters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LettersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $title = 'Корреспонденция';
        $this->setMeta($title);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title
        ]);
    }
    
    public function actionCategory($direction = null, $level = null)
    {
        $searchModel = new LettersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $direction, $level);
        $title = $this->categoryName($direction, $level);

        return $this->render('category', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
            'direction' => $direction,
            'level' => $level
        ]);
    }

    /**
     * Displays a single Letters model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $cat_title = $this->categoryName($model->direction, $model->level);
        return $this->render('view', [
            'model' => $model,
            'cat_title' => $cat_title,
        ]);
    }

    /**
     * Creates a new Letters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($direction = null, $level = null)
    {
        $model = new Letters();
        $str1 = 'Добавить корреспонденцию';
        $str2 = $this->categoryName($direction, $level);
        $title = $this->getFinalTitle($str1, $str2);
        
        $users = $this->getUsers();
        $contragents = $this->getContragents();
        $model->status_id = 1;
        $contragent_pol = '';
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //   exit(print_r($model));
            $this->setUserLetters($model->id, $model->users);
            $contragent_pol = $this->setContragentsLetters($model->id, $model->contragent);
            $this->setEvent(Yii::$app->user->identity->id, $model->id, 'Создано');
            $model->contragent_id = $contragent_pol;
            $model->update();
            Yii::$app->session->setFlash('success', "Корреспонденция добавлена");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', compact(['model', 'title', 'users', 'contragents', 'level', 'direction', 'str2']));
    }
    
    /**
     * Updates an existing Letters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $users = $this->getUsers();
        $contragents = $this->getContragents();
        $cat_title = $this->categoryName($model->direction, $model->level);
        $contragent_pol = '';
        $direction = $model->direction;
        $level = $model->level;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setUserLetters($model->id, $model->users, true);
            $contragent_pol = $this->setContragentsLetters($model->id, $model->contragent, true);
            $this->setEvent(Yii::$app->user->identity->id, $model->id, 'Изменено');
            $model->contragent_id = $contragent_pol;
            $model->update();
            Yii::$app->session->setFlash('success', "Корреспонденция изменена");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', compact(['model', 'users', 'contragents', 'level', 'direction', 'cat_title']));
    }
    
    public function actionJobup($id)
    {
        $model = $this->findModel($id);
        $event = new Events();
        
        if(Yii::$app->request->isAjax){
            $model->user_id = Yii::$app->user->identity->id;
            $model->status_id = 3;
            $model->update();
            $event->user_id = Yii::$app->user->identity->id;
            $event->letter_id = $model->id;
            $event->title = 'Принято к исполнению';
            $event->save();
            return $this->renderAjax('answer_success');
	}
        return $this->renderAjax('answer_error');
    }

    /**
     * Deletes an existing Letters model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Корреспонденция удалена");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Letters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Letters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Letters::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function categoryName($direction = null, $level = null)
    {
        $title = '';
        $arr = ['Входящие', 'Исходящие', 'Областной уровень', 'Местный уровень'];
        if($direction == 2 && !isset($level)) {
            $title = $arr[0];
        }elseif($direction == 1 && !isset($level)) {
            $title = $arr[1];
        }elseif($direction == 2 && $level == 2) {
            $title = $arr[0].', '.$arr[2];
        }elseif($direction == 2 && $level == 1) {
            $title = $arr[0].', '.$arr[3];
        }elseif($direction == 1 && $level == 2) {
            $title = $arr[1].', '.$arr[2];
        }elseif($direction == 1 && $level == 1) {
            $title = $arr[1].', '.$arr[3];
        }
        return $title;
    }
    
    protected function getFinalTitle($str1 = null, $str2 = null)
    {
        if(!$str1)
            return '';
        if(!$str2)
            return $str1;
        return $str1 . ' (' . $str2 . ')';
    }
    
    protected function setUserLetters($letter_id = null, $users = null, $flag = false)
    {
        if(!$letter_id){
            return;
        }
        $links = array();
        
        if($flag){
           $links = UserLetters::find()->where(['user_letters.letters_id' => $letter_id])->all();
           foreach($links as $key => $value){
               $value->delete();
           }
        }
        
        if(!$users){
            return;
        }
        
        foreach($users as $key => $value){
            $ul = new UserLetters();
            $ul->user_id = $value;
            $ul->letters_id = $letter_id;
            $ul->save();
        }
    }
    
    protected function setContragentsLetters($letter_id = null, $contragent = null, $flag = false)
    {
        if(!$letter_id || !$contragent){
            return;
        }
     
        if($flag){
           $links = ContragentsLetters::find()->where(['contragents_letters.letters_id' => $letter_id])->all();
           foreach($links as $key => $value){
               $value->delete();
           }
        }
        $model = new ContragentsLetters();
        $model->contragents_id = $this->setContragent($contragent);
        $model->letters_id = $letter_id;
        $model->save();
        return $model->contragents_id;
    }
    
    protected function setContragent($contragent = null)
    {
        if(!$contragent)
            return;
        $new_contragent = trim($contragent);
        $contragents = $this->getContragentsById();
        if (in_array($new_contragent, $contragents)) {
            return $this->getContragentId($new_contragent, $contragents);
        }
        $model = new Contragents();
        $model->title = $new_contragent;
        $model->save();
        return $model->id;
    }
    
    protected function getContragentId($contragent = null, $contragents = null)
    {
        if(!$contragents || !$contragent)
            return;
        
        foreach($contragents as $key => $value){
            if($value == $contragent)
                return $key;
        }
    }
    
    protected function setEvent($user_id = null, $letter_id = null, $message = null)
    {
        $model = new Events();
        $model->user_id = $user_id;
        $model->letter_id = $letter_id;
        $model->title = $message;
        $model->save();
    }
    
    protected function getUsers()
    {
        $users_arr = [];
        $users = Profile::find()->indexBy('user_id')->orderBy(['sername' => 'DESC'])->asArray()->all();
           foreach($users as $key => $value){
               if(!empty($value['sername']) && !empty($value['name']) && !empty($value['parent_name']))
               $users_arr[$key] = $value['sername'] . ' ' . $value['name'] . ' ' . $value['parent_name'];
           }
        return $users_arr;
    }
    
    protected function getContragents()
    {
        $arr = [];
        $contragents = Contragents::find()->asArray()->all();
           foreach($contragents as $key => $value){
               if(!empty($value['title']))
               $arr[] = $value['title'];
           }
        return $arr;
    }
    
    protected function getContragentsById()
    {
        $arr = [];
        $contragents = Contragents::find()->indexBy('id')->asArray()->all();
           foreach($contragents as $key => $value){
               if(!empty($value['title']))
               $arr[$key] = $value['title'];
           }
        return $arr;
    }
    
    public function actionContragentsList($q = null) {
        $query = new Query;

        $query->select('title')
            ->from('contragents')
            ->where('title LIKE "%' . $q .'%"')
            ->orderBy('title');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name']];
        }
        echo Json::encode($out);
    }
    
}
