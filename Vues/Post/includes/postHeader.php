<?php
/**
 * @var Model\Post $post
 */
?>
<div class="post-header">
    <div class="user-infos">
        <a href="/user/<?php echo $post->getUser()->getUsername() ?>">
            <img class="pfp" alt="user pfp" src="<?php echo $post->getUser()->getAvatar() ?>">
        </a>
        <div>
            <p class="txt-orange"><a href="/categ/<?php echo $post->getCategory()->getNameCategory() ?>">
                    categ/<?php echo $post->getCategory()->getNameCategory() ?></a></p>
            <p class="muted"><a href="/user/<?php echo $post->getUser()->getUsername() ?>">
                    user/<?php echo $post->getUser()->getUsername() ?></a></p>
        </div>
    </div>
    <div>
        <div class="tooltip">
            <p class="muted txt-small">Posté il y a <?php
                echo Src\Utils::getDateInterval($post->getDatePost())
                ?></p>
            <span class="tooltiptext txt-small"><?php echo "Le ".(new \DateTime($post->getDatePost()))->format("d/m/Y à H:i") ?></span>
        </div>
    </div>
</div>