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

$this->title = 'Моя корреспонденция';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => ['/self/info']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letters-index">
    
     <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'number',
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
                'attribute' => 'direction',
                'value' => function($data){
                    return $data->direction == 2 ? '<span class="text-danger">Входящее</span>' : '<span class="text-success">Исходящее</span>';
                },
                'format' => 'html',
            ],
            //'contragent_str',
          //  'contragent_id',
            //'status_id',
            //'level',
            //'direction',
            //'created',
            //'modified',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
