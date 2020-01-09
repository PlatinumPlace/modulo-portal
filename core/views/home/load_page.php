<br> <br> <br> <br> <br> <br>
<div class='container'>
    <div class="center-align" id="load_page">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>
</div>

<input type="text" value="<?= $_GET['id'] ?>" id="id" hidden>

<input type="text" value="<?= $_GET['destiny'] ?>" id="destiny" hidden>

<script>
    var time = 1000;
    var destiny = document.getElementById('destiny').value;
    var id = document.getElementById('id').value;
    setTimeout(function() {
        window.location = "?page=" + destiny + "&id=" + id;
    }, time);
</script>
<br> <br> <br> <br>