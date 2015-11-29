<?php
use yii\helpers\Html;
use app\modules\purrweb\components\design\asset\DesignAsset;
use app\modules\purrweb\components\core\helper\GetUrl;

if ($fck) {
    $this->registerJsFile(GetUrl::assetsUrl($this, DesignAsset::className() ,'js/libs/ckeditor/ckeditor.js'), array('position' => 2));
    $this->registerJsFile(GetUrl::assetsUrl($this,  DesignAsset::className(), 'js/libs/ckeditor/adapters/jquery.js'), array('position' => 2));
}
?>

<div class="viewFieldSet__content__row">
    <?=$this->render(
        '../textField/label', 
        [
            'inputId' => $inputId,
            'label' => $label
        ]
    )?>

    <?php foreach ($errors as $error) : ?>
        <p class="error"><?=$error?></p>
    <?php endforeach; ?>
    <div class="viewFieldSet__content__desc">
        <!-- Большое текстовое поле -->
        <?php echo Html::textArea(
            $inputName,
            $value,
            array_merge(
                $htmlOptions,
                array(
                    'id' => $inputId,
                    'class' => 'f-fieldSetComment ' . $htmlOptions['class'] . ($fck ? ' ckedit' : '')
                )
            )
        ); ?>
    </div>
    <?php if ($fck) :?>
        <script type="text/javascript">
            CKEDITOR.replace(<?php echo $inputId ?>,
                {}
            ); 
        </script>
    <?php endif;?>
</div>