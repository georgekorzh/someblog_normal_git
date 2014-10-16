<?php
foreach($tree as $iTree) {

    ?>

    <div class="comm_item" data-level="<?php echo $iTree[1]; ?>">
        <div class="row">
            <div class="col-md-2 comm_ava">
                <img src="<?php echo $img_path = isset($iTree[0]->author->pic)
                    ?   '/images/'. $iTree[0]->author->id .'/avatar/'.$iTree[0]->author->pic
                    :   '/images/noimage.png'; ?>">

            </div>
            <div class="col-md-9 comm_all">
                <div class="comment_title">
                    <a href="#" class="username">
                        <?php echo   $iTree[0]->author->login;?>
                    </a>

                    <p class="comment_date pull-right">2-:3- PM - 15 November, 2013</p>
                    <p class="comment_date pull-right"><?php $iTree[0]->when_done.'fefefe'; ?></p>
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