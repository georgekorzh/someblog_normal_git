<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form col-md-5">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
    'htmlOptions' => array('class' => 'form-horizontal', 'id' => 'regForm', 'role' => 'form', 'enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="some_errors_validation">
	    <?php echo $form->errorSummary($model); ?>
    </div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>20,'maxlength'=>20, 'class'=>'form-control')); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>60, 'class'=>'form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'pass'); ?>
		<?php echo $form->passwordField($model,'pass',array('size'=>20,'maxlength'=>20, 'class'=>'form-control')); ?>
		<?php echo $form->error($model,'pass'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo $form->fileField($model,'pic'); ?>
		<?php echo $form->error($model,'pic'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::button($model->isNewRecord ? 'Create' : 'Save', array('type' => 'submit', 'class' => 'btn btn-default')); ?>
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $('#regForm').validate();
</script>