<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PublicHoliday */

$this->title = 'Create Public Holiday';
$this->params['breadcrumbs'][] = ['label' => 'Public Holidays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="public-holiday-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
