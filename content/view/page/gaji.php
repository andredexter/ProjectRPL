<?php
$tanggal = date('Y-m-d');
require_once ('content/classes/laporanClass.php');
require_once ('content/classes/fungsiClass.php');

$gaji= new laporangaji();
$fungsi= new fungsi();
$month = $fungsi->getMonth($tanggal);
?>

<div class="page-content">

	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Penggajian Pengajar
			<?php if(isset($_POST['month'])){
				echo "pada bulan ". $fungsi->getMonthName($_POST['month']);
				?>
				<br>
				<br>
				<form class="form-horizontal" role="form" action="" method="post">
					<div class="input-group input-group-sm">
						<input type="month" id="month" name="month" class="form-control" type="text" value="<?php echo $_POST['month']?>"/>
						<span class="input-group-btn"><input type="submit" class="btn btn-primary submit" value="Lihat"></input></span>
					</div>
				</form>
				<?php
			}?>
		</h3>
		<div class="clearfix"></div>
	</div>
	<?php
	if(isset($_POST['month'])){
		$getPenggajian = $gaji->getPenggajian($_POST['month']);
		?>
		<table class="table table-hover table-bordered ">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama</th>
                        <th>Jumlah Mengajar</th>
                        <th colspan="2" width="20%">Manage</th>
					</tr>
				</thead>
				<tbody>
		<?php
		if($getPenggajian == null){
			echo"<tr>"
				. "<td colspan='10'><div class='alert alert-danger text-center'>Data Kosong"
				."</div></td>"
				. "</tr>";
		}
		else{
			$i=1;
			foreach ($getPenggajian as $data) {
				 echo "<tr>"
					. "<td>".$i."</td>"
					. "<td>".$data['nama_pengajar']."</td>";
					if($data['jumlah_mengajar'] == 0){
						echo "<td>Tidak ada record mengajar yang dicatat pada bulan ini</td>";
						echo "<td><form method='post' action='content/report/laporangaji.php'>"
										."<input type='hidden' id='idpengajar' name='idpengajar' value='".md5($data['id_pengajar'])."' required>"
										."<input type='hidden' id='bln' name='bln' value='".$_POST['month']."' required>"
										."<button type='submit' class='btn btn-block btn-success disabled' formtarget='_blank'>Print Gaji</button></td>"
										."</form></td>";					
					}
					else {
						echo "<td>".$data['jumlah_mengajar']." orang siswa</td>";
						echo "<td><form method='post' action='content/report/laporangaji.php'>"
										."<input type='hidden' id='idpengajar' name='idpengajar' value='".md5($data['id_pengajar'])."' required>"
										."<input type='hidden' id='bln' name='bln' value='".$_POST['month']."' required>"
										."<button type='submit' class='btn btn-block btn-success' formtarget='_blank'>Print Gaji</button></td>"
										."</form></td>";
					}
				 
					echo "</tr>";
				
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
						<div class="col-lg-offset-3 col-lg-9">
							<input type="submit" class="btn btn-primary submit" value="Lihat"></input>&nbsp;
							<a href="./"><button type="button" class="btn btn-default">Kembali</button></a>
						</div>	
					</div>
				</form>
			</div> <!-- Form page end -->
		
		<?php
	} 
	
	?>
</div> <!-- Page content end -->