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
use common\models\Attendance;
use common\models\BeaconAttendanceLecturer;
use common\models\BeaconAttendanceStudent;
use common\models\Lesson;
use common\models\LessonDate;
use common\models\Student;
use common\models\Timetable;
use common\models\User;
use yii\base\Exception;
use yii\base\UserException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class BeaconAttendanceLecturerController extends CustomActiveController
{
    public $modelClass = 'api\common\models\BeaconAttendanceLecturer';

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
    public function afterAction($action, $result)
    {
        if ($action->id == 'create'){
            $count = BeaconAttendanceStudent::find()->where(['lesson_date_id' => $result['lesson_date_id'], 'student_id_1' => $result['student_id']])->count();
            $lecturer = BeaconAttendanceLecturer::find()->where(['lesson_date_id' => $result['lesson_date_id'], 'student_id' => $result['student_id']])->one();
            $lecturer_id = $lecturer['lecturer_id'];
            if ($count > 1 && $lecturer_id){
                $result2 = Yii::$app->db->createCommand()
                    ->insert('attendance', ['student_id' => $result['student_id'], 'lesson_date_id' => $result['lesson_date_id'], 'recorded_time' => date('H:i:s'), 'lecturer_id' => $lecturer_id, 'status' => 0])->execute();
                if ($result2 == 1){
                    return "Attendance taking successfully";
                }
                else{
                    return "Server Error";
                }
            }
            else{
                if ($count > 1){
                    return "Wating for lecturer verification";
                }
                if ($lecturer_id){
                    return "Wating for student verification";
                }
            }
        }
        else{
            return $result;
        }
        return $result;
    }

    public function actionStudentAttendance(){
        $params = Yii::$app->request->post();
        $params = $params['data'];
        $student_id = 0;
        $student_status = 0;
        $lesson_date = 0;
        $a = [];
        foreach ($params as $value){
            $lesson_date_id = $value['lesson_date_id'];
            $student_id = $value['student_id'];
            $lecturer_id = $value['lecturer_id'];
            $status = $this->getStatus($lesson_date_id);
            $lesson_date = $lesson_date_id;
            $l_date = LessonDate::findOne($lesson_date_id);
            if (!$this->checkTimetable($lesson_date_id, $student_id)) return "Cannot take attendance for this lesson";
            if (!$this->checkDate($lesson_date_id)) return "Cannot take attendance for today";
            if ($status < 0) return "Cannot take attendance for this time";
            $student_status = $status;
            $student = Student::findOne(['id'=>$student_id]);
            if (empty($student)) return "Student not found";
            $user = Yii::$app->getUser()->identity;
            if ($user->status != User::STATUS_ACTIVE) return "Waiting for active device";
            $data1 = BeaconAttendanceLecturer::find()->where(['lesson_date_id' => $lesson_date_id, 'student_id' => $student_id, 'lecturer_id' => $lecturer_id])->all();
            if (empty($data1)) {
                $attendance = new BeaconAttendanceLecturer();
                $attendance->lesson_date_id = $lesson_date_id;
                $attendance->student_id = $student_id;
                $attendance->lecturer_id = $lecturer_id;
                $attendance->status = $status;
                $attendance->save();
            }
            $atte = Attendance::find()->where(['student_id' => $student_id, 'lesson_date_id' => $lesson_date_id])->all();
            if (empty($atte)){
                $tmp = new Attendance();
                $tmp->lesson_date_id = $lesson_date_id;
                $tmp->student_id = $student_id;
                $tmp->lecturer_id=$lecturer_id;
                $tmp->recorded_time = date('H:i:s');
                $tmp->status = $status;
                $tmp->save();
            }

        }
        $attendance = Attendance::find()->where(['student_id' => $student_id, 'lesson_date_id' => $lesson_date])->all();
        if (empty($attendance)){
            $tmp = new Attendance();
            $tmp->lesson_date_id = $lesson_date;
            $tmp->student_id = $student_id;
            $tmp->recorded_time = date('H:i:s');
            $tmp->status = $student_status;
            $tmp->save();
        }
        if ($student_status > 0) return ("Late: ". $student_status . " seconds");
        return "Attendance taking successfully";
    }

    public function getStatus($lesson_date_id){
        $lesson_date = LessonDate::findOne($lesson_date_id);
        $lesson = Lesson::findOne($lesson_date->lesson_id);
        $start_time = $lesson->start_time;
        $end_time = $lesson->end_time;
        $current_time = date("H:i:s");
        if($current_time > $end_time) return -1;
        $interval = (strtotime($current_time)-strtotime($start_time));
        if ($interval >= 0 && $interval <= Yii::$app->params['ATTENDANCE_INTERVAL']) return 0;
        return $interval-Yii::$app->params['ATTENDANCE_INTERVAL'];
    }

    public function checkTimetable($lesson_date_id, $student_id){
        $lesson_date = LessonDate::findOne($lesson_date_id);
        $lesson_id = $lesson_date->lesson_id;
        $timetable = Timetable::find()->where(['lesson_id' => $lesson_id, 'student_id' => $student_id])->all();
        return (!empty($timetable));
    }

    public function checkDate($lesson_date_id){
        $lesson_date = LessonDate::findOne($lesson_date_id)->ldate;
        $current_date = date("Y-m-d");
        return ($current_date == $lesson_date);

    }
}