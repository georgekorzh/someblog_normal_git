<?php
foreach($tree as $iTree) {

    ?>

    <div class="comm_item" id="num_comm<?php echo $iTree[0]->id; ?>" data-parent="<?php echo $iTree[0]->parent; ?>" data-level="<?php echo $iTree[1]; ?>">
        <div class="row">
            <div class="col-md-2 comm_ava">
                <img src="<?php echo $img_path = isset($iTree[0]->author->pic)
                    ?   '/images/'. $iTree[0]->author->id .'/avatar/'.$iTree[0]->author->pic
                    :   '/images/noimage.png'; ?>">

            </div>
            <div class="col-md-9 comm_all">
                <div class="comment_title">
                    <a href="#" class="username"><?php echo   $iTree[0]->author->login;?></a>

                    <!--<p class="comment_date pull-right">2-:3- PM - 15 November, 2013</p>-->
                    <p class="pull-right">
                        <span class="comment_date"><?php echo date('g:-i A - j F, Y', strtotime($iTree[0]->when_done)); ?></span>
                        <span class="replyComm">Reply</span>
                        <?php
                        echo $iTree[0]->author_id == Yii::app()->user->id ? '<a href="#" data-id="'. $iTree[0]->id .'" class="delComm">delete</a>' : '';
                        ?>
                    </p>
                </div>
                <div class="comment_body">
                    <p>
                        <?php echo $iTree[0]->comment; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<script type="text/javascript">
    $(document).ready(function(){

    });
</script>