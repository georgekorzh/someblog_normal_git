<?php
/* @var $this PostsController */
/* @var $model Posts */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Posts', 'url'=>array('index')),
	array('label'=>'Create Posts', 'url'=>array('create')),
	array('label'=>'Update Posts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Posts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Posts', 'url'=>array('admin')),
);
?>

<h1><?php //echo $model->title; ?></h1>


<div class="singlepost">
<div class="postSeparator">
    <div class="postLine"></div>
    <div class="hexIco">
        <a href="#"></span></a>
        <div class="corner-1"></div>
        <div class="corner-2"></div>
    </div>
</div>
<!--------------------------------------->
<div class="post-item">
    <div class="picBody">
        <?php
            if(!empty($model->main_img)) {
                echo '<img src="files/ship.gif">';
            }
        else
            echo '';

        ?>

    </div>


    <div class="post-title singletitle"><?php echo $model->title?></div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="postdata">
                <div class="pinkline_back"><div class="pinkline"></div></div>
                <!-- Need 2 request aurhor's name-->
                <a href="#" class="usersposts"><?php echo $model->author->login; ?></a>
                /
                <a href="#" class="published"><?php echo $model->publish; ?></a>
                /
                <a href="#" class="hmcomments"><span class="current_num_comm"><?php echo count($tree); ?></span> comment(-s) </a>
                <?php //echo '<pre>';var_dump(get_class_methods('Comments')); ?>
            </div>
            <div class="post-body singlebody">
                <?php echo $model->body; ?>
                <!--
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>

                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                -->
            </div>

            <div class="author_comment">
                <div class="row">
                    <div class="col-md-3">
                        <div class="ava">
                            <div class="hexAva" style="background-image: url(files/ava1.jpg);">
                                <a href="#"></a>
                                <div class="corner-1"></div>
                                <div class="corner-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="auth_text">
                            <div class="author_username">
                                <div class="author_username">
                                    <?php echo $model->author->login; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comments">
                <div class="comm_title">
                    <div class="row">
                        <div class="col-md-2 num_comm"><span class="current_num_comm"><?php echo count($tree); ?></span> comment(-s)</div>
                        <div class="col-md-2 col-md-offset-2 leavecomm" id="leaveComment">Leave comment now</div>
                    </div>
                </div>
                <?php

                ?>
                <div class="users_comms">
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('.users_comms .comm_item').each(function(){
                                var numMarg = $(this).attr('data-level') * 1;
                                if(numMarg > 3){
                                    numMarg = 3;
                                }
                                var realMarg = numMarg * 100;
                                $(this).css("margin-left", realMarg + "px");
                            })
                        });
                    </script>
                    <?php
                        $this->renderPartial('_comment', array('tree' => $tree), false);
                        //$this->renderPartial('_comment', array('tree' => $model->comments), false);
                    ?>

                    <!--
                    <div class="comm_item" data-level="1">
                        <div class="row">
                            <div class="col-md-2 comm_ava">
                                <img src="files/ava1.jpg">
                            </div>
                            <div class="col-md-9 comm_all">
                                <div class="comment_title">
                                    <a href="#" class="username">John Doe</a>
                                    <p class="comment_date pull-right">2-:3- PM - 15 November, 2013</p>
                                </div>
                                <div class="comment_body">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
            <div class="comm_title add_comm">
                <div class="row">
                    <div class="col-md-3 num_comm">Leave A Comment</div>
                </div>
            </div>

            <?php
                $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'comms-form',
                    'enableAjaxValidation'=>false,
                    'htmlOptions'   =>  array(
                        'class' =>  'form-horizontal comment-form',
                        'role'  =>  'role',
                    ),
                ));
                echo $form->hiddenField($comm, 'parent', array('id' => 'comment_to'));
                echo $form->hiddenField($comm, 'post_id', array('value' => $model->id));

            ?>

                <div class="col-md-3 inputs">
                    <div class="form-group">
                        <?php
                        if(Yii::app()->user->isGuest){
                            echo $form->textField(Users::model(),'login',array(
                                    'size'          =>  60,
                                    'maxlength'     =>  200,
                                    'class'         =>  'form-control inputusname',
                                    'placeholder'   =>  'Your Name',
                                )
                            );
                        }
                        ?>

                    </div>
                    <div class="form-group">
                        <?php
                        if(Yii::app()->user->isGuest){
                            echo $form->textField(Users::model(),'email',array(
                                    'size'          =>  60,
                                    'maxlength'     =>  200,
                                    'class'         =>  'form-control inputemail',
                                    'placeholder'   =>  'Email',
                                )
                            );
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-9 inserts">
                    <div class="form-group">
                        <?php echo $form->textArea($comm,'comment',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>

                    </div>
                </div>
                <div style="clear:both"></div>
                <div class="com_butts">
                    <button type="submit" class="pull-right comm_sub">Submit</button>
                </div>
                <p id="clearAnswer" class="pull-right" style="display:none;">Cancel<p>

            <?php
                $this->endWidget();
            ?>
            </div>

        </div>
    </div>

</div>


</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.serializejson.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var copyTArea = $('#Comments_comment').clone();


        $('#clearAnswer').click(function(){
            //$('#Comments_comment').empty().attr('placeholder', '');
            $('#Comments_comment').attr('placeholder', '');
            //$(this);
            $('#comment_to').val('');
            $('#clearAnswer').toggle('slow');
        });
        $('#leaveComment').click(function(){
            $('body').scrollTo('#Comments_comment');
            $('#Comments_comment').focus();
            $('#clearAnswer').toggle('slow');
        });

        $('.replyComm').click(function(){
            phText = $(this).parent().parent().find('a.username').html();
            //console.log(phText);

            $('#Comments_comment').attr('placeholder','Reply to '+ phText);
            var commId = $(this).parent().parent().parent().parent().parent().attr('id');
            $('#comment_to').val(commId);

            $('#Comments_comment').attr('placeholder');
            $('body').scrollTo('#Comments_comment');
            $('#Comments_comment').focus();

            $('#clearAnswer').toggle('slow');
        });

        $('.delComm').click(function(){
            $.post('<?php echo Yii::app()->createAbsoluteUrl('api/posts/delcomm'); ?>/',{id: $(this).attr('data-id')})
                .done(function(r){
                    //alert($(this).attr('data-id'));
                    //$('.current_num_comm').html(r.data.count)


                    $('#num_comm' + r.data.id).prev().nextAll('.comm_item').each(function(){
                        var id = $(this).attr('id');

                        $(this).slideUp();


                        /*
                        var currlevelstr = $(this).attr('data-level');
                        var currlevel = currlevelstr * 1;

                        var nextlevelstr = $(this).next().attr('data-level');
                        var nextlevel = nextlevelstr * 1;
                        */
                        /*

                        */
                        //alert( $(this).next().attr('data-parent'));

                        $(this).slideUp();

                        if('num_comm' + $(this).next().attr('data-parent') != id){
                            $(this).remove();
                            return false;
                        }

                        $(this).remove();

                        /**//*
                        var id = $(this).attr('id');
                        //$elem = $(this);
                        $(this).remove();
                        alert($(this).parent('.comm_item').next('.comm_item').attr('data-parent'));
                        if($(this).parent().parent().parent().parent().parent().next('.comm_item').attr('data-parent') != id){
                            return false;
                        }
                        */
                    });
                });
            return false;
        });

        $('#comms-form').validate(  {

            submitHandler: function(form) {
                var $form = $(form);
                var self = this;
                data = $form.serializeJSON();
                //data.Posts.body = CKEDITOR.instances.Posts_body.getData();

                //console.log(CKEDITOR.instances.Posts_body.getData());
                //alert(data.Posts.body);

                $.post('<?php echo Yii::app()->createAbsoluteUrl('api/posts/comment'); ?>',data)
                    .done(function(r) {
                        //$('#note').html(r);
                        console.log(r.data);


                        var getDiv2append = '';
                        var newDataLevel = 0;
                        if(r.data.parent != '0'){
                            var level = $('#num_comm' + r.data.parent).attr('data-level') * 1;
                            newDataLevel = level + 1;
                        }
                        if(newDataLevel > 3){
                            newDataLevel = 3;
                        }
                        var newLMarginINT = newDataLevel * 100;
                        var newLMargin = newLMarginINT + 'px';

                        var newCommDiv = '<div style="margin-left:'+newLMargin+'" class="comm_item" id="num_comm'+ r.data.id+' " data-level="'+newDataLevel+'">';
                                newCommDiv += '<div class="row">';
                                    newCommDiv += '<div class="col-md-2 comm_ava">';
                                        newCommDiv += '<img src="/images/'+r.data.pic+'">';

                                    newCommDiv += '</div>';
                                    newCommDiv += '<div class="col-md-9 comm_all">';
                                        newCommDiv += '<div class="comment_title">';
                                            newCommDiv += '<a href="#" class="username">'+ r.data.author+'</a>';
                                            newCommDiv += '<p class="pull-right">';
                                                newCommDiv += '<span class="comment_date">'+ r.data.date +'</span>';
                                                newCommDiv += '<span class="replyComm"></span>';
                                            newCommDiv += '</p>';
                                        newCommDiv += '</div>';
                                        newCommDiv += '<div class="comment_body">';
                                            newCommDiv += '<p>';
                                                newCommDiv += r.data.text;
                                            newCommDiv += '</p>';
                                        newCommDiv += '</div>';
                                    newCommDiv += '</div>';
                                newCommDiv += '</div>';
                            newCommDiv += '</div>';
                        if(r.data.parent == '0'){
                            $('.users_comms').append(newCommDiv);
                        }else{
                            $(newCommDiv).insertAfter('#num_comm' + r.data.parent);
                        }

                        //$('#Comments_comment').html('');

                        //addNewComment
                        /*
                         *
                         *
                         * ВЫЧЕСЛИТЬ УРОВЕНЬ ВЛОЖЕННОСТИ!!!!!!!!!!
                         * ВЫЧЕСЛИТЬ УРОВЕНЬ ВЛОЖЕННОСТИ!!!!!!!!!!
                         * ВЫЧЕСЛИТЬ УРОВЕНЬ ВЛОЖЕННОСТИ!!!!!!!!!!
                         * ВЫЧЕСЛИТЬ УРОВЕНЬ ВЛОЖЕННОСТИ!!!!!!!!!!
                         *
                         *
                         * */


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
                        $('#clearAnswer:visible').toggle("slow");

                        $('#Users_login').val('');
                        $('#Users_email').val('');
                        $('#Comments_comment').remove();
                        //console.log(copyTArea);
                        $('.col-md-9.inserts .form-group').append(copyTArea);
                    });
                return false;
            }

        });
    });
</script>