<?php
$tanggal = date('Y-m-d');
require_once ('content/classes/laporanClass.php');
require_once ('content/classes/fungsiClass.php');

$neraca= new neraca();
$fungsi= new fungsi();
$month = $fungsi->getMonth($tanggal);
?>

<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Laporan Keuangan
			<?php if(isset($_POST['month'])){
				echo "pada bulan ". $fungsi->getMonthName($_POST['month']);
				?>
				<br>
				<br>
				<form class="form-horizontal" role="form" action="" method="post">
					<div class="input-group input-group-sm">
						<input type="month" id="month" name="month" class="form-control" type="text" value="<?php echo $_POST['month']?>"/>
						<span class="input-group-btn"><input type="submit" class="btn btn-primary submit" value="Lihat"></input></span>
					</div>
				</form>
				<?php
			}?>
		</h3>
		<div class="clearfix"></div>
	</div>
	<?php
	if(isset($_POST['month'])){
		// $getPenggajian = $neraca->getPenggajian($_POST['month']);
		?>
		<?php echo "<form method='post' action='content/report/neraca.php'>"
									."<input type='hidden' id='bln' name='bln' value='".$_POST['month']."' required>"
									."<button type='submit' class='btn pull-right btn-success' formtarget='_blank'>Print Laporan</button></td>"
									."</form>";?>
		<h3>Laporan Keuangan</h3>
		
		<p>Bulan : <?php echo $fungsi->getMonthName($_POST['month'])?> </p>
		<table class="table table-hover table-bordered ">
				<thead>
					<tr>
						<th>#</th>
						<th></th>
                        <th>Jumlah</th>
                        <th>Total</th>                        
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h4><strong>1</strong></h4></td>
						<td><h4><strong>Saldo Sebelumnya</strong></h4></td>
						<td></td>
						<?php
						$saldo = $neraca->getSaldoBefore($fungsi->casttanggal($_POST['month']));
						
						?>
						<td><?php echo "Rp. ".$fungsi->formatindo($saldo)?></td>
					</tr>
					<tr>
						<td><h4><strong>2</strong></h4></td>
						<td><h4><strong>Uang Masuk</strong></h4></td>
						<td></td>
						<td></td>
					</tr>
					<?php
						$dataMasuk = $neraca->getDaftar($_POST['month']);
						$dataBayar = $neraca->getBayar($_POST['month']);
						$totalMasuk = 0;
						$j=1;
						foreach ($dataMasuk as $data) {
							 echo "<tr>"
								. "<td></td>"
								. "<td>".$j.". Pendaftaran siswa baru (".$data['banyak_masuk']." orang)</td>";
								if($data['jumlah_masuk'] == 0){
									echo "<td>-</td>";
									echo "<td></td>";
								}
								else {
									echo "<td>Rp. ".$fungsi->formatindo($data['jumlah_masuk'])."</td>";
									echo "<td></td>";
								}
							 echo "</tr>";
							$totalMasuk = $totalMasuk + $data['jumlah_masuk'];
							$j++;
						}
						foreach ($dataBayar as $data) {
							 echo "<tr>"
								. "<td></td>"
								. "<td>".$j.". Uang Bulanan Siswa (".$data['banyak_bayar']." orang)</td>";
								if($data['jumlah_bayar'] == 0){
									echo "<td>-</td>";
									echo "<td></td>";
								}
								else {
									echo "<td>Rp. ".$fungsi->formatindo($data['jumlah_bayar'])."</td>";
									echo "<td></td>";
								}
							 echo "</tr>";
							 $totalMasuk = $totalMasuk + $data['jumlah_bayar'];
							$j++;
						}
						echo "<tr>"
							."<td colspan='2' class='text-right'>Jumlah</td>"
							."<td></td>"
							."<td>Rp. ".$fungsi->formatindo($totalMasuk)."</td>"
							."</tr>";
					?>
					<tr>
						<td><h4><strong>3</strong></h4></td>
						<td><h4><strong>Uang Keluar</strong></h4></td>
						<td></td>
						<td></td>
					</tr>
					<?php
						$dataGaji = $neraca->getGaji($_POST['month']);
						$j=1;
						$totalKeluar = 0;
						foreach ($dataGaji as $data) {
							 echo "<tr>"
								. "<td></td>"
								. "<td>".$j.". Pembayaran Gaji Pengajar (".$data['banyak_gaji']." pertemuan)</td>";
								if($data['jumlah_gaji'] == 0){
									echo "<td>-</td>";
									echo "<td></td>";
								}
								else {
									echo "<td>Rp. ".$fungsi->formatindo($data['jumlah_gaji'])."</td>";
									echo "<td></td>";
								}
							 echo "</tr>";
							$totalKeluar = $totalKeluar + $data['jumlah_gaji'];
							$j++;
						}
						echo "<tr>"							
							."<td colspan='2' class='text-right'>Jumlah</td>"
							."<td></td>"
							."<td>Rp. ".$fungsi->formatindo($totalKeluar	)."</td>"
							."</tr>";
					
					$sisa_akhir = $saldo + $totalMasuk - $totalKeluar;
					echo "<tr><td colspan='3' class='text-right'><h4><strong>Sisa </strong></h4></td>"
						."<td>Rp. ".$fungsi->formatindo($sisa_akhir)."</td></tr>";
					echo "</tbody></table>";
	}
	
	else if(!isset($_GET['siswa']) || !isset($_GET['bln'])){
		?>
		<!-- Form page -->
			<div class="page-form">
				<form class="form-horizontal" role="form" action="" method="post">
					<div class="form-group">
						<label for="telp" class="control-label col-lg-2">Bulan </label>
						<div class="col-lg-5">
							<input type="month" id="month" name="month" class="form-control" type="text" value="<?php echo $month?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-9">
							<input type="submit" class="btn btn-primary submit" value="Lihat"></input>&nbsp;
							<a href="./"><button type="button" class="btn btn-default">Kembali</button></a>
						</div>	
					</div>
				</form>
			</div> <!-- Form page end -->
		
		<?php
	} 
	
	?>
</div> <!-- Page content end -->