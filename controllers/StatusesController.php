<?php

namespace app\controllers;

use Yii;
use app\models\Statuses;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StatusesController implements the CRUD actions for Statuses model.
 */
class StatusesController extends AppController
{
    /**
     * {@inheritdoc}
     */
    /**
     * Lists all Statuses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Statuses::find(),
        ]);
        $title = 'Статусы';
        $this->setMeta($title);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'title' => $title
        ]);
    }

    /**
     * Displays a single Statuses model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $title = $model->title;;
        $this->setMeta($title);
        
        return $this->render('view', [
            'model' => $model,
            'title' => $title
        ]);
    }

    /**
     * Creates a new Statuses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Statuses();
        $title = 'Добавить статус';
        $this->setMeta($title);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Статус добавлен");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'title' => $title
        ]);
    }

    /**
     * Updates an existing Statuses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $title = 'Изменить статус';
        $this->setMeta($title);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Статус изменен");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'title' => $title
        ]);
    }

    /**
     * Deletes an existing Statuses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Статус удален");
        return $this->redirect(['index']);
    }

    /**
     * Finds the Statuses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Statuses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Statuses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
