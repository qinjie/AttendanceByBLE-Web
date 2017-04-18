<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\models\Lecturer;
use api\common\models\Lesson;
use api\common\models\LessonDate;
use api\common\models\Timetable;
use api\components\CustomActiveController;
use common\components\AccessRule;
use common\models\Attendance;
use common\models\BeaconAttendanceLecturer;
use common\models\BeaconAttendanceStudent;
use common\models\Student;
use common\models\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use Yii;

class BeaconAttendanceStudentController extends CustomActiveController
{
    public $modelClass = 'api\common\models\BeaconAttendanceStudent';

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

    public function actionStudentList(){
        $params = Yii::$app->request->post();
        $params = $params['data'];
        $student_id = $params[0]['student_id_1'];
        $lesson_date_id = $params[0]['lesson_date_id'];
        try {
            Yii::$app->db->createCommand()->batchInsert(BeaconAttendanceStudent::tableName(), ['lesson_date_id','status','student_id_1', 'student_id_2'], $params)->execute();
        } catch (Exception $ex){
            throw new BadRequestHttpException("Database Error", 1);
        }
        $count = BeaconAttendanceStudent::find()->where(['lesson_date_id' => $lesson_date_id, 'student_id_1' => $student_id])->count();
        $lecturer = BeaconAttendanceLecturer::find()->where(['lesson_date_id' => $lesson_date_id, 'student_id' => $student_id])->one();
        $lecturer_id = $lecturer['lecturer_id'];
//        if ($count > 1 && $lecturer_id){
//            $result2 = Yii::$app->db->createCommand()
//                ->insert('attendance', ['student_id' => $student_id, 'lesson_date_id' => $lesson_date_id, 'recorded_time' => date('H:i:s'), 'lecturer_id' => $lecturer_id, 'status' => 0])->execute();
//            if ($result2 == 1){
//                return "Attendance taking successfully";
//            }
//            else{
//                return "Server Error";
//            }
//        }
//        else{
//            if ($count > 1){
//                return "Wating for lecturer verification";
//            }
//            if ($lecturer_id){
//                return "Wating for student verification";
//            }
//        }
        if ($count > 1 ){
            $result2 = Yii::$app->db->createCommand()
                ->insert('attendance', ['student_id' => $student_id, 'lesson_date_id' => $lesson_date_id, 'recorded_time' => date('H:i:s'), 'lecturer_id' => $lecturer_id, 'status' => 0])->execute();
            if ($result2 == 1){
                return "Attendance taking successfully";
            }
            else{
                return "Server Error";
            }
        }
//        else{
//            if ($count > 1){
//                return "Wating for lecturer verification";
//            }
//            if ($lecturer_id){
//                return "Wating for student verification";
//            }
//        }
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
            $student_id_1 = $value['student_id_1'];
            $student_id_2 = $value['student_id_2'];
            $status = $this->getStatus($lesson_date_id);
            $student_id = $student_id_1;
            $lesson_date = $lesson_date_id;
            $l_date = LessonDate::findOne($lesson_date_id);
//            $lesson = Lesson::findOne($l_date->lesson_id);
//            return $status;
            if (!$this->checkTimetable($lesson_date_id, $student_id)) return "Cannot take attendance for this lesson";
            if (!$this->checkDate($lesson_date_id)) return "Cannot take attendance for today";
            if ($status < 0) return "Cannot take attendance for this time";
            $student_status = $status;
            $student = Student::findOne(['id'=>$student_id_1]);
            if (empty($student)) return "Student not found";
            $user = Yii::$app->getUser()->identity;
            if ($user->status != User::STATUS_ACTIVE) return "Waiting for active device";
            $data1 = BeaconAttendanceStudent::find()->where(['lesson_date_id' => $lesson_date_id, 'student_id_1' => $student_id_1, 'student_id_2' => $student_id_2])->all();
            if (empty($data1)) {
                $attendance = new BeaconAttendanceStudent();
                $attendance->lesson_date_id = $lesson_date_id;
                $attendance->student_id_1 = $student_id_1;
                $attendance->student_id_2 = $student_id_2;
                $attendance->status = $status;
                $attendance->save();
//                $a[] = $attendance;
            }
            $att = Attendance::find()->where(['student_id' => $student_id_2, 'lesson_date_id' => $lesson_date_id])->all();
            if (empty($atte)){
                $tmp = new Attendance();
                $tmp->lesson_date_id = $lesson_date_id;
                $tmp->student_id = $student_id_2;
                $tmp->recorded_time = date('H:i:s');
                $tmp->status = $status;
                $tmp->save();
            }

        }
//        RETURN $a;
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

    public function getStatus($lesson_date_id){
        $lesson_date = LessonDate::findOne($lesson_date_id);
        $lesson = Lesson::findOne($lesson_date->lesson_id);
        $start_time = $lesson->start_time;
        $end_time = $lesson->end_time;
        $current_time = date("H:i:s");
        if($current_time > $end_time) return -1;
//        return $current_time;
        $interval = (strtotime($current_time)-strtotime($start_time));
        if ($interval >= 0 && $interval <= Yii::$app->params['ATTENDANCE_INTERVAL']) return 0;
        return $interval-Yii::$app->params['ATTENDANCE_INTERVAL'];
    }


//    public function afterAction($action, $result)
//    {
//        if ($action->id == 'create'){
//            $count = BeaconAttendanceStudent::find()->where(['lesson_date_id' => $result['lesson_date_id'], 'student_id_1' => $result['student_id_1']])->count();
//            $lecturer = BeaconAttendanceLecturer::find()->where(['lesson_date_id' => $result['lesson_date_id'], 'student_id' => $result['student_id_1']])->one();
//            $lecturer_id = $lecturer['lecturer_id'];
//            if ($count > 1 && $lecturer_id){
//                $result2 = Yii::$app->db->createCommand()
//                    ->insert('attendance', ['student_id' => $result['student_id_1'], 'lesson_date_id' => $result['lesson_date_id'], 'recorded_time' => date('H:i:s'), 'lecturer_id' => $lecturer_id, 'status' => 0])->execute();
//                if ($result2 == 1){
//                    return "Attendance taking successfully";
//                }
//                else{
//                    return "Server Error";
//                }
//            }
//            else{
//                if ($count > 1){
//                    return "Wating for lecturer verification";
//                }
//                if ($lecturer_id){
//                    return "Wating for student verification";
//                }
//            }
//        }
//        else{
//            return $result;
//        }
//    }

}
