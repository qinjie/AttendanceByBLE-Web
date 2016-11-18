<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LessonDate */

$this->title = 'Create Lesson Date';
$this->params['breadcrumbs'][] = ['label' => 'Lesson Dates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-date-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
