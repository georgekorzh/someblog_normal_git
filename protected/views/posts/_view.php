<?php
/* @var $this PostsController */
/* @var $data Posts */
?>

<div class="postSeparator">
    <div class="postLine"></div>
    <div class="hexIco">
        <a href="#"></a>
        <div class="corner-1"></div>
        <div class="corner-2"></div>
    </div>
</div>
<div class="post-item">
    <?php
        if($data->main_img){
            ?>
            <div class="picBody">
                <img src="<?php echo '/images/' . $data->main_img; ?>">
            </div>
            <?php
        }
    ?>


    <div class="post-title"><?php echo $data->title;?></div>
    <div class="post-body">
        <?php echo $data->body; ?>
    </div>
    <div class="moreback">
        <a name="more" href="<?php echo Yii::app()->createAbsoluteUrl('posts/view', array('id' => $data->id)) ?>" class="btn btn-primary moreLink">Read more</a>
    </div>

    <div class="postdata">
        <div class="pinkline_back"><div class="pinkline"></div></div>
        <a href="#" class="usersposts"><?php echo $data->author->login; ?></a>
        /
        <a href="#" class="published"><?php echo date('g:-i A - j F, Y', strtotime($data->publish)); ?></a>
        /
        <?php
            echo '<pre>';
                var_dump(Comments::model()->getSomeParent($data->id));
            echo '</pre>';
        ?>
        <a href="#" class="hmcomments"><?php echo count(Comments::model()->getSomeParent($data->id));//count($data->comments); ?> Comment(-s)</a>
        <!--
        ---РЕШИТЬ ПРОБЛЕМУ С КЛЮЧАМИ!!!!!!!!!!!!!!!!МНОГО ЗАПРОСОВ!!!!!!!!!!!!!или нет!!!!!!!!---
        ---РЕШИТЬ ПРОБЛЕМУ С КЛЮЧАМИ!!!!!!!!!!!!!!!!МНОГО ЗАПРОСОВ!!!!!!!!!!!!!или нет!!!!!!!!---
        ---РЕШИТЬ ПРОБЛЕМУ С КЛЮЧАМИ!!!!!!!!!!!!!!!!МНОГО ЗАПРОСОВ!!!!!!!!!!!!!или нет!!!!!!!!---
        ---РЕШИТЬ ПРОБЛЕМУ С КЛЮЧАМИ!!!!!!!!!!!!!!!!МНОГО ЗАПРОСОВ!!!!!!!!!!!!!или нет!!!!!!!!---
        ---РЕШИТЬ ПРОБЛЕМУ С КЛЮЧАМИ!!!!!!!!!!!!!!!!МНОГО ЗАПРОСОВ!!!!!!!!!!!!!или нет!!!!!!!!---
        ---РЕШИТЬ ПРОБЛЕМУ С КЛЮЧАМИ!!!!!!!!!!!!!!!!МНОГО ЗАПРОСОВ!!!!!!!!!!!!!или нет!!!!!!!!---
        -->
        <!--<a href="#" class="hmcomments"><?php echo count(Comments::model()->getSomeParent($data->id));//count($data->comments); ?> Comment(-s)</a>-->
    </div>
</div>
<?php
/*
?>

<div class="view BITCH">


	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('body')); ?>:</b>
	<?php echo CHtml::encode($data->body); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_author')); ?>:</b>
	<?php echo CHtml::encode($data->id_author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

    <?php echo CHtml::link(CHtml::encode($data->id), array('update', 'id'=>$data->id)); ?>
    <br />


</div>
<?php
*/
?>