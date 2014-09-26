<?php
    $categories_list = get_the_category_list( ', ' );
    $tag_list = get_the_tag_list( '', ', ' );
?>

<dl>
    <dt><?php echo __('Written by', 'roots'); ?>:</dt>
    <dd class="byline author vcard">
        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>
    </dd>
    <dt><?php echo __('Published', 'roots'); ?>:</dt>
    <dd>
        <time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>
    </dd>

    <?php if($categories_list): ?>
        <dt><?php echo __('Categories', 'roots'); ?>:</dt>
        <dd><?php echo $categories_list; ?></dd>
    <?php endif; ?>

    <?php if($tag_list): ?>
        <dt><?php echo __('Tags', 'roots'); ?>:</dt>
        <dd><?php echo $tag_list; ?></dd>
    <?php endif; ?>
</dl>