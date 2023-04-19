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
                ?>
                <div class="post pointer" onclick="window.location='/post/<?php echo $post->getIdPost() ?>'">
                    <?php
                    include(VIEWS."/Post/includes/incPost.php");

                    if($this->auth->getUser() !== null)
                    {
                        include(VIEWS."/Post/includes/postFooter.php");
                    }
                    ?>
                </div>
                <?php
            }
        }
    }
    ?>
</div>
