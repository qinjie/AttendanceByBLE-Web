<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SemesterInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semester-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo '<label class="control-label">Start date</label>';?>
    <?=
    kartik\date\DatePicker::widget([
        'model' => $model,
        'attribute' => 'start_date',
        'options' => ['placeholder' => 'Enter start date ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]);
    ?>
    <br>
    <?php echo '<label class="control-label">End date</label>';?>
    <?=
    kartik\date\DatePicker::widget([
        'model' => $model,
        'attribute' => 'end_date',
        'options' => ['placeholder' => 'Enter end date ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]);
    ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
