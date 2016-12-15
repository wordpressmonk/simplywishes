<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Wish;

/**
 * SearchWish represents the model behind the search form about `app\models\Wish`.
 */
class SearchWish extends Wish
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['w_id', 'wished_by', 'granted_by', 'category', 'state', 'country', 'city'], 'integer'],
            [['wish_title', 'summary_title', 'wish_description', 'primary_image'], 'safe'],
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
        $query = Wish::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize'=>5
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'w_id' => $this->w_id,
            'wished_by' => $this->wished_by,
            'granted_by' => $this->granted_by,
            'category' => $this->category,
            'state' => $this->state,
            'country' => $this->country,
            'city' => $this->city,
        ]);

        $query->andFilterWhere(['like', 'wish_title', $this->wish_title])
            ->andFilterWhere(['like', 'summary_title', $this->summary_title])
            ->andFilterWhere(['like', 'wish_description', $this->wish_description])
            ->andFilterWhere(['like', 'primary_image', $this->primary_image]);

        return $dataProvider;
    }
}
