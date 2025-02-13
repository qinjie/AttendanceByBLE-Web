<?php
$this->title = 'Lesson today';
$this->params['breadcrumbs'][] = $this->title;
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
            <td>Time</td>
            <td>Lesson</td>
            <td>Venue</td>
        </tr>
    </thead>
    <?php
    $count = 0;
    foreach ($data as $item){
        $count++;
        $name = $item['lesson']['catalog_number'];
        $location = $item['venue']['name']." (".$item['venue']['location'].")";
        $start_end = substr($item['lesson']['start_time'], 0, 5)." to ".substr($item['lesson']['end_time'], 0, 5);
        echo "
            <tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"window.location ='".Yii::$app->homeUrl."site/lesson-detail?id=".$item['lesson_date'][0]['id']."'\">
            <td>".$count."</td>
            <td>".$start_end."</td>
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

    .record_table td:nth-child(4) {
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