<?php
	$tanggal = date('Y-m-d');
    require_once ('../classes/mainClass.php');
    require_once ('../classes/fungsiClass.php');
	require_once ('../classes/siswaClass.php');
    $fungsi = new fungsi();
    $siswa = new siswa();
	$setting = new settingApps();
	
	$siswabaru = $siswa->pickSiswa($_POST['idsiswa']);
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Absensi LSI - Dashboard</title>

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
                    <h3><?php echo strtoupper($setting->loadSetting('nama'))?></h3>
                    <h5>Alamat : <?php echo $setting->loadSetting('alamat')?>, Telepon : <?php echo strtoupper($setting->loadSetting('telepon'))?></h5>
                </div>
            </div>
            <hr>
			
            <div class="row">
                <div class="col-xs-12">
				<h4><strong>Pendaftaran Siswa Baru</strong></h4>
                    <table class="table table-bordered">
                        <tbody>
							<tr><td colspan="3" class="text-right small">Tanggal : <?php echo $fungsi->tglindo($tanggal) ?></td></tr>
                            <?php
                                $i=1;
                                foreach ($siswabaru as $data) {
                                    echo "<tr><td colspan='3'><strong>Data Umum</strong></td></tr>";
									echo "<tr><td colspan='3'>"
										."<div class='col-xs-3 col-xs-offset-1'>"
										."<p>1. Nama</p>"
										."<p>2. Tempat / Tanggal Lahir</p>"
										."<p>3. Alamat</p>"
										."<p>4. Nomor Telepon</p>"
										."</div>"
										."<div class='col-xs-5'>"
										."<p>: ".$data['nama_siswa']."</p>"
										."<p>: ".$data['tempat_lahir']."/ ".$fungsi->tglindo($data['tanggal_lahir'])."</p>"
										."<p>: ".$data['alamat']."</p>"
										."<p>: ".$data['telepon']."</p>"
										."</div>"
										."</td></tr>";
									
									echo "<tr><td colspan='3'><strong>Data Pelajaran</strong></td></tr>";
									echo "<tr><td colspan='3'>"
										."<div class='col-xs-3 col-xs-offset-1'>"
										."<p> Tanggal Mendaftar</p>"
										."<p> Instrument yang dipilih</p>"
										."</div>"
										."<div class='col-xs-5'>"
										."<p>: ".$fungsi->tglindo($data['tanggal_masuk'])."</p>"
										."<p>: ".$data['nama_instrument']."</p>"
										."</div>"
										."</td></tr>";
									
									echo "<tr><td colspan='3'><strong>Biaya</strong></td></tr>";
									echo "<tr><td colspan='3'>"
										."<div class='col-xs-3 col-xs-offset-1'>"
										."<p> Biaya Pendaftaran</p>"
										."<p> Uang Bulanan</p>"
										."<p> &nbsp;</p>"
										."<p> Total</p>"
										."</div>"
										."<div class='col-xs-5'>"
										."<p>: Rp. ".$fungsi->formatindo($data['uang_masuk'])."</p>"
										."<p>: Rp. ".$fungsi->formatindo($data['biaya_instrument'])."</p>"
										."<hr>"
										."<p>: Rp. ".$fungsi->formatindo($data['uang_masuk']+$data['biaya_instrument'])."</p>"
										."</div>"
										."</td></tr>";
                                    $i++;
                                }
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