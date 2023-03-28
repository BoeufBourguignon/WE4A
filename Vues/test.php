<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    axios({
        method:'get',
        url:'/ajax/test'
    })
        .then(function(resp) {
            console.log(resp.data)
        })

</script>