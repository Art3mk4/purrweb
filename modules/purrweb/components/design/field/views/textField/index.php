<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
?>

<div class="viewFieldSet__content__row">
    <?= $this->render('label', ['inputId' => $inputId, 'label' => $label]) ?>
    <div class="viewFieldSet__content__desc">
        <!-- Текстовое поле -->
            <?= Html::textInput(
                $inputName, 
                Html::encode($value),
                ArrayHelper::merge(
                    $htmlOptions,
                    array(
                        'id' => $inputId,
                        'class' => 'f-fieldSetText ' . $htmlOptions['class']
                    )
                )
        ); ?>
    </div>
</div>
