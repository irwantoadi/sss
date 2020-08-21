<style>
   .kiri {
     width: 70px;
     height: 60px;
     float:left;
     display: block;
   }

</style>
<div class="row">
	<div class="col-md-12">
	<?php 
		//jika klik menu perhitungan > (nama_beasiswa)
		if (isset($_GET["beasiswa"])) {		
			$sqlKriteria = "";
			$namaKriteria = [];
			$queryKriteria = $connection->query("SELECT a.kd_kriteria, a.nama_ktra FROM kriteria a JOIN pembobotan b USING(kd_kriteria) WHERE b.kd_beasiswa=$_GET[beasiswa]");
			while ($kr = $queryKriteria->fetch_assoc()) {
				$sqlKriteria .= "SUM(
					IF(
						c.kd_kriteria=".$kr["kd_kriteria"].",
						IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization/nilai.nilai), 0
					)
				) AS ".strtolower(str_replace(" ", "_", $kr["nama_ktra"])).",";
				$namaKriteria[] = strtolower(str_replace(" ", "_", $kr["nama_ktra"]));
			}
				
			
		
	?>
	  <div class="panel panel-info">
	      <div class="panel-heading"><img class="kiri" src ="LOGO.png"><h3 class="text-center"><h2 class="text-center">
	      	<?php 
	      		$query = $connection->query("SELECT * FROM beasiswa WHERE kd_beasiswa=$_GET[beasiswa]"); 
	      		while ($data = $query->fetch_assoc()) {
	      			$kuota = $data["kuota"];
					  
					// menampilkan judul nama beasiswa
					echo $data["nama_bsw"];
	      		} 
	      		 // $query->fetch_assoc()["nama"]; 

	      		//penomoran baris
	      		$x = 1;  

	      		//posisi rangking
	      		$rank = 0;

	      		//nilai sebelumnya
	      		$prev_nilai = 2.0;

	      		//set nilai minimal yg diterima
	      		$nilai_min = 0;
	      	?>
	      	</h2></h3></div>
	      <div class="panel-body">
		  		<form class="form-inline" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
					<label for="tahun">Tahun :</label>
					<select class="form-control" name="tahun">
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
					</select>
					<button type="submit" class="btn btn-primary">Tampilkan</button>
				</form><br>
			<?php
				//jika ada request method (pilih tahun)
				if ($_SERVER["REQUEST_METHOD"] == "POST"){
					$sql = "SELECT
						(SELECT nama_mhs FROM mahasiswa WHERE nim=mhs.nim) AS nama,
						(SELECT nim FROM mahasiswa WHERE nim=mhs.nim) AS nim,
						(SELECT jurusan FROM mahasiswa WHERE nim=mhs.nim) AS jurusan,
						(SELECT tahun_mengajukan FROM mahasiswa WHERE nim=mhs.nim AND tahun_mengajukan = 2020) AS tahun,
						$sqlKriteria
						SUM(
							IF(
									c.sifat = 'max',
									nilai.nilai / c.normalization,
									c.normalization / nilai.nilai
							) * c.bobot
						) AS rangking
					FROM
						nilai
						RIGHT JOIN mahasiswa mhs USING(nim)
						JOIN (
							SELECT
									nilai.kd_kriteria AS kd_kriteria,
									kriteria.sifat AS sifat,
									(
										SELECT bobot_model FROM pembagian_nilai WHERE kd_kriteria=kriteria.kd_kriteria AND kd_beasiswa=beasiswa.kd_beasiswa
									) AS bobot,
									ROUND(
										IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1
									) AS normalization
								FROM nilai
								JOIN kriteria USING(kd_kriteria)
								JOIN beasiswa ON kriteria.kd_beasiswa=beasiswa.kd_beasiswa
								LEFT JOIN mahasiswa ON nilai.nim = mahasiswa.nim
								WHERE beasiswa.kd_beasiswa=$_GET[beasiswa]
							GROUP BY nilai.kd_kriteria
						) c USING(kd_kriteria)
					WHERE kd_beasiswa=$_GET[beasiswa] AND tahun_mengajukan = '$_POST[tahun]'
					GROUP BY nilai.nim
					ORDER BY rangking DESC"; 
			?>
	          <table class="table table-condensed table-hover">
	              <thead>
	                  <tr>
	                  		<th>No.</th>
							<th>NIM</th>
							<th>Nama</th>
							<?php //$query = $connection->query("SELECT nama FROM kriteria WHERE kd_beasiswa=$_GET[beasiswa]"); while($row = $query->fetch_assoc()): ?>
								<!-- <th><?//=$row["nama"]?></th> -->
							<?php //endwhile ?>
							<th>Jurusan</th>
							<th>Nilai Akhir</th>
							<th>Rangking</th>
							<th>Status</th>
							<th>Tahun Mengajukan</th>
	                  </tr>
	              </thead>
	              <tbody>
					<?php $query = $connection->query($sql); while($row = $query->fetch_assoc()): ?>
					<?php

					//set nilai utk perankingan
					$rangking = number_format((float) $row["rangking"], 8, '.', '');
					// echo $rangking;

					//if nilai == prev_nilai, maka posisi rangking sama, else posisi rangking + 1
					($rangking == $prev_nilai) ? $rank : ++$rank;

					$q = $connection->query("SELECT nim FROM hasil WHERE nim='$row[nim]' AND kd_beasiswa='$_GET[beasiswa]' AND tahun='$row[tahun]'");

							//jika jumlah baris == kuota, maka simpan sebagai nilai minimal yg diterima
							if($x == $kuota){
								$nilai_min = $rangking;
							}

							//jika nilai >= nilai_minimal yg diterima
							if($rangking >= $nilai_min){
								$status = "Diterima";
							}else{
								$status = "Tidak Diterima";
							} 

					if (!$q->num_rows) {
					//jika data belum ada
					$connection->query("INSERT INTO hasil VALUES(NULL, '$_GET[beasiswa]', '$row[nim]', '".$rangking."', '$row[tahun]', '".$status."')");
					}else {
					//jika data sudah ada
					$connection->query("UPDATE hasil SET nilai='$rangking', status='$status' WHERE kd_beasiswa='$_GET[beasiswa]' AND nim='$row[nim]'");
					}
					?>
					<tr>
						<td><?=$x?></td>
						<td><?=$row["nim"]?></td>
						<td><?=$row["nama"]?></td>
						<td><?=$row["jurusan"]?></td>
						<?php for($i=0; $i<count($namaKriteria); $i++): ?>
						<!-- <th><?//=number_format((float) $row[$namaKriteria[$i]], 8, '.', '');?></th> -->
						<?php endfor ?>
						<td><?=$rangking?></td>
						<!-- <td><?=$row["nilai"]?></td> -->
						<td><?php echo $rank; ?></td>
						<td><?php echo $status;	?></td>
						<td><?php echo $row['tahun'];	?></td>
					</tr>
					<?php 

						$x++; 
						$prev_nilai = $rangking; 
						endwhile;
						
				}else {
					//jika tidak ada request method (pilih tahun)
				}
				//tes code
				// echo $sql;
					?>
	              </tbody>
	          </table>
	          <button class="btn btn-primary" onclick="myFunction()">Cetak Halaman</button>
	      </div>
	  </div>
	<?php } else { ?>
		<h1>Beasiswa belum dipilih...</h1>
	<?php } ?>
	</div>
</div>
