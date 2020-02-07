
<div class="post">
        <p class="date"><?php  echo View::format_date($post->created_at,'M Y'); ?>
            <b><?php  echo View::format_date($post->created_at, "d"); ?></b>
        </p>
        <h2 class="title">&raquo;<a href="<?php echo '/'.APP_ROOT.'/'; ?>posts/<?php echo $post->id; ?>/show">
            <?php echo $post->title;  ?></a></h2>
        <div class="entry">
                <?php  echo $post->body; ?>
        </div>
        <p class="meta"><small>Posted
               by <?php  echo $post->user->username; ?></small>
        </p>
</div>