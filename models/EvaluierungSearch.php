<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Evaluierung;

/**
 * EvaluierungSearch represents the model behind the search form of `app\models\Evaluierung`.
 */
class EvaluierungSearch extends Evaluierung
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'round'], 'integer'],
            [['username','f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f9', 'f10', 'f11', 'f12', 'f13', 'XY1', 'XY2', 'XY3', 'XY4', 'XY5', 'XY6', 'XY7', 'XY8', 'XY9', 'XY10'], 'safe'],
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
        $query = Evaluierung::find();

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
            ->andFilterWhere(['like', 'f1', $this->f1])
            ->andFilterWhere(['like', 'f2', $this->f2])
            ->andFilterWhere(['like', 'f3', $this->f3])
            ->andFilterWhere(['like', 'f4', $this->f4])
            ->andFilterWhere(['like', 'f5', $this->f5])
            ->andFilterWhere(['like', 'f6', $this->f6])
            ->andFilterWhere(['like', 'f7', $this->f7])
            ->andFilterWhere(['like', 'f8', $this->f8])
            ->andFilterWhere(['like', 'f9', $this->f9])
            ->andFilterWhere(['like', 'f10', $this->f10])
            ->andFilterWhere(['like', 'f11', $this->f11])
            ->andFilterWhere(['like', 'f12', $this->f12])
            ->andFilterWhere(['like', 'f13', $this->f13])
            ->andFilterWhere(['like', 'XY1', $this->XY1])
            ->andFilterWhere(['like', 'XY2', $this->XY2])
            ->andFilterWhere(['like', 'XY3', $this->XY3])
            ->andFilterWhere(['like', 'XY4', $this->XY4])
            ->andFilterWhere(['like', 'XY5', $this->XY5])
            ->andFilterWhere(['like', 'XY6', $this->XY6])
            ->andFilterWhere(['like', 'XY7', $this->XY7])
            ->andFilterWhere(['like', 'XY8', $this->XY8])
            ->andFilterWhere(['like', 'XY9', $this->XY9])
            ->andFilterWhere(['like', 'XY10', $this->XY10]);

        return $dataProvider;
    }
}
