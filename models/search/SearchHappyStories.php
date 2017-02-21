<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HappyStories;

/**
 * SearchEditorial represents the model behind the search form about `app\models\HappyStories`.
 */
class SearchHappyStories extends HappyStories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hs_id', 'status','user_id','wish_id'], 'integer'],
            [['story_text', 'story_image', 'created_at'], 'safe'],
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
        $query = HappyStories::find()->orderBy('hs_id Desc');

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
            'hs_id' => $this->hs_id,
            'user_id' => $this->user_id,
            'hs_id' => $this->hs_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'story_text', $this->story_text])
            ->andFilterWhere(['like', 'story_image', $this->story_image]);

        return $dataProvider;
    }
}
