<?php

namespace app\entities\dubious;

use app\entities\user\UsersAssignment;
use app\helpers\dubious\DubiousHelper;
use kartik\daterange\DateRangeBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

/**
 * DubiousSearch represents the model behind the search form of `app\entities\dubious\Dubious`.
 */
class DubiousSearch extends Dubious
{
    public $dateDocRange;
    public $dateDocStart;
    public $dateDocEnd;

    public $dateMsgRange;
    public $dateMsgStart;
    public $dateMsgEnd;

    public $sumStart;
    public $sumEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'dateDocRange',
                'dateStartAttribute' => 'dateDocStart',
                'dateEndAttribute' => 'dateDocEnd',
            ],
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'dateMsgRange',
                'dateStartAttribute' => 'dateMsgStart',
                'dateEndAttribute' => 'dateMsgEnd',
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
                'sumStart',
                'sumEnd',
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
            [['dateDocRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['dateMsgRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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
            $query = Dubious::find();
        } else {
            $query = Dubious::find()->where(['created_by' => DubiousHelper::getUsersInGroup(Yii::$app->user->identity,true)]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder' => ['date_msg' => SORT_DESC]],
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

        $query->andFilterWhere(['like', 'id_cli', $this->id_cli])
            ->andFilterWhere(['like', 'mfo_cli', $this->mfo_cli])
            ->andFilterWhere(['like', 'inn_cli', $this->inn_cli])
            ->andFilterWhere(['like', 'account_cli', $this->account_cli])
            ->andFilterWhere(['like', 'name_cli', $this->name_cli])
            ->andFilterWhere(['like', 'mfo_cor', $this->mfo_cor])
            ->andFilterWhere(['like', 'inn_cor', $this->inn_cor])
            ->andFilterWhere(['like', 'account_cor', $this->account_cor])
            ->andFilterWhere(['like', 'name_cor', $this->name_cor])
            ->andFilterWhere(['like', 'pop', $this->pop])
            ->andFilterWhere(['like', 'ans_per', $this->ans_per])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'criterion', $this->criterion]);

        $query->andFilterWhere(['>=', 'doc_sum',$this->sumStart])
            ->andFilterWhere(['<', 'doc_sum', $this->sumEnd]);


        $query->andFilterWhere(['>=', 'date_doc', $this->dateDocStart])
            ->andFilterWhere(['<', 'date_doc', $this->dateDocEnd]);

        $query->andFilterWhere(['>=', 'date_msg', $this->dateMsgStart])
            ->andFilterWhere(['<', 'date_msg', $this->dateMsgEnd]);

        return $dataProvider;
    }
}
