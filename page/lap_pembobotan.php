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
	        <div class="panel-heading"><img class="kiri" src ="LOGO.png"><h3 class="text-center"> LAPORAN DATA PEMBOBOTAN</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Kode Pembobotan</th>
							<th>Kode Beasiswa</th>
							<th>Kode Kriteria</th>
							<th>Keterangan</th>
							<th>Bobot</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<?php $no = 1; ?>
	                	<?php if ($query = $connection->query("SELECT * FROM PEMBOBOTAN WHERE kd_pembobotan IN(SELECT kd_pembobotan FROM nilai)")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?> 
	                        <tr>
	                            <td><?=$no++?></td>
								<td><?=$row["kd_pembobotan"]?></td>
	                            <td><?=$row["kd_beasiswa"]?></td>
	                            <td><?=$row["kd_kriteria"]?></td>
	                            <td><?=$row["keterangan"]?></td>
	                            <td><?=$row["bobot_nilai"]?></td>
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