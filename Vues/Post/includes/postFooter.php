<?php
/**
 * @var Model\Post $post
 */
?>
<div class="post-footer">
    <a id="modify-post" href="/post/edit/<?php echo $post->getIdPost() ?>" class="btn btn-clear">Modifier</a>
    <a id="comment-post" class="btn btn-clear">Commentaire(s) (<?php echo $post->getNbComment() ?>)</a>
    <?php
    if($this->auth->getUser()->getIdUser() == $post->getIdUser())
    {
        ?>
        <a id="delete-post" class="btn btn-clear">Supprimer</a>
        <?php
    }
    ?>
</div>