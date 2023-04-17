<?php
/**
 * @var ?Model\User $user
 * @var string $username
 * @var array $posts
 */
?>

<div id="canvas">
    <?php
    if($user == null)
    {
        ?>
        <div class="post">
            <p>L'utilisateur <span class="txt-orange"><?php echo $username ?></span> n'existe pas</p>
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="post">
            <p>Tous les posts de l'utilisateur <span class="txt-orange"><?php echo $username ?></span></p>
        </div>
        <?php
        if(count($posts) == 0)
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
            foreach($posts as $post)
            {
                include(VIEWS."/Post/showPost.php");
            }
        }
    }
    ?>
</div>
