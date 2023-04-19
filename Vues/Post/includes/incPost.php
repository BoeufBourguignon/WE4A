<?php
/**
* @var Src\ControllerBase $this
* @var Model\Post $post
*/
?>
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
        <div class="tooltip">
            <p class="muted txt-small">Posté il y a <?php
                $dateDiff = (new \DateTime())->diff(new \DateTime($post->getDatePost()));
                echo $dateDiff->y > 0
                    ? $dateDiff->y . " an(s)"
                    : ( $dateDiff->m > 0
                        ? $dateDiff->m . " mois"
                        : ( $dateDiff->d > 0
                            ? $dateDiff->d . " jour(s)"
                            : $dateDiff->h . " heure(s)"
                        )
                    );
                ?></p>
            <span class="tooltiptext txt-small"><?php echo "Le ".(new \DateTime($post->getDatePost()))->format("d/m/Y à H:i") ?></span>
        </div>
    </div>
</div>
<h1 class="pointer" onclick="window.location='/post/<?php echo $post->getIdPost() ?>'"><?php echo $post->getTitle() ?></h1>
<div class="post-content">
    <?php echo $post->getContent() ?>
</div>