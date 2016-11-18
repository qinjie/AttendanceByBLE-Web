<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SemesterDate */

$this->title = 'Create Semester Date';
$this->params['breadcrumbs'][] = ['label' => 'Semester Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semester-date-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
