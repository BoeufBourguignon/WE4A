<?php
/**
 * @var Model\Post $post
 */
?>
<div class="post-footer">
    <?php
    if (!isset($isShowPost) || !$isShowPost)
    {
        ?>
        <a id="comment-post" class="btn btn-clear" href="/post/<?php echo $post->getIdPost() . "#comments" ?>">Commentaires (<?php echo $post->getNbComment() ?>)</a>
        <?php
    }
    ?>
    <?php
    if($this->auth->getUser() != null && $this->auth->getUser()->getIdUser() == $post->getIdUser())
    {
        ?>
        <div>
            <a id="modify-post" href="/post/edit/<?php echo $post->getIdPost() ?>" class="btn btn-small btn-clear">Modifier</a>
            <button class="btn btn-small btn-danger delete-post" value="<?php echo $post->getIdPost() ?>">Supprimer</button>
        </div>
        <?php
    }
    ?>
</div>