<?php
	$tanggal = date('Y-m-d');
	require_once ('../classes/mainClass.php');
	require_once ('../classes/laporanClass.php');
	require_once ('../fungsi.php');

	$neraca= new neraca();
	$setting = new settingApps();
	$month = getMonth($tanggal);
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Keuangan <?php echo getMonthName($_POST['bln']);?></title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
  </head>
  <body>
    <div id="wrapper">
        <div id="page-wrapper" style="padding: 5px;">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3><?php echo strtoupper($setting->loadSetting('nama'));?></h3>
                    <h5>Alamat : <?php echo $setting->loadSetting('alamat');?>, Telepon : <?php echo strtoupper($setting->loadSetting('telepon'));?></h5>
                </div>
            </div>
            <hr>
			
			<div class="row">
                <div class="col-xs-12">
				<h4><strong>Laporan Keuangan Bulanan</strong></h4>
				<div class="clearfix"></div>
				<p>&nbsp;&nbsp;Bulan : <?php echo getMonthName($_POST['bln'])?></p>				
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
						$saldo = $neraca->getSaldoBefore(casttanggal($_POST['bln']));
						
						?>
						<td><?php echo "Rp. ".formatindo($saldo)?></td>
					</tr>
					<tr>
						<td><h4><strong>2</strong></h4></td>
						<td><h4><strong>Uang Masuk</strong></h4></td>
						<td></td>
						<td></td>
					</tr>
					<?php
						$dataMasuk = $neraca->getDaftar($_POST['bln']);
						$dataBayar = $neraca->getBayar($_POST['bln']);
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
									echo "<td>Rp. ".formatindo($data['jumlah_masuk'])."</td>";
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
									echo "<td>Rp. ".formatindo($data['jumlah_bayar'])."</td>";
									echo "<td></td>";
								}
							 echo "</tr>";
							 $totalMasuk = $totalMasuk + $data['jumlah_bayar'];
							$j++;
						}
						echo "<tr>"
							."<td colspan='2' class='text-right'>Jumlah</td>"
							."<td></td>"
							."<td>Rp. ".formatindo($totalMasuk)."</td>"
							."</tr>";
					?>
					<tr>
						<td><h4><strong>3</strong></h4></td>
						<td><h4><strong>Uang Keluar</strong></h4></td>
						<td></td>
						<td></td>
					</tr>
					<?php
						$dataGaji = $neraca->getGaji($_POST['bln']);
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
									echo "<td>Rp. ".formatindo($data['jumlah_gaji'])."</td>";
									echo "<td></td>";
								}
							 echo "</tr>";
							$totalKeluar = $totalKeluar + $data['jumlah_gaji'];
							$j++;
						}
						echo "<tr>"							
							."<td colspan='2' class='text-right'>Jumlah</td>"
							."<td></td>"
							."<td>Rp. ".formatindo($totalKeluar	)."</td>"
							."</tr>";
					
					$sisa_akhir = $saldo + $totalMasuk - $totalKeluar;
					echo "<tr><td colspan='3' class='text-right'><h4><strong>Sisa </strong></h4></td>"
						."<td>Rp. ".formatindo($sisa_akhir)."</td></tr>";
				echo "</tbody></table>";
				?>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-5 pull-right text-center">
				<?php 
					echo "<p>".$setting->loadSetting('kota').", ".tglindo($tanggal)."</p>"
						."</br></br>ttd</br></br></br>"
						."<p>".$setting->loadSetting('pemilik')."</p>"
						."<p>Pemilik</p>";
				?>
				</div>
			</div>
        </div>
    </div>
  </body>
   <script>
	window.load = print_d();
	function print_d(){
	window.print();
	}
 </script>
</html>