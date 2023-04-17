<?php
/**
 * @var ?Model\Category $categ
 * @var string $categName
 * @var array $posts
 */
?>

<div id="canvas">
    <?php
    if ($categ == null)
    {
        ?>
        <div class="post">
            <p>La catégorie <span class="txt-orange"><?php echo $categName ?></span> n'existe pas</p>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="post">
            <p>Tous les posts de la catégorie <span class="txt-orange"><?php echo $categName ?></span></p>
        </div>
        <?php
        if (count($posts) == 0)
        {
            ?>
            <div class="post">
                <p>Il n'y a pas de posts pour l'instant</p>
            </div>
            <?php
        }
        else
        {
            /** @var Model\Post $post */
            foreach ($posts as $post)
            {
                include(VIEWS . "/Post/showPost.php");
            }
        }
    }
    ?>
</div>
