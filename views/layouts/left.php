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
                        'icon' => 'warning',
                        'url' => ['/dubious'],
                    ],
                    [
                        'label' => 'Групповое удаление',
                        'icon' => 'check-square-o',
                        'url' => ['/dubious/group-remove'],
                    ],
                    [
                        'label' => 'Отчет для ЦБ',
                        'icon' => 'upload',
                        'url' => ['/export/central-bank'],
                        'visible' => Yii::$app->user->identity->is_admin,
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
