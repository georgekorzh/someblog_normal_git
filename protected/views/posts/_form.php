<?php
/* @var $this PostsController */
/* @var $model Posts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'posts-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
    <p id="note"></p>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/ckeditor/ckeditor.js"></script>
	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>200, 'class'=>'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
        <script type="text/javascript">
            CKEDITOR.replace('Posts_body');
        </script>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="form-group">
		<?php //echo $form->labelEx($model,'id_author'); ?>
		<?php //echo $form->textField($model,'id_author',array('size'=>60,'maxlength'=>200, 'class'=>'form-control')); ?>
		<?php //echo $form->error($model,'id_author'); ?>
	</div>

	<div class="form-group">
		<?php //echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', array('yes'=>'yes', 'no'=>'no')); ?>
		<?php //echo $form->error($model,'status'); ?>
	</div>

    <div class="row buttons">
        <?php echo CHtml::button($model->isNewRecord ? 'Create' : 'Save', array('type' => 'submit', 'class' => 'btn btn-default')); ?>
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

