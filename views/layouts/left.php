<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/favicons/android-chrome-192x192.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->
        <div class="sidebar-form">
            <?= \yii\helpers\Html::a('<i class="fa fa-upload"></i> Импорт',['dubious/import'],['class'=> 'btn btn-flat btn-block btn-success']) ?>
        </div>
<!--        <div class="sidebar-form">-->
<!--            --><?//= \yii\helpers\Html::a('<i class="fa fa-download"></i> Экспорт',['dubious/export'],['class'=> 'btn btn-flat btn-block btn-success']) ?>
<!--        </div>-->
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Упр. пользователями',
                        'icon' => 'gear',
                        'url' => '#',
                        'visible' => Yii::$app->user->identity->is_admin,
                        'items' => [
                            [
                                'label' => 'Пользователи',
                                'icon' => 'user-plus',
                                'url' => ['/users'],
                            ],
                            [
                                'label' => 'Группы',
                                'icon' => 'users',
                                'url' => ['/users-group'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Сомнительные',
                        'icon' => 'file-text',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Добавленные',
                                'icon' => 'download',
                                'url' => ['/dubious'],
                            ],
                            [
                                'label' => 'Групповое удаление',
                                'icon' => 'check-square-o',
                                'url' => ['/dubious/group-remove'],
                            ],
                        ],
                    ],
//                    ['label' => 'Excel Шаблоны', 'icon' => 'file-excel-o', 'url' => ['/excel-templates']],
//                    [
//                        'label' => 'Some tools',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
