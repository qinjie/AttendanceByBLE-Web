<?php
namespace frontend\controllers;

use api\common\models\Timetable;
use common\components\AccessRule;
use common\models\Attendance;
use common\models\Lecturer;
use common\models\Student;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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
                        'actions' => ['signup', 'login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout', 'take-attendance', 'lesson', 'lesson-list', 'lesson-detail', 'lesson-today'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionConfirmationSuccess() {
        return $this->render('confirmationSuccess');
    }

    public function actionConfirmationError() {
        return $this->render('confirmationError');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $cmd = Yii::$app->db
            ->createCommand("select student_id, lesson_date.id, lesson_lecturer.lecturer_id from timetable INNER JOIN lesson_date on timetable.lesson_id = lesson_date.lesson_id
            INNER JOIN lesson on timetable.lesson_id = lesson.id
            INNER JOIN lesson_lecturer ON timetable.lesson_id = lesson_lecturer.lesson_id
            where start_time <= '".date('H:i:s')."' and end_time >= '".date('H:i:s')."'
            and ldate = '".date('Y-m-d')."' and lesson_lecturer.lecturer_id = (select id from lecturer where user_id = ".Yii::$app->user->id.")");
        $result = $cmd->queryAll();
        $lesson_date_id = 0;
        $lecturer_id = 0;
        $student_list_id = [];
        $student_list_name = [];
        if (count($result) > 0) {
            $lesson_date_id = $result[0]['id'];
            $lecturer_id = $result[0]['lecturer_id'];
            $count = -1;
            foreach ($result as $std){
                $count++;
                $student_list_id[$count] = $std['student_id'];
                $student = Student::find()->where(['id' => $std['student_id']])->one();
                if ($student){
                    $student_list_name[$count] = $student['name'];
                }
            }
        }
        $query_student = Attendance::find()->where(['lesson_date_id' => $lesson_date_id, 'status' => 0])->all();
        $attended_student = [];
        foreach ($query_student as $att){
            $attended_student[] = $att['student_id'];
        }
        return $this->render('index',[
            'lesson_date_id' => $lesson_date_id,
            'lecturer_id' => $lecturer_id,
            'student_list_id' => $student_list_id,
            'student_list_name' => $student_list_name,
            'attended_student' => $attended_student,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionLesson()
    {
        $searchModel = new \common\models\LessonLecturerSearch();
        $data = $searchModel->searchRest(Yii::$app->request->queryParams)->getModels();
        return $this->render('lesson', [
            'data' => $data,
        ]);
    }

    public function actionLessonList($id){
        $searchModel = new \common\models\LessonDateSearch();
        $list = $searchModel->search(Yii::$app->request->queryParams, $id)->getModels();
        return $this->render('lesson_list', [
            'list' => $list,
        ]);
    }

    public function actionLessonToday(){
        $searchModel = new \common\models\LessonLecturerSearch();
        $data = $searchModel->searchRest(Yii::$app->request->queryParams, true)->getModels();
        return $this->render('lesson_today', [
            'data' => $data,
        ]);
    }

    public function actionLessonDetail($id){
        $searchModel = new \common\models\TimetableSearch();
        $list = $searchModel->search(Yii::$app->request->queryParams, $id)->getModels();
        $lecturer = Lecturer::find()->where(['user_id' => Yii::$app->user->id])->one();
        return $this->render('lesson_detail', [
            'list' => $list,
            'lecturer_id' => $lecturer['id'],
            'lesson_date_id' => $id,
        ]);
    }

    public function actionTakeAttendance()
    {
        $student_list = $_POST['student_list'];
        $lesson_date_id = $_POST['lesson_date_id'];
        $recorded_time = date('H:i:s');
        $lecturer_id = $_POST['lecturer_id'];
        $list = $_POST['checkbox'];
        $retake = false;
        foreach ($student_list as $student){
            if (in_array($student, $list)){
                try{
                    $cmd = Yii::$app->db
                        ->createCommand("insert into attendance(student_id, lesson_date_id, recorded_time, lecturer_id, status) values (:student_id, :lesson_date_id, :recorded_time, :lecturer_id, 0)");
                    $cmd->bindValue(':student_id', $student);
                    $cmd->bindValue(':lesson_date_id', $lesson_date_id);
                    $cmd->bindValue(':recorded_time', $recorded_time);
                    $cmd->bindValue(':lecturer_id', $lecturer_id);
                    $rs2 = $cmd->query();
                }
                catch (Exception $ex){
                    $cmd = Yii::$app->db
                        ->createCommand("update attendance set status = 0 where student_id = :student_id and lesson_date_id = :lesson_date_id and lecturer_id = :lecturer_id");
                    $cmd->bindValue(':student_id', $student);
                    $cmd->bindValue(':lesson_date_id', $lesson_date_id);
                    $cmd->bindValue(':lecturer_id', $lecturer_id);
                    $rs2 = $cmd->query();
                    $retake = true;
                }
            }
            else{
                try{
                    $cmd = Yii::$app->db
                        ->createCommand("insert into attendance(student_id, lesson_date_id, recorded_time, lecturer_id, status) values (:student_id, :lesson_date_id, :recorded_time, :lecturer_id, -1)");
                    $cmd->bindValue(':student_id', $student);
                    $cmd->bindValue(':lesson_date_id', $lesson_date_id);
                    $cmd->bindValue(':recorded_time', $recorded_time);
                    $cmd->bindValue(':lecturer_id', $lecturer_id);
                    $rs2 = $cmd->query();
                }
                catch (Exception $ex){
                    $cmd = Yii::$app->db
                        ->createCommand("update attendance set status = -1 where student_id = :student_id and lesson_date_id = :lesson_date_id and lecturer_id = :lecturer_id");
                    $cmd->bindValue(':student_id', $student);
                    $cmd->bindValue(':lesson_date_id', $lesson_date_id);
                    $cmd->bindValue(':lecturer_id', $lecturer_id);
                    $rs2 = $cmd->query();
                    $retake = true;
                }
            }
        }
        if ($retake)
            return "Retaking successfully";
        else
            return "Attendace taking successfully";
    }
}
