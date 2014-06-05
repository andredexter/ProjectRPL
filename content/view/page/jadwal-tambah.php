<?php
if(!isset($_GET['id'])){
	echo "<script>document.location='?p=jadwal'</script>";
}

$tanggal = date('Y-m-d');

require_once ('content/classes/jadwalClass.php');
require_once ('content/classes/fungsiClass.php');

$jadwal= new jadwal();
$fungsi = new fungsi();

$dataSiswa= $jadwal->getSiswa();  
$dataPengajar= $jadwal->getPengajar();  
$dataShift= $jadwal->getShift($_GET['id']);  
?>

<div class="page-content">
	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Jadwal Pelajaran Baru [ Hari : <?php echo $fungsi->selectHari($_GET['id'])?> ]</h3>
		<div class="clearfix"></div>
	</div>
	
	<div class="page-grid">
		<div class="container">
			<div class="row">
				<?php
					if(isset($_SESSION['notif'])){
						if($_SESSION['notif'] == 'wrongJadwal') {
							echo "<div class='alert alert-danger alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Kesalahan!</strong> Jam Belajar telah ada disimpan sebelumnya.
								  </div>";
						}
						unset($_SESSION['notif']);
					 }
				?>
				<div class="col-md-12">
					<div class="page-form">
					<!-- Form Content -->
						<form class="form-horizontal" role="form" action="content/proses.php?act=saveJadwal" method="post">
							<div class="form-group">
								<label for="name" class="control-label col-lg-2">Nama Siswa</label>
								<div class="col-lg-5">
									<select id="siswa" name="siswa" class="form-control">
										<?php
											if($dataSiswa === null){
												echo"<option>- Tidak ada siswa yang belum punya jadwal -</option>";
											}
											else {
												echo"<option value='0'>- Pilih Siswa -</option>";
												$i=1;
												foreach ($dataSiswa as $data) {
													echo"<option value='".$data['id_siswa']."'>".$data['nama_siswa']."</option>";
													$i++;
												}
											}
										?>  
										</select>
								</div>
							</div>
							<div class="form-group">
								<label for="telp" class="control-label col-lg-2">Nama Pengajar</label>
								<div class="col-lg-5">
									<select id="pengajar" name="pengajar" class="form-control">
										<?php
											if($dataPengajar === null){
												echo"<option>- Pengajar -</option>";
											}
											else {
												echo"<option value='0'>- Pilih Pengajar -</option>";
												$i=1;
												foreach ($dataPengajar as $data) {
													echo"<option value='".$data['id_pengajar']."'>".$data['nama_pengajar']."</option>";
													$i++;
												}
											}
										?>  
										</select>
								</div>
							</div>
							<div class="form-group">
								<label for="telp" class="control-label col-lg-2">Jam</label>
								<div class="col-lg-2">
									<select id="shift" name="shift" class="form-control">
									<?php
										if($dataShift === null){
											echo"<option>- Jam tidak ada -</option>";
										}
										else {
											echo"<option value='0'>- Pilih jam belajar -</option>";
											$i=1;
											foreach ($dataShift as $data) {
												echo"<option value='".$data['id_shift']."'>".$fungsi->regenerateJam($data['jam_mulai'])." - ".$fungsi->regenerateJam($data['jam_akhir'])."</option>";
												
												$i++;
											}
										}
									?>  
									</select>
								</div>
							</div>											
							<div class="form-group">
								<div class="col-lg-offset-3 col-lg-9">
									<input type="submit" class="btn btn-primary submit" value="Simpan"></input>&nbsp;
									<a href="?p=jadwal"><button type="button" class="btn btn-default">Batal</button></a>
								</div>	
							</div>
						</form>
					</div>
				</div>
	
			</div>
		</div>
	</div>
</div> <!-- Page content end -->