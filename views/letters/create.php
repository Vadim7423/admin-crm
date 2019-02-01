<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Letters */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Корреспонденция', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $str2, 'url' => ['category', 'direction' => $direction, 'level' => $level]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letters-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'contragents' => $contragents,
        'level' => $level,
        'direction' => $direction,
    ]) ?>

</div>
