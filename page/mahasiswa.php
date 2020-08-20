<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM mahasiswa LEFT JOIN pengguna ON mahasiswa.kd_pengguna = pengguna.kd_pengguna WHERE nim='$_GET[key]' ");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	$password = md5($_POST['password']);
	if ($update) {
		$sql0 = "UPDATE pengguna SET username='$_POST[username]', password='$password' WHERE kd_pengguna='$_POST[kd_pengguna]'";
		$connection->query($sql0);
		$sql = "UPDATE mahasiswa SET nim='$_POST[nim]', nama_mhs='$_POST[nama]', semester='$_POST[semester]', alamat='$_POST[alamat]', jenis_kelamin='$_POST[jenis_kelamin]', jurusan='$_POST[jurusan]',tahun_mengajukan='$_POST[tahun_mengajukan]' WHERE nim='$_GET[key]'";
	} else {
		$sql0 = "INSERT INTO pengguna VALUES ('', '$_POST[username]', '$password', 'mahasiswa')";
		$connection->query($sql0);
		$sql0 = $connection->query("SELECT * FROM pengguna WHERE username='$_POST[username]' AND password='$password' AND status='mahasiswa'");
		$row1 = $sql0->fetch_assoc();
		$kd = $row1['kd_pengguna'];
		$sql = "INSERT INTO mahasiswa VALUES ('$_POST[nim]', '$_POST[nama]', '$_POST[semester]', '$_POST[alamat]', '$_POST[jenis_kelamin]', '$_POST[tahun_mengajukan]', '$_POST[jurusan]', '$kd')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT nim FROM mahasiswa WHERE nim=$_POST[nim]");
		if ($q->num_rows) {
			echo alert($_POST["nim"]." sudah terdaftar!", "?page=mahasiswa");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
    echo alert("Berhasil!", "?page=mahasiswa");
  } else {
  		echo $sql;
		// echo alert("Gagal!", "?page=mahasiswa");
  }
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM mahasiswa WHERE nim=$_GET[key]");
	echo alert("Berhasil!", "?page=mahasiswa");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
	                <div class="form-group">
	                    <label for="nim">NIM</label>
	                    <input type="text" name="nim" class="form-control" <?= (!$update) ?: 'value="'.$row["nim"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="nama">Nama Lengkap</label>
	                    <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="'.$row["nama_mhs"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="nama">Semester</label>
	                    <input type="text" name="semester" class="form-control" <?= (!$update) ?: 'value="'.$row["semester"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="alamat">Alamat</label>
	                    <input type="text" name="alamat" class="form-control" <?= (!$update) ?: 'value="'.$row["alamat"].'"' ?>>
	                </div>
									<div class="form-group">
	                  <label for="jenis_kelamin">Jenis Kelamin</label>
										<select class="form-control" name="jenis_kelamin">
											<option>---</option>
											<option value="Laki-laki" <?= (!$update) ?: (($row["jenis_kelamin"] != "Laki-laki") ?: 'selected="on"') ?>>Laki-laki</option>
											<option value="Perempuan" <?= (!$update) ?: (($row["jenis_kelamin"] != "Perempuan") ?: 'selected="on"') ?>>Perempuan</option>
										</select>
									</div>
	                <div class="form-group">
	                    <label for="jurusan">Jurusan</label>
	                    <input type="text" name="jurusan" class="form-control" <?= (!$update) ?: 'value="'.$row["jurusan"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="jurusan">Tahun Mengajukan</label>
						<select class="form-control" name="tahun_mengajukan">
							<option>---</option>
							<option value="<?=date("Y")-3 ?>" <?= (!$update) ?: (($row["tahun_mengajukan"] != date("Y")-3) ?: 'selected="on"') ?>><?=date("Y")-3 ?></option>
							<option value="<?=date("Y")-2 ?>" <?= (!$update) ?: (($row["tahun_mengajukan"] != date("Y")-2) ?: 'selected="on"') ?>><?=date("Y")-2 ?></option>
							<option value="<?=date("Y")-1 ?>" <?= (!$update) ?: (($row["tahun_mengajukan"] != date("Y")-1) ?: 'selected="on"') ?>><?=date("Y")-1 ?></option>
							<option value="<?=date("Y") ?>" <?= (!$update) ?: (($row["tahun_mengajukan"] != date("Y")) ?: 'selected="on"') ?>><?=date("Y") ?></option>
							<option value="<?=date("Y")+1 ?>" <?= (!$update) ?: (($row["tahun_mengajukan"] != date("Y")+1) ?: 'selected="on"') ?>><?=date("Y")+1; ?></option>
						</select>
	                </div>
	                <div class="form-group">
	                    <label for="username">Username</label>
	                    <input type="text" name="username" class="form-control" <?= (!$update) ?: 'value="'.$row["username"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="password">Password</label>
	                    <input type="password" name="password" class="form-control" <?= (!$update) ?: 'value=""' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="konf_password">Konfirmasi Password</label>
	                    <input type="password" name="konf_password" class="form-control" <?= (!$update) ?: 'value=""' ?>>
	                </div>
	                <input type="hidden" name="kd_pengguna" <?= (!$update) ?: 'value="'.$row["kd_pengguna"].'"' ?>>
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=mahasiswa" class="btn btn-info btn-block">Batal</a>
									<?php endif; ?>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR MAHASISWA</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>NIM</th>
	                        <th>Nama</th>
	                        <th>Semester</th>
	                        <th>Alamat</th>
	                        <th>Jenis Kelamin</th>
	                        <th>Jurusan</th>
	                        <th>Tahun Mengajukan</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM mahasiswa")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['nim']?></td>
	                            <td><?=$row['nama_mhs']?></td>
	                            <td><?=$row['semester']?></td>
	                            <td><?=$row['alamat']?></td>
	                            <td><?=$row['jenis_kelamin']?></td>
	                            <td><?=$row['jurusan']?></td>
	                            <td><?=$row['tahun_mengajukan']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=mahasiswa&action=update&key=<?=$row['nim']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=mahasiswa&action=delete&key=<?=$row['nim']?>" class="btn btn-danger btn-xs">Hapus</a>
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
