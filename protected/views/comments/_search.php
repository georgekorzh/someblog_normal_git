<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'post_id'); ?>
		<?php echo $form->textField($model,'post_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent'); ?>
		<?php echo $form->textField($model,'parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'when_done'); ?>
		<?php echo $form->textField($model,'when_done'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->