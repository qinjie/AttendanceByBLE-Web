<?php
?>
<div class="site-index">
    <div class="jumbotron">
        <h1 style="margin: 0px 0px 0px 0px;">Lesson</h1>
    </div>
</div>
<table class="record_table">
    <thead>
    <td>#</td>
    <td>Date</td>
    </thead>
    <?php
    $count = 0;
    foreach ($list as $item){
        $count++;
        $date = $item['ldate'];
        if ($date == date("Y-m-d")){
            echo "
            <tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"window.location ='".Yii::$app->homeUrl."site/lesson-detail?id=".$item['id']."'\">
            <td style='font-weight:bold;'>".$count."</td>
            <td style='font-weight:bold;'>".$date."</td>
            </tr>
            ";
        } else {
            echo "
            <tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"window.location ='".Yii::$app->homeUrl."site/lesson-detail?id=".$item['id']."'\">
            <td>".$count."</td>
            <td>".$date."</td>
            </tr>
            ";
        }
    }
    ?>
</table>

<style>
    .custom-submit {
        margin-top: 20px;
        padding-right: 20px;
        float: right;
    }

    .record_table td:first-child {
        text-align: center;
        width: 50px;
    }

    .record_table td:nth-child(2) {
        padding-left: 10px;
    }

    .record_table td:nth-child(3) {
        padding-left: 10px;
    }

    .record_table {
        width: 100%;
        border-collapse: collapse;
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
</style>