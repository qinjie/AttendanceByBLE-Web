<?php

namespace common\models;

use common\components\Util;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Timetable;

/**
 * TimetableSearch represents the model behind the search form about `common\models\Timetable`.
 */
class TimetableSearch extends Timetable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lesson_id', 'student_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
    public function search($params, $lesson_date_id = null)
    {
        $query = Timetable::find();
        if ($lesson_date_id){
            $query->joinWith('lesson_date')->where('lesson_date.id = '.$lesson_date_id);
        }

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
            'lesson_id' => $this->lesson_id,
            'student_id' => $this->student_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    public function searchRest($params)
    {
        $student = Student::find()->where(['user_id' => Yii::$app->user->id])->one();
        $query = Timetable::find()->where(['student_id' => $student['id']]);
        $query->join('LEFT JOIN', 'lesson', 'lesson.id = timetable.lesson_id');
        $query->join('LEFT JOIN', 'lesson_date', 'lesson.id = lesson_date.lesson_id')->orderBy('lesson_date.ldate, lesson.start_time ASC');
        $query->where(['lesson.semester' => Util::getCurrentSemester()]);
        $query->andWhere(['>=', 'ldate', date('Y-m-d', strtotime('monday this week'))])->andWhere(['<=', 'ldate', date('Y-m-d', strtotime('sunday this week'))]);
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
            'lesson_id' => $this->lesson_id,
            'student_id' => $this->student_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
