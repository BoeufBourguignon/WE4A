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
                <?php
                $date = $comment->getDateModification() == null
                    ? $comment->getDateComment()
                    : $comment->getDateModification();
                $str = $comment->getDateModification() == null
                    ? "Posté"
                    : "Modifié";
                ?>
                <p class="muted txt-small">· <?php echo $str ?> il y a <?php
                    echo Src\Utils::getDateInterval($date)
                    ?></p>
                <span class="tooltiptext txt-small"><?php echo "Le ".
                        (new \DateTime($date))->format("d/m/Y à H:i") ?></span>
            </div>
        </div>
    </div>
    <div class="comment-content" data-is-deleted="<?php echo $comment->isDeleted() ?>">
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
    <?php
    if(!$comment->isDeleted())
    {
        ?>
        <div class="comment-footer">
            <?php
            if($this->auth->getUser() != null && $this->auth->getUser()->getIdUser() == $comment->getIdUser())
            {
                ?>
                <div>
                    <a class="btn btn-small btn-clear" href="/comment/edit/<?php echo $comment->getIdComment() ?>">
                        Modifier</a>
                    <button class="btn btn-small btn-danger delete-comment"
                            value="<?php echo $comment->getIdComment() ?>">Supprimer</button>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>