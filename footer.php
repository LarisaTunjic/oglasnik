<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Korisnička podrška</h2>
                    <p> <a href="tel:08008000">0800 84 88</a>
                    
                        <a class="underline-link" href="mailto:oglasnik@podrska.hr">oglasnik@podrska.hr</a><br>
                    </p>
                    <p>Radno vrijeme:
                        08:00 - 20:00h
                    </p>
                </div>
                <div class="col-md-4">
                    <h2 class="h2-tags">Izdvojeno</h2>
                    <div class="tags">
                        <div class="wrap-tags d-flex justify-content-between flex-wrap">
                            <a href="http://localhost//oglasnik/kategorije.php">Kategorije</a>
                            <?php
                                if (isset($_SESSION['kor_id']) && isset($_SESSION['kor_ime'])){
                                    echo"<a href='http://localhost//oglasnik/odaberi_kategoriju.php'>Predaj oglas</a>";
                                }else{
                                    echo "<a href='registracija.php'>Predaj oglas</a>";
                                }
                            ?>
                            <a href="http://localhost//oglasnik/svi_oglasi.php">Svi oglasi</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-social-wrapper">
                        <h2>Pratite nas</h2>
                        <div class="footer-social-icons-wrapper mb-3">
                            <div class="d-table-cell">
                                <a target="_blank" href="https://www.facebook.com/oglasnik.hr"><i class="fab fa-facebook-f"></i></a>
                                <a target="_blank" href="https://www.instagram.com/oglasnik/"><i class="fab fa-instagram"></i></a>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <div class="subfooter">
        <div class="container">
            <a href="http://localhost//oglasnik/pravila_o_privatnosti.php">Pravila o privatnosti</a> - 
            <!-- <a href="#">menu.termsOfUse</a> -->
            <a href="http://localhost//oglasnik/pravila_o_kolacicima.php">Pravila o kolačićima</a>
        </div>
    </div>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>