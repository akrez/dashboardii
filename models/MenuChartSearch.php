<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MenuChart;

/**
 * MenuChartSearch represents the model behind the search form of `app\models\MenuChart`.
 */
class MenuChartSearch extends MenuChart
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'priority', 'menu_id', 'chart_width_12'], 'integer'],
            [['title', 'chart_aggregation', 'chart_axis_x', 'chart_where_like', 'chart_axis_y', 'chart_group_by', 'chart_type', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
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
    public function search($params, $parentModel)
    {
        $query = MenuChart::getMenuChartBaseFindQuery($parentModel->id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
            'pagination' => false,
        ]);

        // add conditions that should always apply here
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'priority' => $this->priority,
            'menu_id' => $this->menu_id,
            'chart_width_12' => $this->chart_width_12,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'chart_aggregation', $this->chart_aggregation])
            ->andFilterWhere(['like', 'chart_axis_x', $this->chart_axis_x])
            ->andFilterWhere(['like', 'chart_where_like', $this->chart_where_like])
            ->andFilterWhere(['like', 'chart_axis_y', $this->chart_axis_y])
            ->andFilterWhere(['like', 'chart_group_by', $this->chart_group_by])
            ->andFilterWhere(['like', 'chart_type', $this->chart_type]);

        return $dataProvider;
    }
}
