<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Letters */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Моя корреспонденция', 'url' => ['letters']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="letters-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php Pjax::begin(['enablePushState'=>false]); ?>
        <?php if($model->direction == 2): ?>
            <?php if(!$model->user_id): ?>
            <p>
                <?= Html::a('Принять в работу', [yii\helpers\Url::to(['letters/jobup', 'id' => $model->id])], [
                        'class' => 'btn btn-primary',
                    ]) ?>

            </p>
            <?php else: ?>
            <div class="alert alert-info">В работе <?php echo $model->user_id != Yii::$app->user->identity->id ?  ' у пользователя ' . $model->user->sername . ' ' . $model->user->name . ' ' . $model->user->parent_name : '' ?></div>
                <?php if($model->user_id == Yii::$app->user->identity->id): ?>
                <p>
                     <?= Html::a('Отказаться от исполнения', [yii\helpers\Url::to(['letters/jobup', 'id' => $model->id])], [
                            'class' => 'btn btn-danger',
                        ]) ?>
                    <?= Html::a('Перенаправить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Перевести в статус исполнено', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                </p>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php Pjax::end(); ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'number',
            'date',
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
