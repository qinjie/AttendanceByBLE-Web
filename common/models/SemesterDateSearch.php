<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SemesterDate;

/**
 * SemesterDateSearch represents the model behind the search form about `common\models\SemesterDate`.
 */
class SemesterDateSearch extends SemesterDate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'semester_id', 'week_num', 'weekday', 'is_holiday'], 'integer'],
            [['tdate', 'created_at', 'updated_at'], 'safe'],
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
        $query = SemesterDate::find();

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
            'semester_id' => $this->semester_id,
            'tdate' => $this->tdate,
            'week_num' => $this->week_num,
            'weekday' => $this->weekday,
            'is_holiday' => $this->is_holiday,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
