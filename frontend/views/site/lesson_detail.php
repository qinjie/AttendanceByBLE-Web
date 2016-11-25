<?php

echo "<input id='homeUrl' value='".Yii::$app->homeUrl."' hidden>";

$this->title = 'Lesson detail';
if ($lesson_date){
    $this->params['breadcrumbs'][] = ['label' => 'Lesson', 'url' => ['lesson']];
    $this->params['breadcrumbs'][] = ['label' => $lesson_name, 'url' => ['lesson-list?id='.$lesson_id]];
    $this->params['breadcrumbs'][] = $lesson_date;
}
else{
    $this->params['breadcrumbs'][] = ['label' => 'Lesson today', 'url' => ['lesson-today']];
    $this->params['breadcrumbs'][] = $this->title;
}

/* @var $this yii\web\View */

?>
    <div class="site-index">
        <div class="custom-title">
            <?php echo $this->title; ?>
        </div>
    </div>

    <table class="record_table">
        <thead style="background-color: #FAFAFA; font-weight: bold">
            <tr>
                <td>#</td>
                <td>Name</td>
                <td></td>
                <td></td>
            </tr>
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
            <tr>
                <td></td>
                <td>Total</td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

<?php \yii\widgets\Pjax::begin(['id' => 'count']); ?>

    <table class="status_table" style="width: 10%">
        <thead style="background-color: #FAFAFA; font-weight: bold">
        <tr>
            <td>Status</td>
        </tr>
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
        <tr>
            <td><p id="total"></p></td>
        </tr>
        </tfoot>
        <script>
            document.getElementById('total').innerHTML = <?php echo count($attended_student); ?> + "/" + <?php echo count($student_list_id); ?>
        </script>
    </table>
    <?php
    \yii\widgets\Pjax::end();
    ?>

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
            text-align: center;
            border-right: 0;
            width: 70px;
        }
        .record_table td:nth-child(4) {
            text-align: center;
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

function refresh() {
     $.pjax.reload({container:"#count"});
     setTimeout(refresh, 1000); // restart the function every 5 seconds
 }
refresh();

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