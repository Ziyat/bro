<?php
namespace app\entities\user;

use app\entities\dubious\Dubious;
use app\helpers\user\UserHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $is_admin
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property UsersAssignment[] $groupAssignments
 * @property UsersGroup[] $groups
 * @property Dubious[] $dubious
 */
class User extends ActiveRecord implements IdentityInterface
{
    //use InstantiateTrait;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    public $slug;

    public static function create($name, $username, $password, $status = self::STATUS_ACTIVE)
    {
        $user = new static();
        $user->name = $name;
        $user->username = Inflector::slug($username);
        $user->setPassword($password);
        $user->status = $status;
        $user->generateAuthKey();
        return $user;
    }
    public function edit($name, $username, $password, $status)
    {
        $this->name = $name;
        $this->username = Inflector::slug($username);
        $this->setPassword($password);
        $this->status = $status;
    }

    public function setGroup($group_id)
    {
        $assignments = $this->groupAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForGroup($group_id)) {
                return;
            }
        }
        $assignments[] = UsersAssignment::create(null,$group_id);
        $this->groupAssignments = $assignments;
    }

    public function revokeGroups(): void
    {
        $this->groupAssignments = [];
    }

    public function attributeLabels()
    {
        return UserHelper::attributeLabels();
    }


    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('Text is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }
    public function deactivate()
    {
        if ($this->isDeactivate()) {
            throw new \DomainException('Text is already draft.');
        }
        $this->status = self::STATUS_INACTIVE;
    }
    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }
    public function isDeactivate(): bool
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    // group

    public function getGroupAssignments()
    {
        return $this->hasMany(UsersAssignment::class, ['user_id' => 'id']);
    }

    public function getGroups()
    {
        return $this->hasMany(UsersGroup::class, ['id' => 'group_id'])->via('groupAssignments');
    }


    public function getDubious(): ActiveQuery
    {
        return $this->hasMany(Dubious::class,['created_by' => 'id']);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['groupAssignments'],
            ],
        ];
    }


    public static function tableName()
    {
        return '{{%users}}';
    }


}
