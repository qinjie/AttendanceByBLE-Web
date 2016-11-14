<?php

/* @var $this yii\web\View */

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::$app->name ?></h1>
    </div>
</div>

<div class="row">
    <div class="info-box">
        <label for="cb">
            <span class="info-box-icon bg-teal-active"><i class="ion ion-person"></i></span>
            <div class="info-box-content">
                <font color="black">
                    <div class="title">
                        <span class="name">Cumulative performance</span>
                        <span class="date"><input type="checkbox" /></span>
                    </div>
                    <span class="info-box-text">1</span>
                </font>

            </div>
        </label>
    </div><!-- /.info-box -->
    <div class="info-box">
        <a href="resident">
            <span class="info-box-icon bg-teal-active"><i class="ion ion-person"></i></span>
            <div class="info-box-content">
                <font color="black">
                    <span class="info-box-number">Resident</span>
                    <span class="info-box-text">1</span>
                </font>

            </div>
        </a>
    </div><!-- /.info-box -->
</div>

<style>
    a:link {
        text-decoration: none;
    }
    .title
    {
        display: block;
        height: 25px;
        font-size: 14px;
        color: #000;
    }
    .title .date { float:right }
    .title .name { float:left }
</style>

<script>
    $(document).ready(function() {
        $('.record_table').click(function(event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });
    });
</script>