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
	    <div class="panel panel-info">
	        <div class="panel-heading"><img class="kiri" src ="LOGO.png"><h3 class="text-center">Laporan Nilai Per Mahasiswa</h3></div>
	        <div class="panel-body">
							<form class="form-inline" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
								<label for="mhs">Mahasiswa :</label>
								<select class="form-control" name="mhs">
									<?php 
										//jika yg login admin
										if ($_SESSION['as'] == 'admin') {
											$q = $connection->query("SELECT * FROM mahasiswa WHERE nim IN(SELECT nim FROM hasil)");
										}else{
											//jika bukan admin
											// echo $_SESSION['as'];
											$q = $connection->query("SELECT * FROM mahasiswa LEFT JOIN pengguna ON mahasiswa.kd_pengguna = pengguna.kd_pengguna WHERE nim IN(SELECT nim FROM hasil) AND username='$_SESSION[username]'");
										}
										
									 while ($r = $q->fetch_assoc()): 
									?>
									<?php //$q = $connection->query("SELECT * FROM mahasiswa WHERE nim IN(SELECT nim FROM hasil)"); while ($r = $q->fetch_assoc()): ?>
										<option value="<?=$r["nim"]?>"><?=$r["nim"]?> | <?=$r["nama_mhs"]?></option>
									<?php endwhile; ?>
								</select>
								<button type="submit" class="btn btn-primary">Tampilkan</button>
							</form>
	            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
								<?php
								$q = $connection->query("SELECT b.kd_beasiswa, b.nama_bsw, h.nilai, (SELECT MAX(nilai) FROM hasil WHERE nim=h.nim) AS nilai_max FROM mahasiswa m JOIN hasil h ON m.nim=h.nim JOIN beasiswa b ON b.kd_beasiswa=h.kd_beasiswa WHERE m.nim=$_POST[mhs]");
								$beasiswa = []; $data = [];
								while ($r = $q->fetch_assoc()) {
									$beasiswa[$r["kd_beasiswa"]] = $r["nama_bsw"];
									$data[$r["kd_beasiswa"]][] = $r["nilai"];
									$max = $r["nilai_max"];
								}
								?>
								<hr>
								<!-- <table class="table table-condensed"> -->
									<!-- <tbody> -->
										<?php //$query = $connection->query("SELECT DISTINCT(p.kd_beasiswa), k.nama_bsw, n.nilai FROM nilai n JOIN penilaian p USING(kd_kriteria) JOIN kriteria k USING(kd_kriteria) WHERE n.nim=$_POST[mhs] AND n.kd_beasiswa=1"); while ($r = $query->fetch_assoc()): ?>
											<!-- <tr> -->
												<!-- <th><?//=$r["nama_bsw"]?></th> -->
												<!-- <td>: <?//=number_format($r["nilai"], 8)?></td> -->
											<!-- </tr> -->
										<?php //endwhile; ?>
									<!-- </tbody> -->
								<!-- </table> -->
								<!-- <hr> -->
								<b>Identitas :</b><br>
								<table class="table table-condensed">
									<tbody>
										<?php $query = $connection->query("SELECT * FROM `mahasiswa` WHERE nim=$_POST[mhs]"); while ($r = $query->fetch_assoc()): ?>
											<tr>
												<td>NIM</td>
												<td>:</td>
												<td><?=$r["nim"]?></td>
											</tr>
											<tr>
												<td>Nama</td>
												<td>:</td>
												<td><?=$r["nama_mhs"]?></td>
											</tr>
											<tr>
												<td>Semester</td>
												<td>:</td>
												<td><?=$r["semester"]?></td>
											</tr>
											<tr>
												<td>Alamat</td>
												<td>:</td>
												<td><?=$r["alamat"]?></td>
											</tr>
											<tr>
												<td>Jenis Kelamin</td>
												<td>:</td>
												<td><?=$r["jenis_kelamin"]?></td>
											</tr>
											<tr>
												<td>Jurusan</td>
												<td>:</td>
												<td><?=$r["jurusan"]?></td>
											</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
								<hr>
								<b>Penilaian :</b><br>
								<table class="table table-condensed">
									<tbody>
										<?php $query = $connection->query("SELECT * FROM `nilai` LEFT JOIN mahasiswa ON nilai.nim = mahasiswa.nim LEFT JOIN kriteria ON nilai.kd_kriteria = kriteria.kd_kriteria LEFT JOIN pembobotan ON (nilai.kd_kriteria = pembobotan.kd_kriteria AND nilai.nilai = pembobotan.bobot_nilai) WHERE nilai.nim=$_POST[mhs]"); while ($r = $query->fetch_assoc()): ?>
											<tr>
												<td><?=$r['nama_ktra'] ?></td>
												<td>:</td>
												<td><?=$r['keterangan'] ?></td>
											</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
								<hr>
								<b>Hasil :</b><br>
								<table class="table table-condensed">
		                <thead>
		                    <tr>
													<?php foreach ($beasiswa as $key => $val): ?>
			                        <th><?=$val?></th>
													<?php endforeach; ?>
													<!-- <th>Nilai Maksimal</th> -->
		                    </tr>
		                </thead>
		                <tbody>
											<tr>
                        <?php foreach($beasiswa as $key => $val): ?>
	                        <?php foreach($data[$key] as $v): ?>
															<td>Nilai Akhir : <?=number_format($v, 8)?></td>
													<?php endforeach ?>
												<?php endforeach ?>
												<!-- <td><?=number_format($max, 8)?></td> -->
											</tr>
		                </tbody>
		            </table>
	            <?php endif; ?><br>
	          <button class="btn btn-primary" onclick="myFunction()">Cetak Halaman</button>
	        </div>
	    </div>
	</div>
</div>
