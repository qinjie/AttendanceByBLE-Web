<?php

/* @var $this yii\web\View */

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::$app->name ?></h1>
    </div>
</div>
<form id="idForm">
    <table class="record_table">
        <thead>
            <td>#</td>
            <td>Name</td>
            <td>Status</td>
        </thead>
        <tr>
            <td>1</td>
            <td>Tran Hoang Nam</td>
            <td><input name="checkbox[]" type="checkbox" value="1"></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Bui Hoang Hiep</td>
            <td><input name="checkbox[]" type="checkbox" value="2"></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Martin The Old Man</td>
            <td><input name="checkbox[]" type="checkbox" value="3"></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Nguyen Huu Thanh Canh</td>
            <td><input name="checkbox[]" type="checkbox" value="4"></td>
        </tr>
        <tfoot>
            <td></td>
            <td>Total</td>
            <td><p id="total">0</p></td>
        </tfoot>
    </table>
    <div class="custom-submit">
        <input type="submit" class="btn btn-success">
    </div>
</form>

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
        text-align: center;
        width: 50px;
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

<?php
$script = <<< JS

document.getElementById('total').innerHTML = document.querySelectorAll('input[type="checkbox"]:checked').length

$(document).ready(function() {
    $('.record_table tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
            document.getElementById('total').innerHTML = document.querySelectorAll('input[type="checkbox"]:checked').length
        }
    });
});

$("#idForm").submit(function(e) {

    var url = "site/take-attendance"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#idForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert(data); // show response from the php script.
           }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});
JS;
$this->registerJs($script);
?>