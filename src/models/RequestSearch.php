<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class RequestSearch extends Request
{
    public function rules()
    {
        return [
            [['id', 'manager_id'], 'integer'],
            [['email', 'phone'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Request::find();
        $query->with(['manager']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'manager_id' => $this->manager_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
