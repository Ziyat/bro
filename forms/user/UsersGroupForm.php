<?php
namespace app\forms\user;


use app\entities\user\User;
use app\entities\user\UsersAssignment;
use app\entities\user\UsersGroup;
use app\helpers\user\UserHelper;
use elisdn\compositeForm\CompositeForm;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * UsersGroupForm
 *
 * @property string $id
 * @property string $name
 * @property string $users
 */
class UsersGroupForm extends Model
{
    public $id;
    public $name;
    public $users;
    private $_group;

    public function __construct(UsersGroup $group = null,$config = [])
    {
        if($group){
            $this->name = $group->name;
            $this->users = ArrayHelper::getColumn(UsersAssignment::findAll(['group_id' => $group->id]),'user_id');
            $this->_group = $group;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['users', 'each', 'rule' => ['required']],
            //['users', 'each', 'rule' => ['exist', 'targetClass' => UsersAssignment::className(), 'targetAttribute' => 'user_id']],
        ];
    }

    public function attributeLabels()
    {
        return UserHelper::attributeLabels();
    }
}