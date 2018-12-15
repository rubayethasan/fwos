<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Benutzer;

/**
 * BenutzerSearch represents the model behind the search form of `app\models\Benutzer`.
 */
class BenutzerSearch extends Benutzer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'semester','gruppe'], 'integer'],
            [['regel', 'name', 'vorname', 'geschlecht', 'email', 'studienfach', 'kenntnisse', 'username', 'password', 'rolle', 'status'], 'safe'],
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
        $query = Benutzer::find();

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
            'semester' => $this->semester,
            'gruppe' => $this->gruppe,
        ]);

        $query->andFilterWhere(['like', 'regel', $this->regel])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'vorname', $this->vorname])
            ->andFilterWhere(['like', 'geschlecht', $this->geschlecht])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'studienfach', $this->studienfach])
            ->andFilterWhere(['like', 'kenntnisse', $this->kenntnisse])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'rolle', $this->rolle])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
