<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["is_logged"])) {
  header('location: login.php');
}
// echo $_SESSION['as'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beasiswa</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.chained.min.js"></script>
    <style>
        body {
            margin-top: 20px;
            background-color: #20B2AA;
        }

    </style>

    <script>
    function myFunction() {
      window.print();
    }
    </script>
</head>
<body>    
    <div class="container">
        <nav class="navbar navbar-default" style="background-color: #d9edf7">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><?php $str = (isset($_GET["page"])) ? (($_GET["page"] == "nilai") ? "Penilaian" : $_GET["page"]) : "home"; echo strtoupper($str)?></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="?page=home">Beranda <span class="sr-only">(current)</span></a></li>
                         <?php if ($_SESSION['as'] == 'admin') { ?>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Input <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <!--<li class="divider"></li> -->
                                <li><a href="?page=mahasiswa">Data Mahasiswa</a></li>
                                <li><a href="?page=beasiswa">Data Beasiswa</a></li>
                                <li><a href="?page=kriteria">Kriteria</a></li>
                                <li><a href="?page=pembagian_nilai">Pembagian nilai</a></li>
                                <li><a href="?page=pembobotan">Pembobotan</a></li>
                                <li><a href="?page=nilai">Penilaian</a></li>
                              </ul>
                            </li>
                            <?php } ?>
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perhitungan <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <?php $query = $connection->query("SELECT * FROM beasiswa"); while ($row = $query->fetch_assoc()): ?>
                                <li><a href="?page=perhitungan&beasiswa=<?=$row["kd_beasiswa"]?>"><?=$row["nama_bsw"]?></a>
                                </li>
                                <?php endwhile; ?>
                                </ul>
                            </li>
                        
                         <!-- <?php if ($_SESSION['as'] == 'pimpinan') { ?>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Input <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="?page=mahasiswa">Data Mahasiswa</a></li>
                                <li><a href="?page=beasiswa">Data Beasiswa</a></li>
                                <li><a href="?page=kriteria">Kriteria</a></li>
                                <li><a href="?page=pembagian_nilai">Pembagian nilai</a></li>
                                <li><a href="?page=pembobotan">Pembobotan</a></li>
                                <li><a href="?page=nilai">Penilaian</a></li>
                              </ul>
                            </li>
                        <?php } ?> -->
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <?php if ($_SESSION['as'] != 'mahasiswa') { ?>
                            <?php if ($_SESSION['as'] != 'pimpinan') { ?>
                                <li><a href="?page=lap_mahasiswa">Data Mahasiswa</a></li> 
                            <?php } ?>   
                            <?php } ?>
                            <?php if ($_SESSION['as'] != 'mahasiswa') { ?>
                            <?php if ($_SESSION['as'] != 'pimpinan') { ?>
                                <li><a href="?page=lap_beasiswa">Data Beasiswa</a></li> 
                            <?php } ?>   
                            <?php } ?>
                            <?php if ($_SESSION['as'] != 'mahasiswa') { ?>
                            <?php if ($_SESSION['as'] != 'pimpinan') { ?>
                                <li><a href="?page=lap_kriteria">Data Kriteria</a></li> 
                            <?php } ?>   
                            <?php } ?>
                            <?php if ($_SESSION['as'] != 'mahasiswa') { ?>
                            <?php if ($_SESSION['as'] != 'pimpinan') { ?>
                                <li><a href="?page=lap_pembagiannilai">Data Pembagian Nilai</a></li> 
                            <?php } ?>   
                            <?php } ?>
                            <?php if ($_SESSION['as'] != 'mahasiswa') { ?>
                            <?php if ($_SESSION['as'] != 'pimpinan') { ?>
                                <li><a href="?page=lap_pembobotan">Data Pembobotan</a></li> 
                            <?php } ?>   
                            <?php } ?>
                            <li><a href="?page=lap_permahasiswa">Per Mahasiswa</a></li>
                            <?php if ($_SESSION['as'] != 'mahasiswa') { ?>
                            <li><a href="?page=lap_seluruh">Seluruh Mahasiswa</a></li>
                            <?php } ?>
                          </ul>
                        </li>
                        <!--<li><a href="?page=pengumuman">Pengumuman</a></li> -->
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="#">|</a></li>
                        <li><a href="#" style="font-style:tahoma ;font-weight: bold; color: #DC143C;"><?= ucfirst($_SESSION["username"]) ?></a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="row">
            <div class="col-md-12">
              <?php include page($_PAGE); ?>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
