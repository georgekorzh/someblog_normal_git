<?php
/* @var $this PostsController */
/* @var $model Posts */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Posts', 'url'=>array('index')),
	array('label'=>'Create Posts', 'url'=>array('create')),
	array('label'=>'View Posts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Posts', 'url'=>array('admin')),
);
?>

<h1>Update Posts <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.serializejson.min.js"></script>
<script type="text/javascript">
    $('#posts-form').validate(  {
        rules:{
            //pic:{require:true}
        },
        submitHandler: function(form) {
            var $form = $(form);
            var self = this;
            data = $form.serializeJSON();
            data.Posts.body = CKEDITOR.instances.Posts_body.getData();

            //console.log(CKEDITOR.instances.Posts_body.getData());
            //alert(data.Posts.body);

            $.post('<?php echo Yii::app()->createAbsoluteUrl('api/posts/update/', array('id' =>$model->id)); ?>' ,data)
                .done(function(r) {
                    $('#note').html(r);
                    console.log(r);
                    location.href = '<?php echo Yii::app()->createAbsoluteUrl('posts/view'); ?>/' + r.data.id;
                    //alert(r.data.id);
                })
                .fail(function(xhr) {

                    console.log(xhr.responseJSON);
                    console.log(xhr.responseJSON.errors);

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