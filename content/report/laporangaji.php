	<?php
	$tanggal = date('Y-m-d');
	require_once ('../classes/mainClass.php');
    require_once ('../classes/fungsiClass.php');
	require_once ('../classes/laporanClass.php');
	require_once ('../classes/pengajarClass.php');
    $fungsi = new fungsi();
    $gaji = new laporangaji();
	$setting = new settingApps();
	$pengajar = new pengajar();
	$dataGaji = $gaji->getGaji($_POST['bln'], $_POST['idpengajar']);
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laporan Gaji <?php echo $fungsi->getMonthName($_POST['bln']);?></title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/custom-print.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
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
				<h4><strong>Laporan Gaji Pengajar</strong></h4>
				<p>&nbsp;&nbsp;Nama : <?php echo $pengajar->takeName($_POST['idpengajar'])?></p>
				<p>&nbsp;&nbsp;Bulan : <?php echo $fungsi->getMonthName($_POST['bln'])?></p>
                    <table class="table table-bordered">
                        <tbody>
							<tr><td colspan="3" class="text-left small">Bulan : <?php echo $fungsi->getMonthName($tanggal);?></td></tr>
                            <?php
                                $i=1;
								$jumlah = 0;
								echo "<tr><td colspan='3'>";
                                foreach ($dataGaji as $data) {
									echo "<div class='row'>"
										."<div class='col-xs-6'>"
										."<p> ".$i.". ".$data['nama_instrument']." <span class='small'>(".$data['hadir_pengajar']."x pertemuan)</span></p>"
										."</div>"
										."<div class='col-xs-5'>"
										."<p>: Rp. ".$fungsi->formatindo($data['jumlah_pengajar'])."</p>"
										."</div></div>";
									$jumlah = $jumlah + $data['jumlah_pengajar'];
                                    $i++;
                                }
								echo "<div class='row'><div class='col-xs-3 col-xs-offset-6'><hr></div></div>";
								echo "<div class='row'>"
									."<div class='col-xs-6'>Total :</div>"
									."<div class='col-xs-3'> &nbsp;&nbsp;Rp. ".$fungsi->formatindo($jumlah)."</div></div>";
								echo "</td></tr>";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-5 pull-right text-center">
				<?php 
					echo "<p>".$setting->loadSetting('kota').", ".$fungsi->tglindo($tanggal)."</p>"
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