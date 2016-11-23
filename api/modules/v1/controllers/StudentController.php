<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use common\models\Attendance;
use api\components\CustomActiveController;
use common\components\AccessRule;
use common\models\Lesson;
use common\models\LessonDate;
use common\models\Student;
use common\models\Timetable;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class StudentController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Student';

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

    public function actionCurrentLesson(){
        $searchModel = new \common\models\StudentSearch();
        $dataProvider = $searchModel->searchRest(Yii::$app->request->queryParams);
        return $dataProvider;
    }

    public function actionHistory(){
        $student = Student::find()->where(['user_id' => Yii::$app->user->id])->one();
        $query = Timetable::find()->distinct('lesson_id')->where(['student_id' => $student['id']])->all();
        $count = -1;
        $list = array();
        foreach ($query as $item){
            $count++;
            $lesson = Lesson::find()->where(['id' => $item['lesson_id']])->one();
            $lesson_name = $lesson['catalog_number'];
            $total = LessonDate::find()->where(['lesson_id' => $item['lesson_id']])->count();
            $presented = Attendance::find()->joinWith('lesson_date')->where(['attendance.student_id' => $student['id'], 'lesson_date.lesson_id' => $item['lesson_id'], 'attendance.status' => 0])->count();
            $absented = Attendance::find()->joinWith('lesson_date')->where(['attendance.student_id' => $student['id'], 'lesson_date.lesson_id' => $item['lesson_id'], 'attendance.status' => -1])->count();
            $list[$count]['lesson_name'] = $lesson_name;
            $list[$count]['total'] = $total;
            $list[$count]['presented'] = $presented;
            $list[$count]['absented'] = $absented;
        }
        $count = -1;
        $result = [];
        for ($i = 0; $i < count($list); $i++){
            $name = $list[$i]['lesson_name'];
            $exist = false;
            for ($j = 0; $j < $i; $j++){
                if ($list[$j]['lesson_name'] == $name){
                    $exist = true;
                }
            }
            if ($exist == false){
                $count++;
                $total = 0;
                $absented = 0;
                $presented = 0;
                for ($h = $i; $h < count($list); $h++){
                    if ($list[$h]['lesson_name'] == $name){
                        $total += $list[$h]['total'];
                        $absented += $list[$h]['absented'];
                        $presented += $list[$h]['presented'];
                    }
                }
                $result[$count]['lesson_name'] = $name;
                $result[$count]['total'] = $total;
                $result[$count]['absented'] = $absented;
                $result[$count]['presented'] = $presented;
            }
        }
        return $result;
    }
}