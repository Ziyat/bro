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
 * @property string $parentId
 * @property array $users
 */
class UsersGroupForm extends Model
{
    public $id;
    public $name;
    public $parentId;
    public $users;
    private $_group;

    public function __construct(UsersGroup $group = null,$config = [])
    {
        if($group){
            $this->name = $group->name;
            $this->parentId = $group->parent_id;
            $this->users = $group->users;
            $this->_group = $group;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['parentId'], 'integer'],
            ['parentId', 'exist', 'targetClass' => UsersGroup::class, 'targetAttribute' => 'id'],
            ['users', 'each', 'rule' => ['exist', 'targetClass' => User::class, 'targetAttribute' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'parentId' => 'Родитель'

        ];
    }


    public function parentList()
    {
        return ArrayHelper::map(UsersGroup::find()->all(),'id','name');
    }
}