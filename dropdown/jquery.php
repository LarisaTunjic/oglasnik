<?php 
	include 'header.php';
?>

<div class="form-group col-md-4">
  <label for="podkategorije">Podkategorije (selektiraj i pretraži)</label>
  <select id="podkategorije" class="form-control">
    <option selected>Odaberite podkategorijiu</option>
    <option value="oglasi_kategorije.php?id=1">Jedan</option>
    <option value="oglasi_kategorije.php?id=2">Dva</option>
    <option value="oglasi_kategorije.php?id=3">Tri</option>
  </select>
</div>
<div class="form-group col-md-12">
    <a  id="id_ZaPodkategoriju" href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Pretraži</a>
</div>

<script>
	$(document).ready(function(){
		$("#podkategorije").change(function () {
		console.log(this.value);
		$("#id_ZaPodkategoriju").attr('href', this.value);
		});
	});
</script>