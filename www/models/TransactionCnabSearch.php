<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransactionCnab;

/**
 * TransactionCnabSearch represents the model behind the search form of `app\models\TransactionCnab`.
 */
class TransactionCnabSearch extends TransactionCnab
{

    public $Term;

    public function rules()
    {
        return [
            [['Code', 'FilesCnabCode', 'TransactionTypeCode'], 'integer'],
            [['DateOccurrence', 'Value', 'NationalRegister', 'Card', 'TimeOccurrence', 'NameStoreOwner', 'NameStore', 'Term'], 'safe'],
        ];
    }


    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = TransactionCnab::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        //ok
        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Code' => $this->Code,
            'FilesCnabCode' => $this->FilesCnabCode,
        ]);

        $query->andFilterWhere(['like', 'NameStore', $this->Term])
            ->orFilterWhere(['like', 'NameStoreOwner', $this->Term])
            ->orFilterWhere(['like', 'NationalRegister', $this->Term]);

        $query->orderBy(['Code' => SORT_DESC]);


        return $dataProvider;




    }
}