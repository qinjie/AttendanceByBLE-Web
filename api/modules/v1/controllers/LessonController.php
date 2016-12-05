<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\components\CustomActiveController;
use common\components\AccessRule;
use common\models\Lesson;
use common\models\SemesterInfo;
use common\models\Student;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class LessonController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Lesson';

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => [],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [
                    'actions' => [],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => [],
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
            ],
        ];

        return $behaviors;
    }

    public function actionWeekOdd(){
        $student = Student::find()->where(['user_id' => Yii::$app->user->id])->one();
        $query = Lesson::find()->joinWith('venue')->joinWith('lecturers')->joinWith('student')->where(['timetable.student_id' => $student['id']])->andWhere('meeting_pattern = \'\' or meeting_pattern = \'ODD\'')->orderBy('lesson.weekday, lesson.start_time ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

    public function actionWeekEven(){
        $student = Student::find()->where(['user_id' => Yii::$app->user->id])->one();
        $query = Lesson::find()->joinWith('venue')->joinWith('lecturers')->joinWith('student')->where(['timetable.student_id' => $student['id']])->andWhere('meeting_pattern = \'\' or meeting_pattern = \'EVEN\'')->orderBy('lesson.weekday, lesson.start_time ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

    public function actionWeek(){
        $query = SemesterInfo::find()->andWhere('start_date <= \''.date('Y-m-d').'\' and end_date >= \''.('Y-m-d').'\'')->one();
        $interval = (new \DateTime($query['start_date']))->diff((new \DateTime(date('Y-m-d'))));
        $day = $interval->format('%a');
        $weeknum = ceil($day/7);
        return $weeknum;
    }
}