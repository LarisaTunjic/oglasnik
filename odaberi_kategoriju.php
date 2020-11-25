<?php 
	include 'header.php';
?>
<div class="kategorije ">
	<div class="container">
		<div class="search-wrapper">
			<h1> Kreiranje novog oglasa </h1>
		</div>

		<div class="pb-5">
			<i class="pinn"></i>
			<blockquote class="note yellow">
				<div>Odaberite kategoriju: </div>
				<form class="select_kat" action="dodaj_oglas?id_kat=<?php $id_pod?>&id_pod=< method="post">

					<select id="sel_kat">
						<option value="0">- Select -</option>
						<?php 
							
							$sqlKAT = "SELECT id_kategorija, naziv FROM kategorija WHERE nadkategorija_id IS NULL";
							$result = mysqli_query($conn,$sqlKAT);
							while($row = mysqli_fetch_assoc($result) ){
								$id_kat = $row['id_kategorija'];
								$naziv = $row['naziv'];
								
								
								echo "<option value='".$id_kat."' >".$naziv."</option>";
							}
						?>
					</select>
					<div class="clear"></div>

					<select id="sel_pod">
						<option value="0">- Select -</option>
					</select>
					<div class="clear"></div>

					<select id="sel_pod2">
						<option value="0">- Select -</option>
					</select><br>
					<a id="id_ZaPodkategoriju" href="" class="btn btn-primary btn-lg active" role="button"
						aria-pressed="true">Nastavi</a>
				</form>
			</blockquote>
		</div>
	</div>
</div>
<?php
require "footer.php";
?>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

    <script>
    $(document).ready(function () {
        $("#sel_kat").change(function () {
            var katid = $(this).val();
            $.ajax({
                url: 'sel_podkat.php',
                type: 'post',
                data: {
                    id_kategorija: katid
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    $("#sel_pod").empty();
                    $("#sel_pod2").empty();
                    $("#sel_pod").append("<option selected disabled value='0'>" +
                        "odaberite kategoriju" + "</option>");
                    $("#sel_pod2").append("<option selected disabled value='0'>" +
                        "odaberite kategoriju" + "</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id_kategorija'];
                        var naziv = response[i]['naziv'];

                        $("#sel_pod").append("<option value='" + id + "'>" + naziv +
                            "</option>");

                    }
                }
            });
        });
    });
</script>
<script>
$(document).ready(function () {
    $("#sel_pod").change(function () {
        var podid = $(this).val();
        $.ajax({
            url: 'sel_podkat2.php',
            type: 'post',
            data: {
                id_kategorija: podid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                $("#sel_pod2").empty();
                $("#sel_pod2").append("<option selected disabled value='0'>" + "odaberite kategoriju" + "</option>");
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id_kategorija'];
                    var name = response[i]['naziv'];
                    $("#sel_pod2").append("<option value='" + id + "'>" + name + "</option>");
                }
            }
        });
    });
});
</script>

<script>
    $(document).ready(function () {
        $("#sel_kat").change(function () {
                $("#id_ZaPodkategoriju").attr('href', "dodaj_oglas.php?id=" + this.value + "&pod_id=0" + "&pod_id2=0");
                $("#sel_pod").empty();
                if ($("#sel_pod option[value='0']")) {
                    $("#id_ZaPodkategoriju").removeClass("d-block");
        
                }
                if ($("#sel_pod2 option[value='0']")) {
                    $("#id_ZaPodkategoriju").removeClass("d-block");
                }
                setTimeout(function() { 
                    if ($("#sel_pod option").length -1 > 1) {
                        $("#id_ZaPodkategoriju").removeClass("d-block");
                    } 
                    else if ($("#sel_kat").val() == 0 ) {
                        $("#id_ZaPodkategoriju").removeClass("d-block");
                    }
                    else  {
                        $("#id_ZaPodkategoriju").addClass("d-block");
                    }
                    }, 50);
                });
        $("#sel_pod").change(function () {
            var value1 = $("#sel_kat").val();
            $("#id_ZaPodkategoriju").attr('href', "dodaj_oglas.php?id=" + value1 + "&pod_id=" + this.value + "&pod_id2=0");

            setTimeout(function() { 
                if (($("#sel_pod2 option").length - 1 > 1) || $("#sel_pod2").val() == null) {
                $("#id_ZaPodkategoriju").removeClass("d-block");
            } 
            else if ($("#sel_pod2").val() == 0) {
                $("#id_ZaPodkategoriju").addClass("d-block");
            }
            else {
                $("#id_ZaPodkategoriju").addClass("d-block");
            }
            }, 50);

        });
        $("#sel_pod2").change(function () {
            var value1 = $("#sel_kat").val();
            var value2 = $("#sel_pod").val();
            $("#id_ZaPodkategoriju").attr('href', "dodaj_oglas.php?id=" + value1 + "&pod_id=" + value2 + "&pod_id2=" + this.value);
            $("#id_ZaPodkategoriju").addClass("d-block");
        });

    });
</script>