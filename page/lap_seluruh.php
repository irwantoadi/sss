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
	        <div class="panel-heading"><img class="kiri" src ="LOGO.png"><h3 class="text-center">Laporan Nilai Seluruh Mahasiswa</h3></div>
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
				</form>
	            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
				<?php
				$q = $connection->query("SELECT b.kd_beasiswa, b.nama_bsw, h.nilai, m.nama_mhs AS mahasiswa, m.nim, (SELECT MAX(nilai) FROM hasil WHERE nim=h.nim) AS nilai_max FROM mahasiswa m JOIN hasil h ON m.nim=h.nim JOIN beasiswa b ON b.kd_beasiswa=h.kd_beasiswa WHERE m.tahun_mengajukan='$_POST[tahun]'");
				// $beasiswa = []; $data = []; $d = [];
				while ($r = $q->fetch_assoc()) {
					// $beasiswa[$r["kd_beasiswa"]] = $r["nama_bsw"];
					// $s = $connection->query("SELECT b.nama, a.nilai FROM hasil a JOIN beasiswa b USING(kd_beasiswa) WHERE a.nim=$r[nim] AND a.tahun=$_POST[tahun]");
					// while ($rr = $s->fetch_assoc()){
						// $d[$rr['nama']] = $rr['nilai'];
					// }
					// $m = max($d);
					// $k = array_search($m, $d);
					// $data[$r["nim"]."-".$r["mahasiswa"]."-".$r["nilai_max"]."-".$k][$r["kd_beasiswa"]] = $r["nilai"];
					$nilai_max = $r["nilai_max"];
				}
				?>
				<hr>
				<table class="table table-condensed">
	                <thead>
	                    <tr>
	                    	<th>No</th>
							<th>NIM</th>
							<th>Nama</th>
							<?php //foreach ($beasiswa as $val): ?>
		                        <!-- <th><?=$val?></th> -->
							<?php //endforeach; ?>
							<th>Beasiswa</th>
							<th>Nilai</th>
							<th>Status</th>
	                    </tr>
	                </thead>
					<tbody>
						<?php $no = 1; ?>
					<?php
						$q = $connection->query("SELECT b.kd_beasiswa, b.nama_bsw, h.nilai, h.status, m.nama_mhs AS mahasiswa, m.nim, (SELECT MAX(nilai) FROM hasil WHERE nim=h.nim) AS nilai_max FROM mahasiswa m JOIN hasil h ON m.nim=h.nim JOIN beasiswa b ON b.kd_beasiswa=h.kd_beasiswa WHERE m.tahun_mengajukan='$_POST[tahun]' ORDER BY mahasiswa");

						// tes code //
						echo "SELECT b.kd_beasiswa, b.nama_bsw, h.nilai, h.status, m.nama_mhs AS mahasiswa, m.nim, (SELECT MAX(nilai) FROM hasil WHERE nim=h.nim) AS nilai_max FROM mahasiswa m JOIN hasil h ON m.nim=h.nim JOIN beasiswa b ON b.kd_beasiswa=h.kd_beasiswa WHERE m.tahun_mengajukan='$_POST[tahun]' ORDER BY mahasiswa";
						// end tes code //

						while ($r = $q->fetch_assoc()) {
							// $nilai_max = $r["nilai_max"];
					?>
	                    <tr>
	                    	<td><?=$no++?></td>
							<td><?php echo $r['nim']; ?></td>
							<td><?php echo $r['mahasiswa']; ?></td>
							<td><?php echo $r['nama_bsw']; ?></td>
							<td><?php echo number_format((float) $r["nilai"], 8, '.', ''); ?></td>
							<td><?php echo $r['status']; ?></td>
	                    </tr>
					<?php
						}
					?>
					</tbody>
		            </table>
	            <?php endif; ?><br>
	          <button class="btn btn-primary" onclick="myFunction()">Cetak Halaman</button>
	        </div>
	    </div>
	</div>
</div>
