<?php
$setting = new settingApps();
?>

<div class="page-content">
	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-home lblue"></i> Informasi Sekolah</h3>
		<div class="clearfix"></div>
	</div>
	<?php
					if(isset($_SESSION['notif'])){
						if($_SESSION['notif'] == 'suksesUpdate') {
							echo "<div class='alert alert-success alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Data!</strong> Berhasil di perbaharui.
								  </div>";
						}
						else if($_SESSION['notif'] == 'gagalUpdate') {
							echo "<div class='alert alert-warning alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Data!</strong> gagal di perbaharui.
								  </div>";
						}
						unset($_SESSION['notif']);
						
					 }
				?>
	<!-- Form page -->
	<div class="page-form validate-form">
		<form id="informasi" class="form-horizontal" role="form" method="post" action="content/proses.php?act=saveInfo">
			<div class="form-group">
				<label for="judulweb" class="control-label col-lg-3">Judul Web</label>
				<div class="col-lg-9">
					<input id="judulweb" name="judulweb" class="form-control" type="text" value="<?php echo $setting->loadSetting('judul')?>"/>
					<em>Contoh: Penggajian Guru</em>
				</div>
			</div>
			<div class="form-group">
				<label for="namasekolah" class="control-label col-lg-3">Nama Sekolah</label>
				<div class="col-lg-9">
					<input id="namasekolah" name="namasekolah" class="form-control" type="text"  value="<?php echo $setting->loadSetting('nama')?>"/>
					<em>Contoh: Sekolah Harapan Maju</em>
				</div>
			</div>
			<div class="form-group">
				<label for="notelp" class="control-label col-lg-3">Nomor Telepon</label>
				<div class="col-lg-9">
					<input id="notelp" name="notelp" class="form-control" type="text"  value="<?php echo $setting->loadSetting('telepon')?>"/>
					<em>Contoh: (0752)00000</em>
				</div>
			</div>
			<div class="form-group">
				<label for="alamat" class="control-label col-lg-3">Alamat</label>
				<div class="col-lg-9">
					<textarea id="alamat" name="alamat" class="form-control"><?php echo $setting->loadSetting('alamat')?></textarea>
					<em>Contoh: Jl.Sudirman</em>
				</div>
			</div>
			<div class="form-group">
				<label for="notelp" class="control-label col-lg-3">Kota</label>
				<div class="col-lg-9">
					<input id="kota" name="kota" class="form-control" type="text"  value="<?php echo $setting->loadSetting('kota')?>"/>
					<em>Contoh: Padang</em>
				</div>
			</div>
			<div class="form-group">
				<label for="alamat" class="control-label col-lg-3">Nama Pemilik</label>
				<div class="col-lg-9">
					<input id="pemilik" name="pemilik" class="form-control" type="text"  value="<?php echo $setting->loadSetting('pemilik')?>"/>
					<em>Contoh: Bapak Soekarno</em>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-6">
					<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;
					<a href="./"><button type="button" class="btn btn-default">Batal</button></a>
				</div>
			</div>
		</form>
	</div> <!-- Form page end -->
	
</div> <!-- Page content end -->