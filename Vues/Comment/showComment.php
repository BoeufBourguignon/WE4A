<?php
/**
 * @var Model\Comment $comment
 */
?>
<div class="comment" data-value="<?php echo $comment->getIdComment() ?>">
    <div class="comment-header">
        <a href="/user/<?php echo $comment->getUser()->getUsername() ?>">
            <img class="pfp" alt="user pfp" src="<?php echo $comment->getUser()->getAvatar() ?>">
        </a>
        <div>
            <a href="/user/<?php echo $comment->getUser()->getUsername() ?>">
                <?php echo $comment->getUser()->getUsername() ?></a>
            <div class="tooltip">
                <p class="muted txt-small">· Posté il y a <?php
                    echo Src\Utils::getDateInterval($comment->getDateComment())
                    ?></p>
                <span class="tooltiptext txt-small"><?php echo "Le ".
                        (new \DateTime($comment->getDateComment()))->format("d/m/Y à H:i") ?></span>
            </div>
        </div>
    </div>
    <div class="comment-content">
        <?php
        if($comment->isDeleted())
        {
            ?>
            <p class="muted">[commentaire supprimé]</p>
            <?php
        }
        echo $comment->getContent()
        ?>
    </div>
    <div class="comment-footer">
        <a class="btn btn-clear btn-small">Répondre</a>
        <?php
        if($this->auth->getUser() != null && $this->auth->getUser()->getIdUser() == $comment->getIdUser())
        {
            ?>
            <div>
                <a id="modify-post" <?php /* ?>href="/post/edit/<?php echo $post->getIdPost() ?>" <?php */ ?> class="btn btn-small btn-clear">Modifier</a>
                <button class="btn btn-small btn-danger delete-comment" value="<?php echo $comment->getIdComment() ?>">Supprimer</button>
            </div>
            <?php
        }
        ?>
    </div>
</div>