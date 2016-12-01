<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LessonLecturer;

/**
 * LessonLecturerSearch represents the model behind the search form about `common\models\LessonLecturer`.
 */
class LessonLecturerSearch extends LessonLecturer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lesson_id', 'lecturer_id'], 'integer'],
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
    public function search($params)
    {
        $query = LessonLecturer::find();

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
            'lecturer_id' => $this->lecturer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    public function searchRest($params, $today = false)
    {
        $query = LessonLecturer::find();
        $lecturer = Lecturer::find()->where(['user_id' => Yii::$app->user->id])->one();
        if ($lecturer && $today){
            $query = LessonLecturer::find()->where(['lecturer_id' => $lecturer['id']]);
            $query->join('LEFT JOIN', 'lesson', 'lesson.id = lesson_lecturer.lesson_id');
            $query->join('LEFT JOIN', 'lesson_date', 'lesson_date.lesson_id = lesson.id')->orderBy('lesson_date.ldate, lesson.start_time ASC');
            if ($today){
                $query->andWhere('lesson_date.ldate = \''.date('Y-m-d').'\'');
            }
        }
        else {
            if ($today){
                $query = LessonLecturer::find()->where('0=1');
            }
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
            'lecturer_id' => $this->lecturer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
