<?php

namespace app\entities\dubious;

use app\entities\user\User;
use app\entities\user\UsersAssignment;
use app\entities\user\UsersGroup;
use app\helpers\dubious\DubiousHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\entities\dubious\Dubious;
use kartik\daterange\DateRangeBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * DubiousSearch represents the model behind the search form of `app\entities\dubious\Dubious`.
 */
class DubiousSearch extends Dubious
{
    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public $dateMsgTimeRange;
    public $dateMsgTimeStart;
    public $dateMsgTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ],
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'dateMsgTimeRange',
                'dateStartAttribute' => 'dateMsgTimeStart',
                'dateEndAttribute' => 'dateMsgTimeEnd',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'safe'],
            [[
                'date_msg',
                'date_doc',
                'doc_sum',
                'id_cli',
                'mfo_cli',
                'inn_cli',
                'account_cli',
                'name_cli',
                'mfo_cor',
                'inn_cor',
                'account_cor',
                'name_cor',
                'pop',
                'ans_per',
                'currency',
                'criterion'], 'safe'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['dateMsgTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (Yii::$app->user->identity->is_admin) {
            $query = Dubious::find()->orderBy(['id' => SORT_DESC]);
        } else {
            $query = Dubious::find()->where(['created_by' => DubiousHelper::getUsersInGroup(Yii::$app->user->identity, new UsersAssignment())]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if($this->dateMsgTimeStart && $this->dateMsgTimeEnd){
            $startDateMSg = Date('Y-m-d', $this->dateMsgTimeStart);
            $endDateMSg = Date('Y-m-d', $this->dateMsgTimeEnd);
            $query->andFilterWhere(['>=', "STR_TO_DATE(date_msg, '%m-%d-%y')", $startDateMSg]);
            $query->andFilterWhere(['<=', "STR_TO_DATE(date_msg, '%m-%d-%y')", $endDateMSg]);
        }

        $query->andFilterWhere(['>=', 'created_at', $this->createTimeStart])
            ->andFilterWhere(['<', 'created_at', $this->createTimeEnd]);


        $query->andFilterWhere(['like', 'id_cli', $this->id_cli])
            ->andFilterWhere(['like', 'mfo_cli', $this->mfo_cli])
            ->andFilterWhere(['like', 'inn_cli', $this->inn_cli])
            ->andFilterWhere(['like', 'account_cli', $this->account_cli])
            ->andFilterWhere(['like', 'name_cli', $this->name_cli])
            ->andFilterWhere(['like', 'mfo_cor', $this->mfo_cor])
            ->andFilterWhere(['like', 'inn_cor', $this->inn_cor])
            ->andFilterWhere(['like', 'account_cor', $this->account_cor])
            ->andFilterWhere(['like', 'name_cor', $this->name_cor])
//              ->andFilterWhere(['like', 'date_msg', $this->date_msg])
            ->andFilterWhere(['like', 'date_doc', $this->date_doc])
            ->andFilterWhere(['like', 'doc_sum', $this->doc_sum])
            ->andFilterWhere(['like', 'pop', $this->pop])
            ->andFilterWhere(['like', 'ans_per', $this->ans_per])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'criterion', $this->criterion]);


        return $dataProvider;
    }
}
