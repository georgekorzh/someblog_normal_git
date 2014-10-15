<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>
<div class="row">
<div class="form col-md-5">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('class' => 'form-horizontal','id' => 'logForm', 'novalidate' => 'false'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note" >Fields with <span class="required">*</span> are required.</p>
    <p id="note"></p>
	<div class="form-group">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username', array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
		<!--	Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.-->
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe', array('class' => '')); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.serializejson.min.js"></script>
<script type="text/javascript">
    $('#logForm').validate(  {
        submitHandler: function(form) {
            var $form = $(form);
            var self = this;
            data = $form.serializeJSON();
            //$form.find(':input').prop('disabled', true);
            //$(form).find(':input').prop('disabled', true);

            $.post('<?php echo Yii::app()->createAbsoluteUrl('api/users/signin'); ?>' ,data)
                .done(function(r) {
                    $('#note').html(r);
                    //console.log(r);
                    //alert('no_errors');
                    location.href = '<?php echo Yii::app()->createAbsoluteUrl('users/index'); ?>';
                    //$('#note').html(r);
                })
                .fail(function(xhr) {
                    console.log(xhr.responseJSON);
                    //console.log(xhr.responseJSON.errors.LoginForm);
                    //alert(xhr.responseJSON.errors);
                    self.showErrors(xhr.getAllResponseHeaders);
                    $form.find(':input').prop('disabled', false);
                    //$('#note').html(xhr.getAllResponseHeaders());
                })
                .complete(function(res) {
                    $form.find(':input').prop('disabled', false);

                });
            return false;
        }

    });
</script>