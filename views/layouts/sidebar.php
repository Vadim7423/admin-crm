<?php

use yii\web\View;
use dee\adminlte\SideNav;
use yii\helpers\ArrayHelper;

//use yii\helpers\Html;

/* @var $this View */

$items = ArrayHelper::getValue($this->params, 'sideMenu', []);
$user_arr = Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
?>
<aside class="main-sidebar">
    
    <section class="sidebar">
        <?php if(!Yii::$app->user->isGuest): ?>
        <?= app\components\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    !Yii::$app->user->isGuest ? ['label' => 'Мой профиль', 'icon' => 'shield', 'url' => ['/self']] : '',
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    isset($user_arr['admin']) ?  [
                        'label' => 'Пользователи',
                        'icon' => 'users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Управление пользователями', 'icon' => 'circle-o', 'url' => ['/admin']],
                            ['label' => 'Управление должностями', 'icon' => 'circle-o', 'url' => ['/positions']],
                         ]
                    ] : '',
                    isset($user_arr['admin']) ? ['label' => 'Управление доступом', 'icon' => 'shield', 'url' => ['/users-admin']] : '',
                    [
                        'label' => 'Корреспонденция',
                        'icon' => 'send-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Входящая', 'icon' => 'circle-o', 'url' => '#', 'items' => [
                                ['label' => 'Местная', 'icon' => 'circle-o', 'url' => ['/letters/category', 'direction' => 2, 'level' => 1]],
                                ['label' => 'Областная', 'icon' => 'circle-o', 'url' => ['/letters/category', 'direction' => 2, 'level' => 2]]
                            ]],
                            ['label' => 'Исходящая', 'icon' => 'circle-o', 'url' => '#', 'items' => [
                                ['label' => 'Местная', 'icon' => 'circle-o', 'url' => ['/letters/category', 'direction' => 1, 'level' => 1]],
                                ['label' => 'Областная', 'icon' => 'circle-o', 'url' => ['/letters/category', 'direction' => 1, 'level' => 2]]
                            ]],
                            isset($user_arr['admin']) ? ['label' => 'Статусы', 'icon' => 'circle-o', 'url' => ['/statuses']] : ''
                         ]
                    ],
                ],
            ]
        ) ?>
        <?php endif; ?>
    </section>
</aside>
