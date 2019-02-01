<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Letters;

/**
 * LettersSearch represents the model behind the search form of `app\models\Letters`.
 */
class LettersSearch extends Letters
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'contragent_id', 'status_id', 'level', 'direction'], 'integer'],
            [['title', 'number', 'registr', 'date', 'created', 'modified'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params, $direction = null, $level = null, $letters_arr = null)
    {
        $query = Letters::find();

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
           // 'id' => $this->id,
            'id' => $letters_arr,
            'date' => $this->date,
            'user_id' => $this->user_id,
            'contragent_id' => $this->contragent_id,
            'status_id' => $this->status_id,
            'level' => $level,
            'direction' => $direction,
            'created' => $this->created,
            'modified' => $this->modified,
            'users' => $this->users
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
       //     ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'number', $this->number])
                ->andFilterWhere(['like', 'registr', $this->registr]);

        return $dataProvider;
    }
}
