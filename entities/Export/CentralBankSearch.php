<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace app\entities\Export;


use app\entities\dubious\Dubious;
use app\entities\user\UsersGroup;
use app\helpers\dubious\DubiousHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class CentralBankSearch extends Dubious
{
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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

        $dataProvider = new ActiveDataProvider([
            'query' => Dubious::find()->select(['created_by','users.name'])->distinct('created_by')->joinWith('user'),
            'sort'=>['defaultOrder' => ['date_msg' => SORT_DESC]],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}