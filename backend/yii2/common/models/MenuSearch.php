<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MenuSearch represents the model behind the search form of `common\models\Menu`.
 */
class MenuSearch extends Menu
{
    private $limit;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['type', 'url', 'describe', 'status', 'menu_status', 'pid', 'limit'], 'safe'],
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
        $query = Menu::find()->where(['status' => [0, 1]]);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => $this->limit,
                ]
            ]
        );
        $this->setAttributes($params);
        $query->andFilterWhere(
            [
                'id' => $this->id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        );
        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'describe', $this->describe])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'menu_status', $this->menu_status])
            ->andFilterWhere(['like', 'pid', $this->pid]);
        return $dataProvider;
    }
}
