<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-home lblue"></i> Tambah Jenis Instrument</h3>
		<div class="clearfix"></div>
	</div>
	<?php
		if(isset($_SESSION['notif'])){
			if($_SESSION['notif'] == 'duplicate') {
				echo "<div class='alert alert-danger alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Kesalahan!</strong> Jenis instrument telah didaftarkan sebelumnya.
					  </div>";
			}
			else if($_SESSION['notif'] == 'successSave') {
				echo "<div class='alert alert-success alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Berhasil!</strong> Jenis Instrument baru berhasil disimpan.
					  </div>";
			}
			else if($_SESSION['notif'] == 'failSave') {
				echo "<div class='alert alert-danger alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Berhasil!</strong> Jenis Instrument gagal disimpan.
					  </div>";
			}
			unset($_SESSION['notif']);
			
		 }
	?>
	<!-- Form page -->
	<div class="page-form validate-form">
		<form id="informasi" class="form-horizontal" role="form" method="post" action="content/proses.php?act=saveInstrument">
			<div class="form-group">
				<label for="jenis" class="control-label col-lg-3">Jenis Instrument</label>
				<div class="col-lg-9">
					<input id="jenis" name="jenis" class="form-control" type="text" required />
					<em>Contoh: Gitar</em>
				</div>
			</div>
			<div class="form-group">
				<label for="biaya" class="control-label col-lg-3">Biaya (Rp.)</label>
				<div class="col-lg-9">
					<input id="biaya" name="biaya" class="form-control" type="text" required/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-6">
					<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;
					<a href="?p=instrument"><button type="button" class="btn btn-default">Kembali </button></a>
				</div>
			</div>
		</form>
	</div> <!-- Form page end -->
	
</div> <!-- Page content end -->
</br>
</br>
<?php
 include('content/view/page/instrument.php');
?>