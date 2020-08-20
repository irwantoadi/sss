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
	        <div class="panel-heading"><img class="kiri" src ="LOGO.png"><h3 class="text-center"> LAPORAN DATA PEMBAGIAN NILAI</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Kode Nilai</th>
							<th>Kode Beasiswa</th>
							<th>Kode Kriteria</th>
							<th>Bobot</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM pembagian_nilai WHERE kd_model IN(SELECT kd_model FROM nilai)")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?> 
	                        <tr>
	                            <td><?=$no++?></td>
								<td><?=$row["kd_model"]?></td>
	                            <td><?=$row["kd_beasiswa"]?></td>
	                            <td><?=$row["kd_kriteria"]?></td>
	                            <td><?=$row['bobot_model']?></td>
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
