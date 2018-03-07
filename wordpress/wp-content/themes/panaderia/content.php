<div class="row">
    <?php
        if(has_post_thumbnail()){
            $imgUrl = get_the_post_thumbnail_url();
        }else{
            $imgUrl = get_template_directory_uri() . '/img/pan-69.jpg';
        }
    ?>
    <div class="col-md-12">
        <div class="img-custom" style="background-image:url(<?php echo $imgUrl ?>);">
            <span class="postTitle"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></span>
            <?php echo get_avatar(get_the_author_meta('ID'), 64); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-post">
        <br>
        <span><i class="fa fa-user-o" aria-hidden="true"></i><?php echo ' ' . get_the_author_posts_link(); ?> | <i class="fa fa-calendar" aria-hidden="true"></i> <?php the_time('j F Y') ?></span>
        <span><?php the_excerpt(); ?></span>
        <br>
        <i class="fa fa-tags" aria-hidden="true"></i><span>&nbsp;<?php the_tags(''); ?>
        <span class="rigth"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_number('Sin comentarios', '1 comentario', '% comentarios'); ?></span>
    </div>
</div>
<hr>
<br>
