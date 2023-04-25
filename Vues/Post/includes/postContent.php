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
    <?php
    $img = glob(ROOT . "/PublicAssets/Images/Posts/" . $post->getIdPost() . ".*");
    if($img !== false && count($img) > 0)
    {
        ?>
        <img id="image-post" alt="Image post"
             src="/PublicAssets/Images/Posts/<?php echo pathinfo($img[0], PATHINFO_BASENAME) ?>">
        <?php
    }
    ?>
    <?php echo $post->getContent() ?>
</div>