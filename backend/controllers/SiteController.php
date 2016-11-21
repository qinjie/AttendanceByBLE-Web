<?php
namespace backend\controllers;

use common\components\AccessRule;
use common\models\User;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'take-attendance'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTakeAttendance()
    {
        $lesson_date_id = $_POST['lesson_date_id'];
        $recorded_time = date('H:i:s');
        $lecturer_id = $_POST['lecturer_id'];
        $list = $_POST['checkbox'];
        $retake = false;
        foreach ($list as $item){
            $cmd = Yii::$app->db
                ->createCommand("insert into attendance(student_id, lesson_date_id, recorded_time, lecturer_id, status) values (:student_id, :lesson_date_id, :recorded_time, :lecturer_id, 0)");
            $cmd->bindValue(':student_id', $item);
            $cmd->bindValue(':lesson_date_id', $lesson_date_id);
            $cmd->bindValue(':recorded_time', $recorded_time);
            $cmd->bindValue(':lecturer_id', $lecturer_id);
            try{
                $rs2 = $cmd->query();
            }
            catch (Exception $ex){
                $retake = true;
            }
        }
        if ($retake)
            return "Retaking successfully";
        else
            return "Attendace taking successfully";
    }
}
