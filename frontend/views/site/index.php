<?php
echo "<input id='homeUrl' value='".Yii::$app->homeUrl."' hidden>";
$this->title = "Current Lesson"

/* @var $this yii\web\View */

?>
    <div class="site-index">
        <div class="jumbotron">
            <h1 style="margin: 0px 0px 0px 0px;">Current Attendace </h1>
        </div>
    </div>

    <table class="record_table">
        <thead>
        <td>#</td>
        <td>Name</td>
        <td></td>
        <td></td>
        </thead>
        <?php
        $count = 0;
        //            if ($lesson_date_id != 0 && $lecturer_id != 0 && count($student_list_id) > 0){
        //                echo "<input type='text' name='lesson_date_id' value='".$lesson_date_id."' hidden>";
        //                echo "<input type='text' name='lecturer_id' value='".$lecturer_id."' hidden>";
        //                foreach ($student_list_id as $id){
        //                    echo '<input type="text" name="student_list[]" value="'.$id.'" hidden>';
        //                }
        //            }
        for ($i = 0; $i < count($student_list_id); $i++){
            $count++;
            echo "
                <tr>
                <td>".$count."</td>
                <td>".$student_list_name[$i]."</td>
                <td align='center'>
                   <a class='button' href='".Yii::$app->homeUrl."site/absent?lesson_date_id=".$lesson_date_id."&lecturer_id=".$lecturer_id."&student_id=".$student_list_id[$i]."'><img src='../../web/x.png' height='20' width='20'><br>Absent</a>
                </td>
                <td align='center'>
                    <a class='button' href='".Yii::$app->homeUrl."site/present?lesson_date_id=".$lesson_date_id."&lecturer_id=".$lecturer_id."&student_id=".$student_list_id[$i]."'><img src='../../web/tick.png' height='20' width='20'><br>Present</a>
                </td>
                </tr>
                ";
        }
        ?>
        <tfoot>
        <td></td>
        <td>Total</td>
        <td></td>
        <td></td>
        </tfoot>
    </table>

    <?php \yii\widgets\Pjax::begin(['id' => 'count']); ?>

    <table class="status_table" style="width: 10%">
        <thead>
        <td>Status</td>
        </thead>
        <?php
        for ($i = 0; $i < count($student_list_id); $i++) {
            if (in_array($student_list_id[$i], $attended_student)){
                echo "
                <tr><td><img src='../../web/tick.png' width='20px' height='20px'></td></tr>
                ";
            }
            else{
                echo "
                    <tr><td></td></tr>
                    ";
            }
        }
        ?>
        <tfoot>
        <td><p id="total"></p></td>
        </tfoot>
        <script>
            document.getElementById('total').innerHTML = <?php echo count($attended_student); ?> + "/" + <?php echo count($student_list_id); ?>
        </script>
    </table>
    <?php
    \yii\widgets\Pjax::end();
    ?>
    <!--        <div class="custom-submit">-->
    <!--            <input type="submit" class="btn btn-success">-->
    <!--        </div>-->

    <style>
        /*.custom-submit {*/
            /*margin-top: 20px;*/
            /*padding-right: 10%;*/
            /*float: right;*/
        /*}*/

        .record_table {
            border-collapse: collapse;
            width: 85%;
            float: left;
        }

        .record_table tr {
            height: 50px;
        }

        .record_table tr:hover {
            background: #eee;
        }

        .record_table td {
            border: 1px solid #eee;
        }

        .record_table td:first-child {
            text-align: center;
            width: 50px;
        }

        .record_table td:nth-child(2) {
            padding-left: 10px;
        }

        .record_table td:nth-child(3) {
            border-right: 0;
            width: 70px;
        }
        .record_table td:nth-child(4) {
            border-left: 0;
            width: 70px;
        }

        .status_table {
            width: 15%;
            border-collapse: collapse;
        }
        .status_table tr {
            height: 50px;
        }
        .status_table td:first-child {
            border-right: 1px solid #eee;
            border-bottom: 1px solid #eee;
            border-top: 1px solid #eee;
            text-align: center;
        }
    </style>

<?php
$script = <<< JS
$(document).ready(function() {
   setInterval(function(){
   $.ajax({
       success: function(){
           $.pjax.reload({container:"#count", async:false});
       }
   })
   }, 1000);
});

$('.button').click(function (event){ 
     event.preventDefault(); 
     $.ajax({
        url: $(this).attr('href')
        ,success: function(response) {
            alert(response)
        }
     })
     return false; //for good measure
});

JS;
$this->registerJs($script);
?>
<?php
//$script = <<< JS
//                    document.getElementById('total').innerHTML = document.querySelectorAll('input[type="checkbox"]:checked').length
//
//                    $(document).ready(function() {
//                        $('.record_table tr').click(function(event) {
//                            if (event.target.type !== 'checkbox') {
//                                $(':checkbox', this).trigger('click');
//                                document.getElementById('total').innerHTML = document.querySelectorAll('input[type="checkbox"]:checked').length
//                            }
//                        });
//                    });
//
//                    $("#idForm").submit(function(e) {
//
//                        var homeUrl = document.getElementById("homeUrl").value;
//                        var url = homeUrl + "/site/take-attendance"; // the script where you handle the form input.
//                        $.ajax({
//                               type: "POST",
//                               url: url,
//                               data: $("#idForm").serialize(), // serializes the form's elements.
//                               success: function(data)
//                               {
//                                   alert(data); // show response from the php script.
//                               }
//                             });
//
//                        e.preventDefault(); // avoid to execute the actual submit of the form.
//                    });
//JS;
//$this->registerJs($script);
?>

<?php
//$begin = new DateTime('2016-09-05');
//$end = new DateTime('2016-12-31');
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
//    $cmd = Yii::$app->db
//        $is_holiday = true;
//    }
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