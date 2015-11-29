<?php
use app\modules\purrweb\components\design\pager\Pager;
use yii\bootstrap\Html;
?>

<p class="countRows">Количество: <?= $provider->pagination->totalCount?></p>
<?= Html::a('Добавить', ['page/add']);?>
<?php foreach ($provider->models as $row):?>
<?= Html::a('редактировать', ['page/edit', 'id' => $row->id]);?>
<?= Html::tag('div', $row->title);?>
<?= Html::a('Удалить', ['page/delete', 'id' => $row->id]);?>
<?php endforeach;?>

<?= Pager::widget(['pages' => $provider->pagination]); ?>