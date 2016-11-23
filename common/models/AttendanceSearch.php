<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Attendance;

/**
 * AttendanceSearch represents the model behind the search form about `common\models\Attendance`.
 */
class AttendanceSearch extends Attendance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'lesson_date_id', 'status', 'lecturer_id'], 'integer'],
            [['recorded_time', 'created_at', 'updated_at'], 'safe'],
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
        $query = Attendance::find();

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
            'student_id' => $this->student_id,
            'lesson_date_id' => $this->lesson_date_id,
            'recorded_time' => $this->recorded_time,
            'late_min' => $this->status,
            'lecturer_id' => $this->lecturer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    public function searchRest($params)
    {
        $student_id = Student::find()->select('id')->where(['user_id' => Yii::$app->user->id]);
        $query = Attendance::find()->where(['student_id' => $student_id]);
        $query->joinWith('lecturer');
        $query->join('LEFT JOIN', 'lesson_date', 'lesson_date.id = attendance.lesson_date_id');
        $query->join('LEFT JOIN', 'lesson', 'lesson_date.lesson_id = lesson.id')->orderBy('lesson_date.ldate, lesson.start_time ASC');

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
            'student_id' => $this->student_id,
            'lesson_date_id' => $this->lesson_date_id,
            'recorded_time' => $this->recorded_time,
            'late_min' => $this->status,
            'lecturer_id' => $this->lecturer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
