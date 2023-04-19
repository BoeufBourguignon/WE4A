<?php
/**
 * @var Model\Post $post
 */
?>
<div class="post-footer">
    <a id="comment-post" class="btn btn-clear">Commentaire(s) (<?php echo $post->getNbComment() ?>)</a>
    <?php
    if($this->auth->getUser() != null && $this->auth->getUser()->getIdUser() == $post->getIdUser())
    {
        ?>
        <a id="modify-post" href="/post/edit/<?php echo $post->getIdPost() ?>" class="btn btn-clear">Modifier</a>
        <button class="btn btn-danger delete-post" value="<?php echo $post->getIdPost() ?>">Supprimer</button>
        <?php
    }
    ?>
</div>