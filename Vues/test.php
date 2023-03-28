<?php
/**
 * @var $categ
 */
?>
<script>
    axios({
        method:'get',
        url:'/ajax/searchCateg/<?php echo $categ ?>'
    })
        .then(function(resp) {
            console.log(resp.data)
        })

</script>