<?php
$setting = new settingApps();
$user= new userController();
?>

<div class="page-content">
	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-user blue"></i> Informasi User</h3>
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
			else if($_SESSION['notif'] == 'notValid') {
				echo "<div class='alert alert-warning alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Password</strong> tidak sesuai.
					  </div>";
			}
			else if($_SESSION['notif'] == 'wrongPass') {
				echo "<div class='alert alert-danger alert-dismissable'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					  <strong>Password</strong> lama anda tidak sesuai.
					  </div>";
			}
			unset($_SESSION['notif']);
			
		 }
	?>
	<!-- Form page -->
	<div class="page-form validate-form">
	<div class="row">
		<div class="col-lg-3">
		<img src="img/user.jpg" alt="" class="img-thumbnail">
		</div>
		<div class="col-lg-9">
			<?php
			if(isset($_GET['edit'])){
			?>
			<form id="informasi" class="form-horizontal" role="form" method="post" action="content/proses.php?act=saveUser">
				<div class='alert alert-warning'>
					<strong>Informasi yang ada dibawah ini digunakan untuk proses login untuk menggunakan aplikasi ini!</strong>
				</div>
				<input type="hidden" id="prive" name="prive" value="<?php echo $_SESSION['prive']?>">
				<div class="form-group">
					<label for="username" class="control-label col-lg-3">Username</label>
					<div class="col-lg-9">
						<input id="username" name="username" class="form-control" type="text" required/>
					</div>
				</div>
				<div class="form-group">
					<label for="namasekolah" class="control-label col-lg-3">Password yang lama</label>
					<div class="col-lg-9">
						<input id="passwordold" name="passwordold" class="form-control" type="password"  required/>
					</div>
				</div>
				<div class="form-group">
					<label for="notelp" class="control-label col-lg-3">Password baru</label>
					<div class="col-lg-9">
						<input id="passwordnew" name="passwordnew" class="form-control" type="password"  required/>
					</div>
				</div>
				<div class="form-group">
					<label for="notelp" class="control-label col-lg-3">Konfirmasi password baru</label>
					<div class="col-lg-9">
						<input id="validasi" name="validasi" class="form-control" type="password"  required/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-6">
						<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;
						<a href="?p=informasi&sub=user"><button type="button" class="btn btn-default">Batal</button></a>
					</div>
				</div>
			</form>
			
			
			<?php
			}
			else{
			?>
			<form id="informasi" class="form-horizontal">
				<div class="form-group">
					<label for="username" class="control-label col-lg-3">Username</label>
					<div class="col-lg-9">
						<input id="username" name="username" class="form-control" type="text" readonly value="<?php echo $user->pickUser($_SESSION['prive'])?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="namasekolah" class="control-label col-lg-3">Password</label>
					<div class="col-lg-9">
						<input id="password" name="password" class="form-control" type="password"  readonly value="Password"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-6">
						<a href="?p=informasi&sub=user&edit=1"><button type="button" class="btn btn-default">Ubah Detail</button></a>&nbsp;&nbsp;
						<a href="./"><button type="button" class="btn btn-default">Kembali</button></a>
					</div>
				</div>
			</form>
			<?php
			}
			?>
		</div>
	</div>
	</div> <!-- Form page end -->
	
</div> <!-- Page content end -->