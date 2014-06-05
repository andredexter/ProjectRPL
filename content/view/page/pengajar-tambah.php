<?php
$tanggal = date('Y-m-d');
?>

<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Tambah Data Pengajar</h3>
		<div class="clearfix"></div>
	</div>
	<?php
					if(isset($_SESSION['notif'])){
						if($_SESSION['notif'] == 'duplicate') {
							echo "<div class='alert alert-danger alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Kesalahan!</strong> Nama pengajar telah didaftarkan sebelumnya.
								  </div>";
						}
						else if($_SESSION['notif'] == 'success') {
							echo "<div class='alert alert-success alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Berhasil!</strong> Pengajar berhasil disimpan.
								  </div>";
						}
						else if($_SESSION['notif'] == 'fail') {
							echo "<div class='alert alert-danger alert-dismissable'>
								  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
								  <strong>Gagal!</strong> Pengajar gagal disimpan.
								  </div>";
						}
						unset($_SESSION['notif']);
						
					 }
				?>
	<!-- Form page -->
	<div class="page-form validate-form">
		<form class="form-horizontal" role="form" action="content/proses.php?act=savePengajar" method="post">
			<div class="form-group">
				<label for="name" class="control-label col-lg-3">Nama Pengajar</label>
				<div class="col-lg-9">
					<input id="name" name="name" class="form-control" type="text" value="<?php if(isset($_SESSION['nama'])){echo $_SESSION['nama'];}else { echo '';}unset($_SESSION['nama']);?>" required/>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="control-label col-lg-3">Tempat/Tanggal Lahir</label>
				<div class="col-lg-4">
					<input id="tempat" name="tempat" class="form-control" type="text" value="<?php if(isset($_SESSION['tempat'])){echo $_SESSION['tempat'];}else { echo '';}unset($_SESSION['tempat']);?>"/>
				</div>
				<div class="col-lg-5">
					<input type="date" id="tanggal" name="tanggal" class="form-control" type="text" value="<?php if(isset($_SESSION['tanggal'])){echo $_SESSION['tanggal'];}else { echo $tanggal;}unset($_SESSION['tanggal']);?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="telp" class="control-label col-lg-3">Pendidikan</label>
				<div class="col-lg-9">
					<input id="pendidikan" name="pendidikan" class="form-control" type="text" value="<?php if(isset($_SESSION['pendidikan'])){echo $_SESSION['pendidikan'];}else { echo '';}unset($_SESSION['pendidikan']);?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="telp" class="control-label col-lg-3">Nomor Telepon</label>
				<div class="col-lg-9">
					<input id="telp" name="telp" class="form-control" type="text" value="<?php if(isset($_SESSION['telp'])){echo $_SESSION['telp'];}else { echo '';}unset($_SESSION['telp']);?>" required/>
				</div>
			</div>
			<div class="form-group">
				<label for="alamat" class="control-label col-lg-3">Alamat</label>
				<div class="col-lg-9">
					<textarea id="alamat" name="alamat" class="form-control"><?php if(isset($_SESSION['alamat'])){echo $_SESSION['alamat'];}else { echo '';}unset($_SESSION['alamat']);?></textarea>
				</div>
			</div>
			                
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-9">
					<input type="submit" class="btn btn-primary submit" value="Simpan"></input>&nbsp;
					<a href="?p=pengajar&sub=lihat"><button type="button" class="btn btn-default">Kembali</button></a>
				</div>	
			</div>
		</form>
	</div> <!-- Form page end -->
	
</div> <!-- Page content end -->
</br>
</br>
<?php
 include('content/view/page/pengajar-lihat.php');
?>