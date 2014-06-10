<?php
    require_once ('content/classes/shiftClass.php');
    require_once ('content/fungsi.php');
	
	$shift= new shiftTime();
	
	$dataHari = $shift->selectDays();
	$dataShift = $shift->selectShift();
	$max = $shift->maxHari();
?>
<div class="page-content">
	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Atur Jadwal dan Jam Pelajaran</h3>
		<div class="clearfix"></div>
	</div>
	<?php
		if(isset($_SESSION['notif'])){
			if($_SESSION['notif'] == 'successShift') {
				echo "<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					<strong>Berhasil!</strong> Jam Belajar berhasil disimpan.
					</div>";
			}
			else if($_SESSION['notif'] == 'editSukses') {
				echo "<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					<strong>Berhasil!</strong> Jam Belajar berhasil diperbaharui.
					</div>";
			}
			else if($_SESSION['notif'] == 'editGagal') {
				echo "<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					<strong>Kesalahan!</strong> Jam Belajar gagal diperbaharui.
					</div>";
			}
			else if($_SESSION['notif'] == 'deleteSukses') {
				echo "<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					<strong>Berhasil!</strong> Jam Belajar telah dihapus.
					</div>";
			}
			else if($_SESSION['notif'] == 'deleteGagal') {
				echo "<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					<strong>Kesalahan!</strong> Jam Belajar gagal dihapus.
					</div>";
			}
			unset($_SESSION['notif']);
		}
	?>
	<div class="page-grid">
		<div class="container">
			<div class="row show-grid">
			<?php
					if($dataHari === null){
							echo"<tr>"
								. "<td colspan='7'><div class='alert alert-danger text-center'>Data Kosong"
								."</div></td>"
								. "</tr>";
						}
					else {
						$i=1;
                        foreach ($dataHari as $data) {
								echo "<div class='col-md-3'>"
									."<div class='judul'>".$data['nama']."</div>"
									."<div class='rowbaru'>";
									if($dataShift == null){
										echo "";
									}
									else{
									 $ii = 0;
									 $j = 0;
									 foreach($dataShift as $data2){
										if($data2['id_hari'] == $data['id']){
											if(isset($_GET['edit']) && $_GET['edit']==md5($data2['id'])){
												echo "<form role='form' method='post' action='content/proses.php?act=editShift'><p class='inip'>"
													."<input type='hidden' name='idshift' id='idshift' value='".md5($data2['id'])."'>"
													."<input type='text' class='form-control-new timepicker' name='awal' id='awal' value='".regenerateJam($data2['mulai'])."'>"
													." - <input type='text' class='form-control-new timepicker' name='akhir' id='akhir' value='".regenerateJam($data2['akhir'])."'>";
												echo "<input type='submit' class='btn btn-xs btn-success pull-right' value='&nbsp;Save&nbsp;'></p></form>";
												$j++;
											}
											else if(isset($_GET['c']) && $_GET['c']==md5($data2['id'])){
												echo "<form class='red' role='form' method='post' action='content/proses.php?act=deleteShift'>"
													."<input type='hidden' name='idshift' id='idshift' value='".md5($data2['id'])."'>"
													."Hapus ".regenerateJam($data2['mulai'])." - ".regenerateJam($data2['akhir'])."?";
												echo "<a href='?p=shift' class='pull-right'><button type='button' class='btn btn-xs pull-right' >Tidak</button></a><input type='submit' class='btn btn-xs btn-warning pull-right' value='&nbsp;Ya&nbsp;'></form>";
												$j++;
											}
											else{
												echo "<p class='inip'>".regenerateJam($data2['mulai'])." - ".regenerateJam($data2['akhir'])
													."<a href='?p=shift&c=".md5($data2['id'])."' data-toggle='modal'><button class='btn btn-xs pull-right'><i class='fa fa-times'></i></button></a>"
													."<a href='?p=shift&edit=".md5($data2['id'])."'><button class='btn btn-xs btn-success pull-right'><i class='fa fa-pencil'></i> </button></a></p>";
												$j++;
											}
										}
										$i++;
									 }
									 if ($j == 0){
										echo "<p class='inip'>Shift Kosong</p>";
										for($ii = $j+1; $ii< $max; $ii++){
											echo "<p class='inip'></p>";
										}									
									 }
									 else {
										if($j < $max){
											for($ii = $j; $ii< $max; $ii++){
												echo "<p class='inip'></p>";
											}
										}
									 }
									}
								echo "</div>"
									."<p><a href='?p=shift&sub=add&id=".$data['id']."'><button type='button' class='btn btn-default'><i class='fa fa-plus'></i><span>Tambah</span></button></a></p></div>";
								$i++;
							
						}
					}
                    ?>                                                                       
			</div>
			<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<p>Hapus data ini ?</p>
							<?php
							 if(isset($_GET['c'])){
								echo $_GET['c'];
							 }
							?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
							<button type="button" class="btn btn-primary btn-sm">Save changes</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	
</div> <!-- Page content end -->