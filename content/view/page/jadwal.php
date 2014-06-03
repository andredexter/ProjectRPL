<?php
    require_once ('content/classes/jadwalClass.php');
	$jadwal= new jadwal();
	$dataHari = $jadwal->selectDays();
	$dataJadwal = $jadwal->selectJadwal();
?>
<div class="page-content">
	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-credit-card lblue"></i> Jadwal Pelajaran</h3>
		<div class="clearfix"></div>
	</div>
	<?php
		if(isset($_SESSION['notif'])){
			if($_SESSION['notif'] == 'successJadwal') {
				echo "<div class='alert alert-success alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
					<strong>Berhasil!</strong> Jam Belajar berhasil disimpan.
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
						function listbaru(){
							$i=0;
							for ($i=15; $i<300; $i= $i + 15){
								echo "<option value='".$i."'>".$i." menit</option>";
							}
						}
						$baru = listbaru();
						$i=1;
                        foreach ($dataHari as $data) {
								echo "<div class='col-md-12'>"
									."<div class='judul'><strong>".$data['nama']."</strong></div>"
									."<div class='rowbaru'>";
									 $ii = 0;
									 $j = 0;
									 echo "<table class='table table-hover '>"
										. "<thead class='text-center'><tr class='text-center'>"
										. "<th class='text-center'>Jam</th>"
										. "<th class='text-center'>Nama Siswa</th>"
										. "<th class='text-center'>Nama Pengajar</th>"
										. "<th></th>"
										. "</tr></thead>";
								if($dataJadwal === null){
									echo "";
									}
								else{
									foreach($dataJadwal as $data2){
										if($data2['id_hari'] == $data['id']){
											if(isset($_GET['c']) && $_GET['c']==md5($data2['id_jadwal'])){
												echo "<tr class='text-center'><td colspan='5'><form class='red' role='form' method='post' action='content/proses.php?act=deleteJadwal'>"
													."<input type='hidden' name='idjadwal' id='idjadwal' value='".md5($data2['id_jadwal'])."'>"
													."Hapus jadwal ".$data2['nama_siswa']."(".$data2['nama_instrument'].") ?";
												echo "<p><input type='submit' class='btn btn-warning' value='&nbsp;Ya&nbsp;'> <a href='?p=jadwal' class=''><button type='button' class='btn' >Tidak</button></a></p></form><td></tr>";
												$j++;
											}
											else{
												echo"<tr>"
													. "<td>".$jadwal->showJam($data2['jam_mulai'])."-".$jadwal->showJam($data2['jam_akhir'])."</td>"
													. "<td>".$data2['nama_siswa']." (".$data2['nama_instrument'].")</td>"
													. "<td>".$data2['nama_pengajar']."</td>"
													. "<td>"
													."<a href='?p=jadwal&c=".md5($data2['id_jadwal'])."' data-toggle='modal'><button class='btn btn-xs btn-warning pull-right'><i class='fa fa-times'></i></button></a>"
													. "</td>"
													. "</tr>";
													
													
												$j++;
											}
										}
										$i++;
									 }
								}
									 
									 
								if ($j == 0){
									echo "<tr><td colspan='5' class='red'>Jadwal Kosong</p>";
								}
								echo "</table>";
								echo "</div>"
									."<p><a href='?p=jadwal&sub=tambah&id=".$data['id']."'><button type='button' class='btn btn-default'><i class='fa fa-plus'></i><span>Tambah</span></button></a></p></div>";
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