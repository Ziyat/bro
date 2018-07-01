<?php
namespace app\forms\user;


use app\entities\user\User;
use app\entities\user\UsersAssignment;
use app\entities\user\UsersGroup;
use Yii;
use yii\base\Model;
/**
 * UsersAssignmentForm
 *
 * @property integer $user_id
 * @property integer $group_id
 */
class UsersAssignmentForm extends Model
{
    public $user_id;
    public $group_id;

    public function __construct(UsersAssignment $assignment = null,$config = [])
    {
        if($assignment){
            $this->user_id = $assignment->user_id;
            $this->group_id = $assignment->group_id;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'required'],
            [['user_id', 'group_id'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsersGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    public function attributeLabels()
    {
        return UserHelpe::attributeLabels();
    }
}