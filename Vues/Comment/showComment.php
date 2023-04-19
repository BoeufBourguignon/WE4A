<?php
/**
 * @var Model\Comment $comment
 */
?>
<div class="comment">
    <div class="comment-header">
        <a href="/user/<?php echo $comment->getUser()->getUsername() ?>">
            <img alt="user pfp" src="<?php echo $comment->getUser()->getAvatar() ?>">
        </a>
        <a href="/user/<?php echo $comment->getUser()->getUsername() ?>">
                <?php echo $comment->getUser()->getUsername() ?></a>
    </div>
    <div class="comment-content">
        <?php echo $comment->getContent() ?>
    </div>
    <div class="comment-footer">
        <div class="tooltip">
            <p class="muted txt-small">Posté il y a <?php
                echo Src\Utils::getDateInterval($comment->getDateComment())
                ?></p>
            <span class="tooltiptext txt-small"><?php echo "Le ".
                    (new \DateTime($comment->getDateComment()))->format("d/m/Y à H:i") ?></span>
        </div>
    </div>
</div>