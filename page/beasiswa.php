<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM beasiswa WHERE kd_beasiswa='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE beasiswa SET nama_bsw='$_POST[nama]', kuota='$_POST[kuota]' WHERE kd_beasiswa='$_GET[key]'";
	} else {
		$sql = "INSERT INTO beasiswa VALUES (NULL, '$_POST[nama]', '$_POST[kuota]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT kd_beasiswa FROM beasiswa WHERE nama_bsw LIKE '%$_POST[nama]%'");
		if ($q->num_rows) {
			echo alert("Beasiswa sudah ada!", "?page=beasiswa");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
    echo alert("Berhasil!", "?page=beasiswa");
  } else {
		echo alert("Gagal!", "?page=beasiswa");
  }
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM beasiswa WHERE kd_beasiswa='$_GET[key]'");
	echo alert("Berhasil!", "?page=beasiswa");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
	                <div class="form-group">
	                    <label for="nama">Nama Beasiswa</label>
	                    <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="'.$row["nama_bsw"].'"' ?>>
	                    <label for="kuota">Kuota</label>
	                    <input type="number" name="kuota" class="form-control" <?= (!$update) ?: 'value="'.$row["kuota"].'"' ?>>
	                </div>
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=beasiswa" class="btn btn-info btn-block">Batal</a>
									<?php endif; ?>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR BEASISWA</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Nama Beasiswa</th>
	                        <th>Kuota</th>
	                        <th>Aksi</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM beasiswa")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['nama_bsw']?></td>
	                            <td><?=$row['kuota']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=beasiswa&action=update&key=<?=$row['kd_beasiswa']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=beasiswa&action=delete&key=<?=$row['kd_beasiswa']?>" class="btn btn-danger btn-xs">Hapus</a>
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
