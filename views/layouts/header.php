<?php
use yii\helpers\Html;
use yii\web\View;
use dee\adminlte\Nav;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <a href="<?= Yii::$app->homeUrl; ?>" class="logo">
        <span class="logo-mini"><?= ArrayHelper::getValue(Yii::$app->params, 'app.name.small', 'App')?></span>
        <span class="logo-lg"><?= Yii::$app->name ?></span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">

         <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= Yii::$app->user->identity['username']?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/user/security/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
