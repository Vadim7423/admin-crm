<?php

use yii\helpers\Html;
use dee\adminlte\AdminlteAsset;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AdminlteAsset::register($this);
$breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <script type="text/javascript">var readyjs = [];</script>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <?= $this->render('header'); ?>
            <?= $this->render('sidebar'); ?>
            <div class="content-wrapper">
                <?php if( Yii::$app->session->hasFlash('success') ): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Yii::$app->session->getFlash('success'); ?>
                    </div>
                <?php endif;?>
                <?php if( Yii::$app->session->hasFlash('error') ): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo Yii::$app->session->getFlash('error'); ?>
                    </div>
                <?php endif;?>
                <section class="content-header">
                    <?=
                    Breadcrumbs::widget([
                        'tag' => 'ol',
                        'encodeLabels' => false,
                        'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> Главная', 'url' => ['/site/index']],
                        'links' => $breadcrumbs,
                    ])
                    ?>
                </section>
                <section class="content">
                    <?= $content ?>
                </section>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Version 2.0
                </div>
                <strong>Copyright &copy; 2015 <a href="#">Deesoft</a>.</strong> All rights reserved.
            </footer>
        </div>
        <?php $this->endBody() ?>
        <script type="text/javascript" >
        $(document).ready(function(){
          if(readyjs)
          for(var i=0; i < readyjs.length; i++)
          setTimeout(readyjs[i]);  
        });
       </script>
    </body>
</html>
<?php $this->endPage() ?>
