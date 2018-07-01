<?php
namespace app\helpers\user;

use app\entities\user\User;
use app\entities\user\UsersGroup;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class UserHelper
{
    public static function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'username' => 'Логин',
            'password' => 'Пароль',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'status' => 'Статус',
            'user_id' => 'ID пользователя',
            'group_id' => 'ID группы',
        ];
    }

    public static function statusList(): array
    {
        return [
            User::STATUS_INACTIVE => 'Не активный',
            User::STATUS_ACTIVE => 'Активный',
        ];
    }
    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function groupList(): array
    {
        return ArrayHelper::map(UsersGroup::find()->all(),'id','name');
    }
    public static function usersList(): array
    {
        return ArrayHelper::map(User::find()->where(['is_admin' => 0])->all(),'id','name');
    }

    public static function getLinkAssignments($assignments,$controllerName): string
    {
        $usersLink = [];
        foreach ($assignments as $k => $item){
            $usersLink[$k] = Html::a($item->name,Url::to([$controllerName.'/view','id' => $item->id]));
        }
        $links = implode('<br/>',$usersLink);
        return $links ?: Html::a('Не определен',Url::to([$controllerName.'/index']));
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case User::STATUS_INACTIVE:
                $class = 'label label-default';
                break;
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}