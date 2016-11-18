<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BeaconAttendanceStudent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="beacon-attendance-student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lesson_date_id')->textInput() ?>

    <?= $form->field($model, 'student_id_1')->textInput() ?>

    <?= $form->field($model, 'student_id_2')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
