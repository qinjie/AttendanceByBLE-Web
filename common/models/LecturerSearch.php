<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Lecturer;

/**
 * LecturerSearch represents the model behind the search form about `common\models\Lecturer`.
 */
class LecturerSearch extends Lecturer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['card', 'name', 'acad', 'email', 'created_at', 'updated_at'], 'safe'],
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
        $query = Lecturer::find();

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
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'card', $this->card])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'acad', $this->acad])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

    public function searchRest($params)
    {
        $student = Student::find()->where(['user_id' => Yii::$app->user->id])->one();
        $query = Lecturer::find()->distinct('id');
        $query->joinWith('beacon');
        $query->join('JOIN', 'lesson_lecturer', 'lecturer.id = lesson_lecturer.lecturer_id');
        $query->join('JOIN', 'timetable', 'lesson_lecturer.lesson_id = timetable.lesson_id')->where(['timetable.student_id' => $student['id']]);

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
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'card', $this->card])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'acad', $this->acad])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
