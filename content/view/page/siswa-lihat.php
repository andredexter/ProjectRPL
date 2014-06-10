<?php	
	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;
    require_once ('content/classes/siswaClass.php');
	require_once ('content/classes/tingkatClass.php');
	require_once ('content/classes/instrumentClass.php');
	require_once ('content/fungsi.php');
	
	$instrument= new instrument();
    $siswa = new siswa();
    $tingkat = new tingkat();
    
    $dataInstrument = $instrument->getInstrument('*');  
    $dataSiswa = $siswa->getSiswa($start_from);
	
    $dataTingkat = $tingkat->getTingkat();  
	$warna = array("0"=>"default",
					"1"=>"info",
					"2"=>"primary",
					"3"=>"success",
					"4"=>"yellow",
					"5"=>"purple",
					"6"=>"rose",
					"7"=>"brown",
					"8"=>"warning",
					"9"=>"black");
	$tanggal = date('Y-m-d');				
	$month = getMonth($tanggal);
?>
<div class="page-content">
	<!-- Heading -->
		<div class="single-head">
			<!-- Heading -->
			<h3 class="pull-left"><i class="fa fa-table"></i> Data Siswa</h3>
			<div class="clearfix"></div>
		</div>
		<!-- Table Page -->
		<div class="widget-body">
			<?php
			if(isset($_GET['sub'])){
				if($_GET['sub'] == 'lihat'){
					echo "<a href='?p=siswa&sub=tambah'><button type='button' class='btn btn-primary'>Tambah Baru</button></a><br><br>";
				}
			}
			if(isset($_SESSION['notif'])){
				if($_SESSION['notif']=="editSukses"){
					echo"<div class='alert alert-success alert-dismissable'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							Data ".$_SESSION['namanya']." telah berhasil diperbaharui
						</div>";
					unset($_SESSION['notif']);
					unset($_SESSION['namanya']);
				}
				else if($_SESSION['notif']=="editGagal"){
					echo"<div class='alert alert-danger alert-dismissable'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							GAGAL ! Data ".$_SESSION['namanya']." telah gagal diperbaharui
						</div>";
					unset($_SESSION['notif']);
					unset($_SESSION['namanya']);
				}
				else if($_SESSION['notif']=="deleteSukses"){
					echo"<div class='alert alert-warning alert-dismissable'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							Data ".$_SESSION['namanya']." telah dihapus
						</div>";
					unset($_SESSION['notif']);
					unset($_SESSION['namanya']);
				}
			}
			?>
			<!-- Pagination -->
		<?php
		$pagination = new pagination();		
		$num = $pagination->totalRecord('siswa', $limit);
		if($page>1){
			$prev = $page - 1;
			$prevpage = "?p=siswa&sub=lihat&page=$prev";
			$classprev = '';
		}
		else {
			$prevpage = '#';
			$classprev = 'disabled';
		}
		if($page<$num){
			$next = $page + 1;
			$nextpage = "?p=siswa&sub=lihat&page=$next";
			$classnext = '';
		}
		else {
			$nextpage = '#';
			$classnext = 'disabled';
		}
		$pagLink = '';
		echo "<ul class='pagination pagination-sm pull-right'>"
			."<li class='".$classprev."'><a href='".$prevpage."'>&laquo;</a></li>";
			  for ($i=1; $i<=$num; $i++) {  
					$pagLink .= "<li><a href='?p=siswa&sub=lihat&page=".$i."'>".$i."</a></li>";
			  };  
			  echo $pagLink;
		echo "<li class='".$classnext."'><a href='".$nextpage."'>&raquo;</a></li>"
			."</ul>"
			."<div class='clearfix'></div>";
			// echo $pagLink . “</div>”;  
		?>
			<!-- Table -->
			<div class="table-responsive">
				<table class="table table-hover table-bordered ">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama</th>
                        <th>TTL</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Instrument</th>
                        <th>Tingkat</th>
                        <th>Uang Bulan Ini</th>
                        <th>Bukti Pendaftaran</th>
                        <th colspan="2" width="20%">Manage</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if($dataSiswa === null){
							echo"<tr>"
								. "<td colspan='10'><div class='alert alert-danger text-center'>Data Kosong"
								."</div></td>"
								. "</tr>";
						}
					else {
						$i=($page * 10)-9;
                        foreach ($dataSiswa as $data) {
                            if(isset($_GET['edit']) && $_GET['edit']==md5($data['id'])){
                                echo"<form role='form' method='post' action='content/proses.php?act=editSiswa'><tr>"
                                    . "<td>".$i."<input type='hidden' class='form-control' name='idSiswa' value='".md5($data['id'])."' readonly></td>"
                                    . "<td><input class='form-control' name='nama' value='".$data['nama']."' required></td>"
                                    . "<td><input class='form-control' name='tempatlahir' value='".$data['tempatlahir']."'>"
									. "	   <input type='date' class='form-control' name='tanggallahir' value='".$data['tanggallahir']."'></td>"
                                    . "<td><input class='form-control' name='alamat' value='".$data['alamat']."'></td>"
                                    . "<td><input class='form-control' name='telepon' value='".$data['telepon']."'></td>"
                                    . "<td>"
									. "<select id='instrument' name='instrument' class='form-control-new'>";
									if($dataInstrument === null){
										echo"<option>- Instrument tidak ada -</option>";
									}
									else {
										$i=1;
										foreach ($dataInstrument as $data2) {
											if($data2['id'] == $data['id_instrument']){
												echo"<option value='".$data2['id']."' selected='selected'>".$data2['nama']."</option>";
											}
											else {
												echo"<option value='".$data2['id']."'>".$data2['nama']."</option>";
											}
											$i++;
										}
									}
									echo "</select>"
                                    . "<td>"
									. "<select id='tingkat' name='tingkat' class='form-control-new'>";
										$i=1;
										foreach ($dataTingkat as $data3) {
											if($data3['id_tingkat'] == $data['id_tingkat']){
												echo"<option value='".$data3['id_tingkat']."' selected='selected'>".$data3['nama_tingkat']."</option>";
											}
											else {
												echo"<option value='".$data3['id_tingkat']."'>".$data3['nama_tingkat']."</option>";
											}
											$i++;
										}
									echo "</td>";
																			
									$cek = $siswa->cekBayar($month, $data['id']);
									if($data['biaya_instrument'] == $cek){
										echo "<td><span class='badge badge-success'><i class='fa fa-check'></i>&nbsp;Sudah</span></td>";
									}
									else{
										echo "<td><span class='badge'><i class='fa fa-times'></i>&nbsp;Belum</span></td>";
									}
								
									echo  "<td><a href='#' class='btn btn-black	btn-block  btn-sm' disabled='disabled'>Cetak</a></td>"
									. "<td><input type='submit' class='btn btn-success btn-block btn-sm' value='Simpan'></td>"
									. "<td><a href='?p=siswa&sub=lihat&page=".$page."' class='btn btn-default btn-block btn-sm'>Batal</a></td>"
                                    . "</tr></form>";
                            }
							else if(isset($_GET['c']) && $_GET['c']==md5($data['id'])){
								echo "<tr class='br-lred'>"
									."<td colspan='9'>"
									."<form role='form' method='post' action='content/proses.php?act=deleteSiswa'>"
									."<p class='text-center'><strong>Yakin</strong> untuk menghapus data ini ?</p>"
									."<input type='hidden' class='form-control' name='idSiswa' value='".md5($data['id'])."' readonly>"
									."<input type='hidden' class='form-control' name='namaSiswa' value='".$data['nama']."' readonly></td>"
									."<td><input type='submit' class='btn btn-sm btn-block btn-danger pull-right' value='Hapus Data'></td>"
									."<td><a href='?p=siswa&sub=lihat&page=".$page."' class='btn btn-sm btn-block btn-warning pull-right'>Batal</a></td>"
									."</form>"
									."</td></tr>";
							}
							else if(isset($_GET['c']) && $_GET['c']!=$data['id']){
							   echo"<tr>"
									. "<td>".$i."</td>"
                                    . "<td>".$data['nama']."</td>"
                                    . "<td>".$data['tempatlahir']."/ ".tanggallahir($data['tanggallahir'])."</td>"
                                    . "<td>".$data['alamat']."</td>"
                                    . "<td>".$data['telepon']."</td>"
                                    . "<td>".$data['nama_instrument']."</td>";
										$po=1;
										foreach ($dataTingkat as $data3) {
											if($data3['id_tingkat'] == $data['id_tingkat']){
												echo "<td><span class='badge badge-".$warna[$data['class']]."'>".$data['tingkat']."</span></td>";
											}
											else {
												
											}
											$po++;
										}
										
									$cek = $siswa->cekBayar($month, $data['id']);
									if($data['biaya_instrument'] == $cek){
										echo "<td><span class='badge badge-success'><i class='fa fa-check'></i>&nbsp;Sudah</span></td>";
									}
									else{
										echo "<td><span class='badge'><i class='fa fa-times'></i>&nbsp;Belum</span></td>";
									}
								
                                echo "<td><a href='#' class='btn btn-black		btn-block  btn-sm' disabled='disabled'>Cetak</a></td>"
                                    . "<td><a href='?p=siswa&sub=lihat&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm'  disabled='disabled'>Edit Data</a></td>"
                                    . "<td><a href='?p=siswa&sub=lihat&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm'  disabled='disabled'>Hapus</a></td>"
                                    . "</tr>";
							}
                            else{
                                echo"<tr>"
									. "<td>".$i."</td>"
                                    . "<td>".$data['nama']."</td>"
                                    . "<td>".$data['tempatlahir']."/ ".tanggallahir($data['tanggallahir'])."</td>"
                                    . "<td>".$data['alamat']."</td>"
                                    . "<td>".$data['telepon']."</td>"
                                    . "<td>".$data['nama_instrument']."</td>";
										$po=1;
										foreach ($dataTingkat as $data3) {
											if($data3['id_tingkat'] == $data['id_tingkat']){
												echo "<td><span class='badge badge-".$warna[$data['class']]."'>".$data['tingkat']."</span></td>";
											}
											else {
												
											}
											$po++;
										}
										
									$cek = $siswa->cekBayar($month, $data['id']);
									if($data['biaya_instrument'] == $cek){
										echo "<td><span class='badge badge-success'><i class='fa fa-check'></i>&nbsp;Sudah</span></td>";
									}
									else{
										echo "<td><span class='badge'><i class='fa fa-times'></i>&nbsp;Belum</span></td>";
									}
								

                                echo "<td><form method='post' action='content/report/pendaftaran.php'>"
									."<input type='hidden' id='idsiswa' name='idsiswa' value='".md5($data['id'])."' required>"
									."<button type='submit' class='btn btn-block btn-black' formtarget='_blank'>Cetak</button></td>"
									."</form>";
                                echo "<td><a href='?p=siswa&sub=lihat&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm'>Edit Data</a></td>"
                                    . "<td><a href='?p=siswa&sub=lihat&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm'>Hapus</a></td>"
                                    . "</tr>";
                            }
							$i++;
                                            
                        }
					}
                    ?>                                                                       
				</tbody>
			</table>
			<div class="clearfix"></div>
		</div>
		
		
	</div>
</div>