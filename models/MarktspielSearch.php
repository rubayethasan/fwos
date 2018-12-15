<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Marktspiel;

/**
 * MarktspielSearch represents the model behind the search form of `app\models\Marktspiel`.
 */
class MarktspielSearch extends Marktspiel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','round','variante'], 'integer'],
            [['input'], 'number'],
            [['VK1', 'VK2', 'VK3', 'VK4', 'VK5', 'VK6', 'VK7', 'VK8', 'VK9', 'VK10', 'VK11', 'VK12', 'VK13', 'VK14', 'VK15', 'VK16', 'VK17','username'], 'safe'],
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
        $query = Marktspiel::find();

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
            'round' => $this->round,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'VK1', $this->VK1])
            ->andFilterWhere(['like', 'VK2', $this->VK2])
            ->andFilterWhere(['like', 'VK3', $this->VK3])
            ->andFilterWhere(['like', 'VK4', $this->VK4])
            ->andFilterWhere(['like', 'VK5', $this->VK5])
            ->andFilterWhere(['like', 'VK6', $this->VK6])
            ->andFilterWhere(['like', 'VK7', $this->VK7])
            ->andFilterWhere(['like', 'VK8', $this->VK8])
            ->andFilterWhere(['like', 'VK9', $this->VK9])
            ->andFilterWhere(['like', 'VK10', $this->VK10])
            ->andFilterWhere(['like', 'VK11', $this->VK11])
            ->andFilterWhere(['like', 'VK12', $this->VK12])
            ->andFilterWhere(['like', 'VK13', $this->VK13])
            ->andFilterWhere(['like', 'VK14', $this->VK14])
            ->andFilterWhere(['like', 'VK15', $this->VK15])
            ->andFilterWhere(['like', 'VK16', $this->VK16])
            ->andFilterWhere(['like', 'VK17', $this->VK17]);

        return $dataProvider;
    }
}
