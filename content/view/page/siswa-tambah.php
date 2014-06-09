<?php
$tanggal = date('Y-m-d');
require_once ('content/classes/instrumentClass.php');
$instrument= new instrument();
$dataInstrument = $instrument->getInstrument('*');  
?>

<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Tambah Siswa Baru</h3>
		<div class="clearfix"></div>
	</div>
	<?php
	
	if(isset($_SESSION['notif'])){
		if($_SESSION['notif'] == 'duplicateSiswa') {
			echo "<div class='alert alert-danger alert-dismissable'>
				  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
				  <strong>Kesalahan!</strong> Nama siswa telah didaftarkan sebelumnya.
				  </div>";
		}
		else if($_SESSION['notif'] == 'success') {
			echo "<div class='alert alert-success alert-dismissable'>
				  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
				  <strong>Berhasil!</strong> Siswa berhasil disimpan.
				  </div>";
		}
		unset($_SESSION['notif']);
		
	 }
	?>
	<!-- Form page -->
	<div class="page-form">
		<form class="form-horizontal" role="form" action="content/proses.php?act=saveSiswa" method="post">
			<div class="row">
				<div class="form-group">
					<label class="col-lg-2 control-label">Tanggal Mendaftar</label>
					<div class="col-lg-2"	>
						<input type="date" id="tanggaldaftar" name="tanggaldaftar" class="form-control" value="<?php echo $tanggal;?>">
					</div>
				</div>
				<hr>
				<div class="form-group">
						<label class="col-lg-2 control-label">Nama Siswa</label>
						<div class="col-lg-3"	>
							<input type="text" id="nama" name="nama" class="form-control" placeholder="Nama lengkap" required>
						</div>	
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Tempat/ Tanggal Lahir</label>
						<div class="col-lg-2"	>
							<input type="text" id="tempatlahir" name="tempatlahir" class="form-control" placeholder="Tempat Lahir" required>
						</div>
						<div class="col-lg-2"	>
							<input type="date" id="tanggallahir" name="tanggallahir" class="form-control" value="<?php echo $tanggal;?>">
						</div>
					</div>					
					<div class="form-group">
						<label class="col-lg-2 control-label">Alamat Siswa</label>
						<div class="col-lg-4"	>
							<textarea id="alamat" name="alamat" class="form-control" placeholder="Alamat lengkap" required></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Telepon Siswa</label>
						<div class="col-lg-3"	>
							<input type="text" id="telepon" name="telepon" class="form-control" placeholder="Nomor yang bisa dihubungi" required>
						</div>
					</div>
				
				<hr>
				<div class="form-group">
					<label class="col-lg-2 control-label">Jenis Instrument</label>
					<div class="col-lg-2"	>
						<select id="instrument" name="instrument" class="form-control">
						<?php
							if($dataInstrument === null){
								echo"<option>- Instrument tidak ada -</option>";
							}
							else {
								echo"<option value='0'>- Pilih Instrument -</option>";
								$i=1;
								foreach ($dataInstrument as $data) {
									echo"<option value='".$data['id']."'>".$data['nama']."</option>";
									
									$i++;
								}
							}
						?>  
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Biaya Pendaftaran</label>
					<div class="col-lg-3"	>
						<input type="text" id="biaya" name="biaya" onkeyup="this.value = addCommas(coma(this.value))" class="form-control" required>
					</div>
					
					<div class="col-lg-3"	>
							<div class="input-group">
								<span class="input-group-addon">Diskon&nbsp;</span>
								<input type="text" name="discount" id="discount" class="form-control">
								<span class="input-group-addon">%</span>
							</div>
						</div>
					
				</div>
				<input type="hidden" id="pendaftaran" name="pendaftaran" class="form-control" readonly>
				
				<div class="form-group">
					<label class="col-lg-2 control-label">Biaya Instrument</label>
					<div class="col-lg-3"	>
						<input type="text" id="biayainstrument" name="biayainstrument" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Total Biaya Pendaftaran</label>
					<div class="col-lg-3"	>
						<input type="text" id="total" name="total" class="form-control">
					</div>
				</div>
				
			</div>
			<hr>
			<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<input type="submit" class="btn btn-primary submit" value="Simpan"></input>&nbsp;
						<a href="?p=siswa&sub=lihat"><button type="button" class="btn btn-default">Kembali</button></a>
					</div>	
				</div>
		</form>
	</div> <!-- Form page end -->
	
</div> <!-- Page content end -->