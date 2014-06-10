<?php
$tanggal = date('Y-m-d');
require_once ('content/classes/absensiClass.php');
require_once ('content/fungsi.php');

$absensi= new absensi();
$dataSiswa= $absensi->getSiswa();  
$month = getMonth($tanggal);
?>

<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Absensi 
			<?php 
			if(isset($_POST['month'])&&isset($_POST['siswa'])){
				echo $absensi->getName($_POST['siswa'])." pada bulan ". getMonthName($_POST['month']);
			}?>
		</h3>
		<div class="clearfix"></div>
	</div>
	<?php
		if(isset($_SESSION['notif'])){
			if($_SESSION['notif'] == 'success') {
				echo "<div class='alert alert-success alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Berhasil!</strong> Absensi berhasil disimpan.
					  </div>";
			}
			else if($_SESSION['notif'] == 'editSukses') {
				echo "<div class='alert alert-success alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Berhasil!</strong> Absensi berhasil disimpan.
					  </div>";
			}
			else if($_SESSION['notif'] == 'editGagal') {
				echo "<div class='alert alert-danger alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Kesalahan!</strong> Absensi gagal disimpan.
					  </div>";
			}
			unset($_SESSION['notif']);
			
		 }
	?>
	<?php
	if(isset($_POST['month'])&&isset($_POST['siswa'])){
		$cekAbsensi = $absensi->cekAbsensi($_POST['month'], $_POST['siswa']);
		
		if($cekAbsensi === null){
				$cekJadwal = $absensi->cekJadwal($_POST['siswa']);
				if($cekJadwal == null){
					echo "ERROR";
				}
				else {
					$i=1;
					foreach ($cekJadwal as $data) {
						echo "<p>Jadwal : ".$data['nama_hari'].", ".regenerateJam($data['jam_mulai'])." - ".regenerateJam($data['jam_akhir'])."</p>";
						echo "<p>Nama Siswa : ".$data['nama_siswa']."</p>";
						echo "<p>Nama Pengajar : ".$data['nama_pengajar']."</p>";
						echo "<form class='form-horizontal' role='form' action='content/proses.php?act=saveAbsen' method='post'>"
							."<input type='hidden' id='bln' name='bln' class='form-control' type='text' value='".$_POST['month']."-01' required/>"
							."<input type='hidden' id='idsiswa' name='idsiswa' class='form-control' type='text' value='".$data['id_siswa']."' required/>"
							."<input type='hidden' id='idpengajar' name='idpengajar' class='form-control' type='text' value='".$data['id_pengajar']."' required/>"
							."<div class='form-group'>"
							."<label for='jumlah' class='control-label col-lg-2'>Jumlah Pertemuan</label>"
							."<div class='col-lg-2'>"
							."	<input type='number' id='jumlah' name='jumlah' class='form-control' type='text' required/>"
							."</div>"
							."</div>"
							."<div class='form-group'>"
							."<label for='name' class='control-label col-lg-2'>Hadir siswa</label>"
							."<div class='col-lg-2'>"
							
							."	<input id='siswa' name='siswa' class='form-control' type='number' required/>"
							."</div>"
							."</div>"
							."<div class='form-group'>"
							."<label for='name' class='control-label col-lg-2'>Hadir Pengajar</label>"
							."<div class='col-lg-2'>"
							."	<input id='pengajar' name='pengajar' class='form-control' type='number' required/>"
							."</div>"
							."</div>";
						echo "<div class='form-group'>"
							."<div class='col-lg-offset-3 col-lg-9'>"
							."<input type='submit' class='btn btn-primary submit' value='Simpan'></input>&nbsp;"
							."<a href='?p=absensi'><button type='button' class='btn btn-default'>Batal</button></a>"
							."</div>"
							."</div>"
							."</form>";
					}
				}
				
			}
		else {
			$i=1;
			foreach ($cekAbsensi as $data) {
				echo "<p>Jadwal : ".$data['nama_hari'].", ".regenerateJam($data['jam_mulai'])." - ".regenerateJam($data['jam_akhir'])."</p>";
				echo "<p>Nama Siswa : ".$data['nama_siswa']."</p>";
				echo "<p>Nama Pengajar : ".$data['nama_pengajar']."</p>";
				echo "<form class='form-horizontal' role='form' action='content/proses.php?act=editAbsen' method='post'>"
					."<input type='hidden' id='idabsen' name='idabsen' class='form-control' type='text' value='".md5($data['id_absen'])."' required/>"
					."<div class='form-group'>"
					."<label for='jumlah' class='control-label col-lg-2'>Jumlah Pertemuan</label>"
					."<div class='col-lg-2'>"
					."	<input type='number' id='jumlah' name='jumlah' class='form-control' type='text' value='".$data['jumlah']."' required/>"
					."</div>"
					."</div>"
					."<div class='form-group'>"
					."<label for='name' class='control-label col-lg-2'>Hadir siswa</label>"
					."<div class='col-lg-2'>"
					."	<input type='number' id='siswa' name='siswa' class='form-control' type='text' value='".$data['hadir_siswa']."' required/>"
					."</div>"
					."</div>"
					."<div class='form-group'>"
					."<label for='name' class='control-label col-lg-2'>Hadir Pengajar</label>"
					."<div class='col-lg-2'>"
					."	<input type='number' id='pengajar' name='pengajar' class='form-control' type='text' value='".$data['hadir_pengajar']."' required/>"
					."</div>"
					."</div>";
				echo "<div class='form-group'>"
					."<div class='col-lg-offset-3 col-lg-9'>"
					."<input type='submit' class='btn btn-primary submit' value='Simpan'></input>&nbsp;"
					."<a href='?p=absensi'><button type='button' class='btn btn-default'>Kembali</button></a>"
					."</div>"
					."</div>"
					."</form>";
				
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
										echo"<option>- Tidak ada siswa dengan jadwal pada bulan ini-</option>";
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