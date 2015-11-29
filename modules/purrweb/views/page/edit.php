<?php
use yii\helpers\Html;

use app\modules\purrweb\components\design\field\TextField;
use app\modules\purrweb\components\design\field\TextareaField;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$this->title = 'Редактирование страницы'; 
?>


<?= Html::beginForm('', 'POST', ['id' => 'viewFieldSetContainer', 'class' => 'fieldSet__form', 'enctype' => 'multipart/form-data']) ?>
        <?= TextField::widget([
            'model' => $item,
            'field' => 'title'
        ]);?>
        <?= TextareaField::widget([
            'model' => $item,
            'field' => 'details',
            'fck'   => true
        ]);?>
        <?= Html::submitButton('Сохранить')?>
<?= Html::endForm() ?>
<?php foreach ($item->images as $image):?>
    <?= Html::img('/upload/'.$image->model. '/'.$image->field. '/'.$image->filename . '.' . $image->type);?>
<?php endforeach;?>
<?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'], 
        'action' =>  Url::to(['page/upload', 'id' => $item->id])
    ]) ?>
    <?= $form->field($item, 'imageFile')->fileInput() ?>
    <button>Добавить картинки</button>
<?php ActiveForm::end() ?>