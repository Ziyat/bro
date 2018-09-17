<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">BRS</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <?php if(Yii::$app->session->get('imitation')): ?>
                <li class="dropdown notifications-menu">
                    <?=
                    Html::a(
                        Html::tag('i',
                            '',
                            ['class' => 'fa fa-sign-out']),
                        ['/users/imitation', 'user_id' => Yii::$app->session->get('imitation')],[
                                'class' => 'dropdown-toggle'
                    ]);
                    ?>
                </li>
                <?php endif;?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/favicons/android-chrome-192x192.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">Bank report systems</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/favicons/android-chrome-192x192.png" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= Yii::$app->user->identity->name ?> - Bank report systems
                                <small><?= Yii::$app->formatter->asDate(date('d-m-Y')); ?></small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выход из системы',
                                    ['auth/logout'],
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
