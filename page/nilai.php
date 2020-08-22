<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;

//jika tombol edit diklik
if ($update) {
	// $sql_string = "SELECT * FROM nilai JOIN penilaian USING(kd_kriteria) WHERE kd_nilai='$_GET[key]'";
	$sql_string = "SELECT * FROM nilai JOIN pembobotan USING(kd_kriteria) WHERE kd_nilai='$_GET[key]' AND nilai.nilai = pembobotan.bobot_nilai";
	$sql = $connection->query($sql_string);
	// echo $sql_string."<br>";
	$row = $sql->fetch_assoc();
	// echo $row["kd_penilaian"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST["save"])) {
	$validasi = false; $err = false;
	if ($update) {
		// $sql = "UPDATE nilai SET kd_kriteria='$_POST[kd_kriteria]', nim='$_POST[nim]', nilai='$_POST[nilai]' WHERE kd_nilai='$_GET[key]'";
		
		$set_nilai = null;
		foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
			// echo $nilai."<br>";
			// if($nilai != "---"){
				$set_nilai = $nilai;
			// }
		}
		$sql = "UPDATE nilai SET nilai='$set_nilai' WHERE kd_nilai='$_GET[key]'";
		// echo $sql;
	} else {
		$query = "INSERT INTO nilai VALUES ";
		foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
			$query .= "(NULL, '$_POST[kd_beasiswa]', '$kd_kriteria', '$_POST[nim]', '$nilai'),";
		}
		$sql = rtrim($query, ',');
		$validasi = true;
	}

	if ($validasi) {
		//cek jika nim sdh mendaftar salah satu beasiswa
		$q = $connection->query("SELECT nim FROM nilai WHERE nim=$_POST[nim]");
			if ($q->num_rows) {
				echo alert("Gagal, NIM ".$_POST["nim"]." sudah pernah mendaftar salah satu beasiswa!", "?page=nilai");
				$err = true;
			}

		foreach ($_POST["nilai"] as $kd_kriteria => $nilai) {
			$q = $connection->query("SELECT kd_nilai FROM nilai WHERE kd_beasiswa=$_POST[kd_beasiswa] AND kd_kriteria=$kd_kriteria AND nim=$_POST[nim] AND nilai LIKE '%$nilai%'");
			if ($q->num_rows) {
				echo alert("Nilai untuk ".$_POST["nim"]." sudah ada!", "?page=nilai");
				$err = true;
			}
		}
	}

	// echo $sql;
  if (!$err AND $connection->query($sql)) {
		echo alert("Berhasil!", "?page=nilai");
		// echo 'alert("Berhasil!", "?page=nilai")';
	} else {
		echo alert("Gagal!", "?page=nilai");
		// echo 'alert("Gagal!", "?page=nilai")';
	}
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM nilai WHERE kd_nilai='$_GET[key]'");
	echo alert("Berhasil!", "?page=nilai");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
					<div class="form-group">
						<label for="nim">Mahasiswa</label>
						<?php if ($_POST): ?>
							<input type="text" name="nim" value="<?=$_POST["nim"]?>" class="form-control" readonly="on">
						<?php else: ?>
							<select class="form-control" name="nim">
								<option>---</option>
								<?php $sql = $connection->query("SELECT * FROM mahasiswa"); 
								while ($data = $sql->fetch_assoc()): ?>
									<option value="<?=$data["nim"]?>" <?= (!$update) ? "" : (($row["nim"] != $data["nim"]) ? "" : 'selected="selected"') ?>><?=$data["nim"]?> | <?=$data["nama_mhs"]?>
									</option>
								<?php endwhile; ?>
							</select>
						<?php endif; ?>
					</div>
					<div class="form-group">
	                	<label for="kd_beasiswa">Beasiswa</label>
						<?php if ($_POST): ?>
							<?php $q = $connection->query("SELECT nama_bsw FROM beasiswa WHERE kd_beasiswa=$_POST[kd_beasiswa]"); ?>
							<input type="text"value="<?=$q->fetch_assoc()["nama_bsw"]?>" class="form-control" readonly="on">
							<input type="hidden" name="kd_beasiswa" value="<?=$_POST["kd_beasiswa"]?>">
						<?php else: ?>
							<select class="form-control" name="kd_beasiswa" id="beasiswa">
								<option>---</option>
								<?php $sql = $connection->query("SELECT * FROM beasiswa"); 
								while ($data = $sql->fetch_assoc()): ?>
									<option value="<?=$data["kd_beasiswa"]?>"<?= (!$update) ? "" : (($row["kd_beasiswa"] != $data["kd_beasiswa"]) ? "" : 'selected="selected"') ?>><?=$data["nama_bsw"]?></option>
								<?php endwhile; ?>
							</select>
						<?php endif; ?>
					</div>
					<?php if ($_POST): ?>
						<?php 
							//jika kondisi tidak edit maka SELECT semua kriteria dari beasiswa
							//jika kondisi edit maka SELECT hanya kriteria yang akan diedit
							(!$update) ? $q = $connection->query("SELECT * FROM kriteria WHERE kd_beasiswa=$_POST[kd_beasiswa]") : $q = $connection->query("SELECT * FROM `nilai` LEFT JOIN kriteria ON nilai.kd_kriteria = kriteria.kd_kriteria WHERE nilai.kd_nilai = '$_GET[key]'"); 
							while ($r = $q->fetch_assoc()): 
						?>
				            <div class="form-group">
					            <label for="nilai"><?=ucfirst($r["nama_ktra"])?></label>
								<select class="form-control" name="nilai[<?=$r["kd_kriteria"]?>]" id="nilai">
									<option>---</option>
									<?php $sql = $connection->query("SELECT * FROM pembobotan WHERE kd_kriteria=$r[kd_kriteria]"); while ($data = $sql->fetch_assoc()): ?>
									<option 
										value="<?=$data["bobot_nilai"]?>" 
										class="<?=$data["kd_kriteria"]?>"
										<?= (!$update) ? "" : (($row["kd_pembobotan"] != $data["kd_pembobotan"]) ? "" : ' selected="selected"') ?>><?=$data["keterangan"];
										?>	
									</option>
									<?php
										endwhile; 
									?>
								</select>
				            </div>
							<?php endwhile; ?>
							<input type="hidden" name="save" value="true">
					<?php endif; ?>
	                <button type="submit" id="simpan" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block"><?=($_POST) ? "Simpan" : "Tampilkan"?></button>
	                <?php if ($update): ?>
										<a href="?page=nilai" class="btn btn-info btn-block">Batal</a>
									<?php endif; ?>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR PENILAIAN</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
							<th>NIM</th>
							<th>Nama</th>
	                        <th>Beasiswa</th>
	                        <th>Kriteria</th>
	                        <th>Nilai</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT a.kd_nilai, c.nama_bsw AS nama_beasiswa, b.nama_ktra AS nama_kriteria, d.nim, d.nama_mhs AS nama_mahasiswa, a.nilai FROM nilai a JOIN kriteria b ON a.kd_kriteria=b.kd_kriteria JOIN beasiswa c ON a.kd_beasiswa=c.kd_beasiswa JOIN mahasiswa d ON d.nim=a.nim ORDER BY d.nama_mhs")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
								<td><?=$row['nim']?></td>
								<td><?=$row['nama_mahasiswa']?></td>
	                            <td><?=$row['nama_beasiswa']?></td>
	                            <td><?=$row['nama_kriteria']?></td>
	                            <td><?=$row['nilai']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=nilai&action=update&key=<?=$row['kd_nilai']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=nilai&action=delete&key=<?=$row['kd_nilai']?>" class="btn btn-danger btn-xs">Hapus</a>
	                                </div>
	                            </td>
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
<script type="text/javascript">
$("#kriteria").chained("#beasiswa");
$("#nilai").chained("#kriteria");
</script>
