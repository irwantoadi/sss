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
	        <div class="panel-heading"><img class="kiri" src ="LOGO.png"><h3 class="text-center"> LAPORAN DATA MAHASISWA</h3></div>
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
	                    <?php if ($query = $connection->query("SELECT * FROM mahasiswa WHERE nim IN(SELECT nim FROM nilai)")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?> 
	                        <tr>
	                            <td><?=$no++?></td>
								<td><?=$row["nim"]?></td>
	                            <td><?=$row["nama_mhs"]?></td>
	                            <td><?=$row["semester"]?></td>
	                            <td><?=$row['alamat']?></td>
	                            <td><?=$row['jenis_kelamin']?></td>
	                            <td><?=$row['jurusan']?></td>
	                            <td><?=$row['tahun_mengajukan']?></td>
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	          <button class="btn btn-primary" onclick="myFunction()">Cetak Halaman</button>
	        </div>
	    </div>
	</div>
</div>
