<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LessonLecturer */

$this->title = 'Create Lesson Lecturer';
$this->params['breadcrumbs'][] = ['label' => 'Lesson Lecturers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-lecturer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
