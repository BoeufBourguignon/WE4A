<?php
/**
 * @var Src\ControllerBase $this
 * @var Model\Post $post
 */
?>
<h1 <?php if (!isset($isShowPost) || !$isShowPost) { ?>
    class="pointer" onclick="window.location='/post/<?php echo $post->getIdPost() ?>'"
    <?php } ?>><?php echo $post->getTitle() ?></h1>
<div class="post-content">
    <?php echo $post->getContent() ?>
</div>