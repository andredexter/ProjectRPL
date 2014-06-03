<div class="page-content">
	<!-- Heading -->
	<div class="single-head">
		<?php
		 require_once ('content/classes/fungsiClass.php');
		if(!isset($_GET['id']))
		{
			echo "<script>document.location='?p=shift'</script>";
		}

		$datetime = new fungsi();
		?>
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Tambah Jam Pelajaran Baru [ Hari : <?php echo $datetime->selectHari($_GET['id'])?> ]</h3>
		<div class="clearfix"></div>
	</div>
	
	<div class="page-grid">
		<div class="container">
			<div class="row">
				<?php
					if(isset($_SESSION['notif'])){
						if($_SESSION['notif'] == 'wrongShift') {
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
						<form role="form" action="content/proses.php?act=saveShift" method="post">
							<input type="hidden" name="idhari" class="form-control" value="<?php echo $_GET['id']?>">
							<div class="form-group">
									<label class="col-lg-1 control-label">Jam Mulai</label>
									<div class="col-lg-3">
										<div class="input-group bootstrap-timepicker">
											<input type="text" id="jam_awal" name="jam_awal" class="form-control timepicker" value="<?php if(isset($_SESSION['jam_awal'])){echo $_SESSION['jam_awal'];}else { echo '07:00';}unset($_SESSION['jam_awal']);?>">
										</div>
									</div>
									<label class="col-lg-1 control-label">Durasi</label>	
									<div class="col-lg-2">
										<div class="input-group clockpicker">
											<select type="text" id="durasi" name="durasi" class="form-control timepicker-durasi" value="<?php if(isset($_SESSION['durasi'])){echo $_SESSION['durasi'];}else { echo '60';}unset($_SESSION['durasi']);?>">
												<?php
												$i=0;
													for ($i=15; $i<300; $i= $i + 15){
														if($i == 60){
															echo "<option value='".$i."' selected>".$i." menit</option>";
														}
														else {
															echo "<option value='".$i."'>".$i." menit</option>";
														}
													}
												?>
											</select>
										</div>
									</div>
									<label class="col-lg-1 control-label">Jam Akhir</label>	
									<div class="col-lg-3">
										<div class="input-group clockpicker">
											<input type="text" id="jam_akhir" name="jam_akhir" class="form-control" readonly value="<?php if(isset($_SESSION['jam_akhir'])){echo $_SESSION['jam_akhir'];}else { echo '08:00';}unset($_SESSION['jam_akhir']);?>">
										</div>
									</div>
							</div>
							<br>
							<br>
							<div class="form-group">
								<div class="col-lg-offset-1 col-lg-6">
									<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;&nbsp;
									<a href="?p=shift"><button type="button" class="btn btn-default">Batal</button></a>
								</div>	
							</div> 
						</form>
					</div>
				</div>
	
			</div>
		</div>
	</div>
</div> <!-- Page content end -->