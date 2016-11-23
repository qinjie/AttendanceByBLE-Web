<?php

/* @var $this yii\web\View */

?>
<div class="site-index">
    <div class="jumbotron">
        <h1 style="margin: 0px 0px 0px 0px;">Current Attendace </h1>
    </div>
</div>

<?php
//$begin = new DateTime('2016-09-05');
//$end = new DateTime('2016-12-30');
//$beforeDate = new DateTime('2016-09-04');
//
//$interval = DateInterval::createFromDateString('1 day');
//$period = new DatePeriod($begin, $interval, $end);
//foreach ( $period as $dt ){
//    $today = $dt;//->format( "Y-m-d" );
//    $tdate = $dt->format( "Y-m-d" );
//    $interval = $beforeDate->diff($today);
//    $day = $interval->format('%a');
//    $weeknum = ceil($day/7);
//    $weekday = $day%7 + 1;
//    if ($weekday == 1) $weekday = 8;
//    $is_holiday = false;
//    $cmd = Yii::$app->db
//        ->createCommand("select hdate from  public_holiday where hdate = :tdate");
//    $cmd->bindValue(':tdate', $tdate);
//    $result = $cmd->query();
//    if (count($result) > 0){
//        $is_holiday = true;
//    }
//    $cmd = Yii::$app->db
//        ->createCommand("insert into semester_date(semester_id, tdate, week_num, weekday, is_holiday) values (1, :tdate, :weeknum, :weekday, :is_holiday)");
//    $cmd->bindValue(':tdate', $tdate);
//    $cmd->bindValue(':weeknum', $weeknum);
//    $cmd->bindValue(':weekday', $weekday);
//    $cmd->bindValue(':is_holiday', $is_holiday);
//    $result = $cmd->query();
//}
//
//$cmd = Yii::$app->db
//    ->createCommand("select tdate, week_num, weekday from semester_date where is_holiday = 0");
//$result = $cmd->queryAll();
//foreach ($result as $td){
//    $ldate = $td['tdate'];
//    $week_num = $td['week_num'];
//    $weekday = $td['weekday'];
//
//    $cmd = Yii::$app->db
//        ->createCommand("select id from lesson where weekday = :weekday");
//    $cmd->bindValue(':weekday', $weekday);
//    $lesson = $cmd->queryAll();
//
//    foreach ($lesson as $ls){
//        $lesson_id = $ls['id'];
//        $cmd = Yii::$app->db
//            ->createCommand("insert into lesson_date(lesson_id, ldate, updated_by) values (:lession_id, :ldate, 1)");
//        $cmd->bindValue(':lession_id', $lesson_id);
//        $cmd->bindValue(':ldate', $ldate);
//        $result = $cmd->query();
//    }
//}
?>

<?php
//    $cmd = Yii::$app->db
//        ->createCommand("select id from lesson ORDER BY id ASC");
//    $result = $cmd->queryAll();
//    foreach ($result as $td){
//        $id = (int)$td['id'];
//        $add = $td['id'];
//        if ($id < 10){
//            $add = "23A01AF0-232A-4518-9C0E-323FB773000".$id;
//        }
//        else{
//            if ($id < 100){
//                $add = "23A01AF0-232A-4518-9C0E-323FB77300".$id;
//            }
//            else{
//                if ($id < 1000){
//                    $add = "23A01AF0-232A-4518-9C0E-323FB7730".$id;
//                }
//            }
//        }
//        $cmd = Yii::$app->db
//            ->createCommand("insert into beacon_lesson(lesson_id, uuid) values (:lesson_id, :uuid)");
//        $cmd->bindValue(':lesson_id', $id);
//        $cmd->bindValue(':uuid', $add);
//        $result = $cmd->query();
//    }
?>

<?php
//    $cmd = Yii::$app->db
//        ->createCommand("select user_id from lecturer WHERE user_id is not null ORDER BY user_id ASC");
//    $result = $cmd->queryAll();
//    foreach ($result as $td){
//        $id = $td['user_id'];
//        $cmd = Yii::$app->db
//            ->createCommand("insert into beacon_user(user_id, major, minor) values (:id, 2, :id)");
//        $cmd->bindValue(':id', $id);
//        $result = $cmd->query();
//    }
//
//    $cmd = Yii::$app->db
//        ->createCommand("select user_id from student WHERE user_id is not null ORDER BY user_id ASC");
//    $result = $cmd->queryAll();
//    foreach ($result as $td){
//        $id = $td['user_id'];
//        $cmd = Yii::$app->db
//            ->createCommand("insert into beacon_user(user_id, major, minor) values (:id, 1, :id)");
//        $cmd->bindValue(':id', $id);
//        $result = $cmd->query();
//    }
?>
<?php
//    $cmd = Yii::$app->db
//        ->createCommand("select id from lesson");
//    $result = $cmd->queryAll();
//    $count = 0;
//    foreach ($result as $td){
//        $count++;
//        $id = $td['id'];
//        $cmd = Yii::$app->db
//            ->createCommand("select id from lecturer");
//        $rs = $cmd->queryAll();
//        $cmd = Yii::$app->db
//            ->createCommand("insert into lesson_lecturer(lesson_id, lecturer_id) values (:id, :lecturer_id)");
//        $cmd->bindValue(':id', $id);
//        $cmd->bindValue(':lecturer_id', $rs[$count%count($rs)]['id']);
//        $rs2 = $cmd->query();
//    }
?>