<?php
/**
 * @var Model\Post $post
 */
?>
<div class="post">
    <div class="post-header">
        <div class="user-infos">
            <a href="/user/<?php echo $post->getUser()->getUsername() ?>">
                <img alt="user pfp" src="<?php echo $post->getUser()->getAvatar() ?>">
            </a>
            <div>
                <p class="txt-orange"><a href="/categ/<?php echo $post->getCategory()->getNameCategory() ?>">
                        categ/<?php echo $post->getCategory()->getNameCategory() ?></a></p>
                <p class="muted"><a href="/user/<?php echo $post->getUser()->getUsername() ?>">
                        user/<?php echo $post->getUser()->getUsername() ?></a></p>
            </div>
        </div>
        <div>
            <p><?php echo date("d/m/Y H:i", strtotime($post->getDatePost())) ?></p>
        </div>
    </div>
    <h1><?php echo $post->getTitle() ?></h1>
    <p><?php echo $post->getContent() ?></p>
</div>