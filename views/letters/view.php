<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Letters */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Корреспонденция', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cat_title, 'url' => ['category', 'direction' => $model->direction, 'level' => $model->level]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="letters-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'number',
            'date',
            [
                'attribute' => 'registr',
                'value' => function($data){
                    return $data->registr ? $data->registr : 'Не требуется'; 
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'user_id',
                'value' => function($data){
                    return !$data->user->user_id ? '<span class="text-danger">Исполнитель не назначен</span>' : '<span class="text-success">'.$data->user->sername . ' ' . $data->user->name . ' ' . $data->user->parent_name . '</span>';
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'users',
                'value' => function($data){
                    $table = '';
                    if($data->profile){
                        foreach($data->profile as $key => $value){
                            $table .= '<tr><td style="padding:0 10px 0 0;font-weight:bold">'.$value->sername . ' ' .$value->name . ' ' . $value->parent_name . '</td></tr>';
                        }
                    }
                    return !$data->profile ? '<span class="text-danger">Нет</span>' : '<table><tbody>'.$table.'</tbody></table>';
                },
                'format' => 'html',
            ],
             [
                'attribute' => 'contragent',
                'value' => function($data){
                     return !$data->contragents->id ? '<span class="text-danger">Без контрагента</span>' : '<span class="text-success">'.$data->contragents->title.'</span>';
                },
                'format' => 'html',
            ],
             [
                'attribute' => 'status_id',
                'value' => function($data){
                     return !$data->status_id ? '<span class="text-danger">Без статуса</span>' : '<span class="text-success">'.$data->statuses->title.'</span>';
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'level',
                'value' => function($data){
                     return $data->level == 2 ? '<span class="text-danger">Областной</span>' : '<span class="text-success">Местный</span>';
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'direction',
                'value' => function($data){
                     return $data->direction == 2 ? '<span class="text-danger">Входящее</span>' : '<span class="text-success">Исходящее</span>';
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'history',
                'value' => function($data){
                    $table = '';
                    if($data->events){
                        foreach($data->events as $key => $value){
                            $table .= '<tr><td style="padding:0 10px 0 0;font-weight:bold">'.$value->title . ' ' . date('Y.d.m H:i:s', strtotime($value->created)) . ' пользователем с логином ' . $value->user->username . '</td></tr>';
                        }
                    }
                    return !$data->events ? '<span class="text-danger">Нет</span>' : '<table><tbody>'.$table.'</tbody></table>';
                },
                'format' => 'html',
            ],
            'created',
            'modified',
        ],
    ]) ?>

</div>
