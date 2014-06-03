<?php
$tanggal = date('Y-m-d');
require_once ('content/classes/pembayaranClass.php');
require_once ('content/classes/fungsiClass.php');

$pembayaran= new pembayaran();
$fungsi= new fungsi();
$dataSiswa= $pembayaran->getSiswa();  
$month = $fungsi->getMonth($tanggal);
?>

<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Pembayaran Uang Bulanan 
			<?php if(isset($_POST['month'])&&isset($_POST['siswa'])){
				echo $pembayaran->getName($_POST['siswa'])." pada bulan ". $pembayaran->getMonthName($_POST['month']);
			}?>
		</h3>
		<div class="clearfix"></div>
	</div>
	<?php
		if(isset($_SESSION['notif'])){
			if($_SESSION['notif'] == 'success') {
				echo "<div class='alert alert-success alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Berhasil!</strong> Pembayaran berhasil disimpan.
					  </div>";
			}
			else if($_SESSION['notif'] == 'editSukses') {
				echo "<div class='alert alert-success alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Berhasil!</strong> Pembayaran berhasil disimpan.
					  </div>";
			}
			else if($_SESSION['notif'] == 'editGagal') {
				echo "<div class='alert alert-danger alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Kesalahan!</strong> Pembayaran gagal disimpan.
					  </div>";
			}
			unset($_SESSION['notif']);
			
		 }
	?>
	<?php
	if(isset($_POST['month'])&&isset($_POST['siswa'])){
		$cekPembayaran = $pembayaran->cekPembayaran($_POST['month'], $_POST['siswa']);
		
		if($cekPembayaran === null){
				$dataSiswa = $pembayaran->getPembayaran($_POST['siswa']);
				if($dataSiswa == null){
					echo "ERROR";
				}
				else {
					$i=1;
					foreach ($dataSiswa as $data) {
						echo "<p>Nama Siswa: ".$data['nama_siswa']."</p>";
						echo "<p>Jenis Instrument : ".$data['nama_instrument']."</p>";
						echo "<p>Uang Bulanan: Rp. ".$fungsi->formatindo($data['biaya_instrument']).",-</p>";
						echo "<form class='form-horizontal' role='form' action='content/proses.php?act=savePembayaran' method='post'>"
							."<input type='hidden' id='bln' name='bln' class='form-control' type='text' value='".$_POST['month']."-01' required/>"
							."<input type='hidden' id='idsiswa' name='idsiswa' class='form-control' type='text' value='".$data['id_siswa']."' required/>"
							."<div class='form-group'>"
							."<label for='jumlah' class='control-label col-lg-2'>Jumlah dibayar (Rp.)</label>"
							."<div class='col-lg-2'>"
							."	<input id='jumlah' name='jumlah'  onkeyup='this.value = addCommas(coma(this.value))' class='form-control' type='text' required/>"
							."</div>"
							."</div>";
						echo "<div class='form-group'>"
							."<div class='col-lg-offset-3 col-lg-9'>"
							."<input type='submit' class='btn btn-primary submit' value='Simpan'></input>&nbsp;"
							."<a href='?p=pembayaran'><button type='button' class='btn btn-default'>Kembali</button></a>"
							."</div>"
							."</div>"
							."</form>";
					}
				}
				
			}
		else {
			$i=1;
			foreach ($cekPembayaran as $data) {
				echo "<p>Nama Siswa: ".$data['nama_siswa']."</p>";
				echo "<p>Jenis Instrument : ".$data['nama_instrument']."</p>";
				echo "<p>Uang Bulanan: Rp. ".$fungsi->formatindo($data['biaya_instrument']).",- ";
				if($data['biaya_instrument'] == $data['jumlah']){
					echo "<span class='label label-success'>Telah lunas membayar</span>";
					echo "</p><br>"
						."<div class='col-lg-offset-2 col-lg-9'>"
						."<a href='?p=pembayaran'><button type='button' class='btn btn-default'>Kembali</button></a>"
						."</div>"
						."<br>"
						."<br>"
						."</div>";
				}
				else {
				echo "<form class='form-horizontal' role='form' action='content/proses.php?act=editPembayaran' method='post'>"
					."<input type='hidden' id='idbayar' name='idbayar' class='form-control' type='text' value='".md5($data['id_pembayaran'])."' required/>"
					."<div class='form-group'>"
					."<label for='jumlah' class='control-label col-lg-2'>Jumlah dibayar (Rp.)</label>"
					."<div class='col-lg-2'>"
					."	<input id='jumlah' name='jumlah' class='form-control' type='text' onkeyup='this.value = addCommas(coma(this.value))' value='".$fungsi->formatindo($data['jumlah'])."' required/>"
					."</div>"
					."</div>";
				echo "<div class='form-group'>"
					."<div class='col-lg-offset-3 col-lg-9'>"
					."<input type='submit' class='btn btn-primary submit' value='Simpan'></input>&nbsp;"
					."<a href='?p=pembayaran'><button type='button' class='btn btn-default'>Kembali</button></a>"
					."</div>"
					."</div>"
					."</form>";
				}
			$i++;
							
			}
		}
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
						<label for="name" class="control-label col-lg-2">Nama Siswa</label>
						<div class="col-lg-5">
							<select id="siswa" name="siswa" class="form-control">
								<?php
									if($dataSiswa === null){
										echo"<option>- Tidak ada siswa yang memiliki jadwal pada bulan ini -</option>";
									}
									else {
										echo"<option value='0'>- Pilih Siswa -</option>";
										$i=1;
										foreach ($dataSiswa as $data) {
											echo"<option value='".$data['id_siswa']."'>".$data['nama_siswa']." (".$data['nama_instrument'].")</option>";
											
											$i++;
										}
									}
								?>  
								</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-3 col-lg-9">
							<input type="submit" class="btn btn-primary submit" value="Proses"></input>&nbsp;
							<a href="./"><button type="button" class="btn btn-default">Kembali</button></a>
						</div>	
					</div>
				</form>
			</div> <!-- Form page end -->
		
		<?php
	} 
	
	?>
</div> <!-- Page content end -->