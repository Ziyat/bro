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

                <!-- Messages: style can be found in dropdown.less-->
<!--                <li class="dropdown messages-menu">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
<!--                        <i class="fa fa-envelope-o"></i>-->
<!--                        <span class="label label-success">1</span>-->
<!--                    </a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li class="header">You have 1 messages</li>-->
<!--                        <li>-->
<!--                            <!-- inner menu: contains the actual data -->
<!--                            <ul class="menu">-->
<!--                                <li><!-- start message -->
<!--                                    <a href="#">-->
<!--                                        <div class="pull-left">-->
<!--                                            <img src="--><?//= $directoryAsset ?><!--/img/user2-160x160.jpg" class="img-circle"-->
<!--                                                 alt="User Image"/>-->
<!--                                        </div>-->
<!--                                        <h4>-->
<!--                                            Support Team-->
<!--                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>-->
<!--                                        </h4>-->
<!--                                        <p>Why not buy a new awesome theme?</p>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <!-- end message -->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li class="footer"><a href="#">See All Messages</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--                <li class="dropdown notifications-menu">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
<!--                        <i class="fa fa-bell-o"></i>-->
<!--                        <span class="label label-warning">1</span>-->
<!--                    </a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li class="header">You have 1 notifications</li>-->
<!--                        <li>-->
<!--                            <!-- inner menu: contains the actual data -->
<!--                            <ul class="menu">-->
<!--                                <li>-->
<!--                                    <a href="#">-->
<!--                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li class="footer"><a href="#">View all</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
                <!-- Tasks: style can be found in dropdown.less -->
<!--                <li class="dropdown tasks-menu">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
<!--                        <i class="fa fa-flag-o"></i>-->
<!--                        <span class="label label-danger">9</span>-->
<!--                    </a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li class="header">You have 9 tasks</li>-->
<!--                        <li>-->
<!--                            <!-- inner menu: contains the actual data -->
<!--                            <ul class="menu">-->
<!--                                <li><!-- Task item -->
<!--                                    <a href="#">-->
<!--                                        <h3>-->
<!--                                            Design some buttons-->
<!--                                            <small class="pull-right">20%</small>-->
<!--                                        </h3>-->
<!--                                        <div class="progress xs">-->
<!--                                            <div class="progress-bar progress-bar-aqua" style="width: 20%"-->
<!--                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"-->
<!--                                                 aria-valuemax="100">-->
<!--                                                <span class="sr-only">20% Complete</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </li>-->
<!--                                <!-- end task item -->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li class="footer">-->
<!--                            <a href="#">View all tasks</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
                <!-- User Account: style can be found in dropdown.less -->

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
                        <!-- Menu Body -->
<!--                        <li class="user-body">-->
<!--                            <div class="col-xs-4 text-center">-->
<!--                                <a href="#">Followers</a>-->
<!--                            </div>-->
<!--                            <div class="col-xs-4 text-center">-->
<!--                                <a href="#">Sales</a>-->
<!--                            </div>-->
<!--                            <div class="col-xs-4 text-center">-->
<!--                                <a href="#">Friends</a>-->
<!--                            </div>-->
<!--                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
<!--                            <div class="pull-left">-->
<!--                                <a href="#" class="btn btn-default btn-flat">Profile</a>-->
<!--                            </div>-->
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

                <!-- User Account: style can be found in dropdown.less -->
<!--                <li>-->
<!--                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
<!--                </li>-->
            </ul>
        </div>
    </nav>
</header>
