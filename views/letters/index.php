<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Contragents;
use app\models\Profile;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LettersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letters-index">
    
     <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'number',
            [
              'attribute' => 'registr',
               'format' => 'html',
               'value' => function($data){
                     return !$data->registr && $data->direction == 1 ? '<span class="text-danger">Исходящий документ</span>' : '<span class="text-success">'.$data->registr.'</span>';
               },
            ],
            'title',
             [
                'attribute' => 'date',
                'format' => 'date',
                'filter' => DatePicker::widget(
                        [
                            'model' => $searchModel,
                            'attribute' => 'date',
                            'dateFormat' => 'yyyy-MM-dd',
                            'language' => 'RU',
                            'options' => [
                                'class' => 'form-control'
                            ]
                        ]
                    )
             ],
             [
                'attribute' => 'contragent_id',
                'value' => function($data){
                     return !$data->contragent_id ? '<span class="text-danger">Без контрагента</span>' : '<span class="text-success">'.$data->contragents->title.'</span>';
                },
               'format' => 'html',
               'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'contragent_id',
                    'data' => ArrayHelper::map(Contragents::find()->all(), 'id', 'title'),
                    'value' => isset($params['contragent_id']) ? $params['contragent_id'] : null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение',
                        'width' => 130
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                       // 'selectOnClose' => true,
                    ]
                ])
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
           /*  'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'users',
                    'data' => ArrayHelper::map(Profile::find()->all(), 'user_id', 'sername'),
                    'value' => isset($params['users']) ? $params['users'] : null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение',
                        'multiple' => 'multiple'
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                       // 'selectOnClose' => true,
                    ]
                ])*/
            ],
            /*[
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
            ],*/
            //'contragent_str',
          //  'contragent_id',
            //'status_id',
            //'level',
            //'direction',
            //'created',
            //'modified',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <style>
        body td{
         //   font-size: 16px;
            font-weight:bold;
        }
    </style>
</div>
