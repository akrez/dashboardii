<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MenuContent;

/**
 * MenuContentSearch represents the model behind the search form of `app\models\MenuContent`.
 */
class MenuContentSearch extends MenuContent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'menu_id'], 'integer'],
            [['deleted_at', 'created_at', 'updated_at', 'column_a', 'column_b', 'column_c', 'column_d', 'column_e', 'column_f', 'column_g', 'column_h', 'column_i', 'column_j', 'column_k', 'column_l', 'column_m', 'column_n', 'column_o', 'column_p', 'column_q', 'column_r', 'column_s', 'column_t', 'column_u', 'column_v', 'column_w', 'column_x', 'column_y', 'column_z'], 'safe'],
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
        $query = MenuContent::getMenuContentBaseFindQuery($parentModel->id);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
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
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['like', 'column_a', $this->column_a])
            ->andFilterWhere(['like', 'column_b', $this->column_b])
            ->andFilterWhere(['like', 'column_c', $this->column_c])
            ->andFilterWhere(['like', 'column_d', $this->column_d])
            ->andFilterWhere(['like', 'column_e', $this->column_e])
            ->andFilterWhere(['like', 'column_f', $this->column_f])
            ->andFilterWhere(['like', 'column_g', $this->column_g])
            ->andFilterWhere(['like', 'column_h', $this->column_h])
            ->andFilterWhere(['like', 'column_i', $this->column_i])
            ->andFilterWhere(['like', 'column_j', $this->column_j])
            ->andFilterWhere(['like', 'column_k', $this->column_k])
            ->andFilterWhere(['like', 'column_l', $this->column_l])
            ->andFilterWhere(['like', 'column_m', $this->column_m])
            ->andFilterWhere(['like', 'column_n', $this->column_n])
            ->andFilterWhere(['like', 'column_o', $this->column_o])
            ->andFilterWhere(['like', 'column_p', $this->column_p])
            ->andFilterWhere(['like', 'column_q', $this->column_q])
            ->andFilterWhere(['like', 'column_r', $this->column_r])
            ->andFilterWhere(['like', 'column_s', $this->column_s])
            ->andFilterWhere(['like', 'column_t', $this->column_t])
            ->andFilterWhere(['like', 'column_u', $this->column_u])
            ->andFilterWhere(['like', 'column_v', $this->column_v])
            ->andFilterWhere(['like', 'column_w', $this->column_w])
            ->andFilterWhere(['like', 'column_x', $this->column_x])
            ->andFilterWhere(['like', 'column_y', $this->column_y])
            ->andFilterWhere(['like', 'column_z', $this->column_z]);

        return $dataProvider;
    }
}
