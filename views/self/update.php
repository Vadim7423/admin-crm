<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\User $user
 * @var string $content
 */

$this->title = Yii::t('user', 'Update user account');
$this->params['breadcrumbs'][] = $this->title;
?>

<?//= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => Yii::t('user', 'Information'), 'url' => ['/self/info']],
                        [
                            'label' => Yii::t('user', 'Account details'),
                            'url' => ['/self/index']
                        ],
                        [
                            'label' => Yii::t('user', 'Profile details'),
                            'url' => ['/self/update-profile']
                        ],
                        [
                            'label' => 'Моя корреспонденция',
                            'url' => ['/self/letters']
                        ],
                        [
                            'label' => Yii::t('user', 'Assignments'),
                            'url' => ['/self/assignments'],
                            'visible' => isset(Yii::$app->extensions['dektrium/yii2-rbac']),
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
