<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\models\Lecturer;
use api\components\CustomActiveController;
use common\components\AccessRule;
use common\models\BeaconAttendanceLecturer;
use common\models\BeaconAttendanceStudent;
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
            Yii::$app->db->createCommand()->batchInsert(BeaconAttendanceStudent::tableName(), ['lesson_date_id', 'student_id_1', 'student_id_2', 'status'], $params)->execute();
        } catch (Exception $ex){
            throw new BadRequestHttpException("Database Error", 1);
        }
        $count = BeaconAttendanceStudent::find()->where(['lesson_date_id' => $lesson_date_id, 'student_id_1' => $student_id])->count();
        $lecturer = BeaconAttendanceLecturer::find()->where(['lesson_date_id' => $lesson_date_id, 'student_id' => $student_id])->one();
        $lecturer_id = $lecturer['lecturer_id'];
        if ($count > 1 && $lecturer_id){
            $result2 = Yii::$app->db->createCommand()
                ->insert('attendance', ['student_id' => $student_id, 'lesson_date_id' => $lesson_date_id, 'recorded_time' => date('H:i:s'), 'lecturer_id' => $lecturer_id, 'status' => 0])->execute();
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