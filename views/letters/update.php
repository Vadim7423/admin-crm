<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Letters */

$this->title = 'Изменить письмо: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Корреспонденция', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cat_title, 'url' => ['category', 'direction' => $model->direction, 'level' => $model->level]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="letters-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'contragents' => $contragents,
        'level' => $level,
        'direction' => $direction,
    ]) ?>

</div>
