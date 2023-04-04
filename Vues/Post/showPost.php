<?php
/**
 * @var Model\Post $post
 */
?>
<div class="post">
    <p>Posté par : <?php echo $post->getUser()->getUsername() ?></p>
    <p>Le : <?php echo $post->getDatePost() ?></p>
    <p>Catégorie : <?php echo $post->getCategory()->getNameCategory() ?></p>
    <h1><?php echo $post->getTitle() ?></h1>
    <p><?php echo $post->getContent() ?></p>
</div>
