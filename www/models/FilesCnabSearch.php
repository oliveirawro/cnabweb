<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FilesCnab;


class FilesCnabSearch extends FilesCnab
{

    public $Term;

    public function rules()
    {
        return [
            [['Code', 'UserCode'], 'integer'],
            [['DateTimeLoaded', 'FileName', 'Status', 'Amount', 'Parsed', 'Term'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = FilesCnab::find();


        /*********** search ***********/
        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize],
            'sort'=> ['defaultOrder' => ['Code' => SORT_DESC]],
        ]);



        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Code' => $this->Code,
            'UserCode' => $this->UserCode,
        ]);


        $query->orFilterWhere(['like', 'FileName', $this->Term]);

        return $dataProvider;


    }
}
