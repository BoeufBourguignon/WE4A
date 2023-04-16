<?php
/**
 * @var Model\Post $post
 */
?>
<div class="post">
    <div class="post-header">
        <div class="user-infos">
            <img alt="user pfp" src="<?php echo $post->getUser()->getAvatar() ?>">
            <div>
                <p>categ/<?php echo $post->getCategory()->getNameCategory() ?></p>
                <p>user/<?php echo $post->getUser()->getUsername() ?></p>
            </div>
        </div>
        <div>
            <p><?php echo date("d/m/Y H:i", strtotime($post->getDatePost())) ?></p>
        </div>
    </div>
    <h1><?php echo $post->getTitle() ?></h1>
    <p><?php echo $post->getContent() ?></p>
</div>