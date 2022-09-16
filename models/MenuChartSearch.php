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
            [['id', 'menu_id', 'priority', 'chart_width_12'], 'integer'],
            [['chart_axis_y', 'chart_where_like', 'chart_axis_x', 'chart_aggregation', 'deleted_at', 'created_at', 'updated_at'], 'safe'],
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
        $query = MenuChart::find()
            ->andWhere(['menu_id' => $parentModel->id])
            ->andWhere(['deleted_at' => null]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'priority' => SORT_DESC,
                ]
            ],
            'pagination' => false,
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
            'menu_id' => $this->menu_id,
            'priority' => $this->priority,
            'chart_width_12' => $this->chart_width_12,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'chart_axis_y', $this->chart_axis_y])
            ->andFilterWhere(['like', 'chart_where_like', $this->chart_where_like])
            ->andFilterWhere(['like', 'chart_axis_x', $this->chart_axis_x])
            ->andFilterWhere(['like', 'chart_aggregation', $this->chart_aggregation]);

        return $dataProvider;
    }
}
