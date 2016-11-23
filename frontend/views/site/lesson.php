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
            <td>Lesson</td>
            <td>Venue</td>
        </thead>
        <?php
        $count = 0;
        foreach ($data as $item){
            $count++;
            $name = $item['lesson']['catalog_number'];
            $location = $item['venue']['location'];
            echo "
            <tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"window.location ='".Yii::$app->homeUrl."site/lesson-list?id=".$item['lesson_id']."'\">
            <td>".$count."</td>
            <td>".$name."</td>
            <td>".$location."</td>
            </tr>
            ";
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