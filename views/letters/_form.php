<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use brussens\bootstrap\select\Widget as Select;

/* @var $this yii\web\View */
/* @var $model app\models\Letters */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="letters-form">
  
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
    
    <?php if($direction == 2): ?>
        <?= $form->field($model, 'registr')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'date', [
                    'options'=>['class'=>'form-group'],
                    'inputOptions'=>['class'=>'form-control', 'placeholder' => 'Дата'],
                    'errorOptions'=>['class'=>'help-block'],
                    'template'=>"{label}{input}{error}"
                 ])->textInput()->widget(DatePicker::className(),['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control'],  'clientOptions' => ['htmlOptions' => ['class' => 'test'], 'changeYear' => true, 'altFormat' => 'yy-mm-dd', 'yearRange' => '1950:2020']])  ?>

   <?php
        $data_level = ['1' => 'Местный', '2' => 'Областной'];
        $data_direction = ['1' => 'Исходящие', '2' => 'Входящие'];
   ?>
    
    <?=$form->field($model, 'direction')->widget(Select2::classname(), [
        'data' => $data_direction,
        'hideSearch' => true,
        'options' => ['placeholder' => 'Выбрать направление', 'value' => $direction],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
  
    <?=$form->field($model, 'level')->widget(Select2::classname(), [
        'data' => $data_level,
        'hideSearch' => true,
        'options' => ['placeholder' => 'Выбрать уровень', 'value' => $level],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);?>
    
    <?php
        $default_users = array();
        if($model->profile && !empty($model->profile)){
            foreach($model->profile as $key => $value){
                $default_users[] = $value->user_id;
            }
        }
    ?>
    
    <?=$form->field($model, 'users')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выбрать сотрудников', 'multiple' => 'multiple', 'value' => $default_users],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>
  
    <?=$form->field($model, 'contragent')->widget(Typeahead::classname(), [
	'dataset' => [
		[
			'local' => $contragents,
			'limit' => 10
		]
	],
        'pluginOptions' => ['highlight' => true],
	'options' => ['placeholder' => 'Добавить контрагента', 'value' => $model->contragents->title, 'autocomplete' => 'off'],
]);?>
  
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <style>
        .form-control {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</div>
