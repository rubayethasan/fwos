<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Eingabe;

/**
 * EingabeSearch represents the model behind the search form of `app\models\Eingabe`.
 */
class EingabeSearch extends Eingabe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','round'], 'integer'],
            [['x0', 'x1', 'x2', 'e2', 'e5', 'x31', 'x32', 'lk', 'kk', 'zpf', 'zpp', 'vpf', 'vpp'], 'number'],
            [['username'], 'safe']
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
        $query = Eingabe::find();

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
            'username' => $this->username,
            'round' => $this->round,
            'x0' => $this->x0,
            'x1' => $this->x1,
            'x2' => $this->x2,
            'e2' => $this->e2,
            'e5' => $this->e5,
            'x31' => $this->x31,
            'x32' => $this->x32,
            'q' => $this->q,
            'lk' => $this->lk,
            'kk' => $this->kk,
            'zpf' => $this->zpf,
            'zpp' => $this->zpp,
            'vpf' => $this->vpf,
            'vpp' => $this->vpp,
        ]);

        return $dataProvider;
    }
}
