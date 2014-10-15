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
    <p id="note"></p>

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
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.serializejson.min.js"></script>
<script type="text/javascript">
    $('#regForm').validate(  {
        rules:{
            pic:{require:true}
        },
        submitHandler: function(form) {
            var $form = $(form);
            var self = this;
            data = $form.serializeJSON();
            //$form.find(':input').prop('disabled', true);
            $(form).find(':input').prop('disabled', true);

            $.post('<?php echo Yii::app()->createAbsoluteUrl('api/users/signup'); ?>' ,data)
                .done(function(r) {
                    $('#note').html(r);
                    //alert('no_errors');
                    location.href = '<?php echo Yii::app()->createAbsoluteUrl('site/login'); ?>';
                    //$('#note').html(r);
                })
                .fail(function(xhr) {
                    console.log(xhr.responseJSON.errors.pic);
                    console.log(xhr.responseJSON.errors);
                    //console.log(xhr.responseJSON.errors.regForm);
                    //alert(xhr.responseJSON.errors);
                    self.showErrors(xhr.getAllResponseHeaders);
                    $form.find(':input').prop('disabled', false);
                    $('#note').html(xhr.getAllResponseHeaders());
                })
                .complete(function(res) {
                    $form.find(':input').prop('disabled', false);

                });
            return false;
        }

    });
</script>