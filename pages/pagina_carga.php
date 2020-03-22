<br><br><br><br><br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>
<input value="<?= $_GET['id'] ?>" id="id" hidden>
<script>
    var time = 1500;
    var id = document.getElementById('id').value;
    setTimeout(function() {
        window.location = "index.php?page=details_auto&id=" + id;
    }, time);
</script>