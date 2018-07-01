<?php
namespace app\forms\user;


use app\helpers\user\UserHelper;
use app\entities\user\User;
use yii\base\Model;
use Yii;

/**
 * UserForm
 *
 * @property string $username
 * @property string $name
 * @property string $password
 * @property integer $status
 * @property integer $is_admin
 */
class UserForm extends Model
{
    public $name;
    public $username;
    public $password;
    public $status;
    public $is_admin;
    private $_user;

    public function __construct(User $user = null,$config = [])
    {
        if($user){
            $this->name = $user->name;
            $this->username = $user->username;
            $this->is_admin = $user->is_admin;
            $this->password = '';
            $this->status = $user->status;
            $this->_user = $user;
        }else{
            $this->_user = new User();
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE]],
            [['name','username','password'], 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            [['name','username'], 'string', 'min' => 3, 'max' => 255],
            ['username', 'unique', 'targetClass' => '\app\entities\user\User', 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'Такой логин уже существует'],
            ['password', 'string', 'min' => 6, 'max' => 30],
        ];
    }
    public function attributeLabels()
    {
        return UserHelper::attributeLabels();
    }
}