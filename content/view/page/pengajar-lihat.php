<?php
	$limit = 10;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;
    require_once ('content/classes/pengajarClass.php');
    require_once ('content/fungsi.php');
	
    $pengajar = new pengajar();    
    $dataPengajar = $pengajar->getPengajar($start_from);
?>
<div class="page-content">
	<!-- Heading -->
		<div class="single-head">
			<!-- Heading -->
			<h3 class="pull-left"><i class="fa fa-table"></i> Data Pengajar</h3>
			<div class="clearfix"></div>
		</div>
		<!-- Table Page -->
		<div class="widget-body">
			<?php
			if(isset($_GET['sub'])){
				if($_GET['sub'] == 'lihat'){
					echo "<a href='?p=pengajar&sub=tambah'><button type='button' class='btn btn-primary'>Tambah Baru</button></a><br><br>";
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
					else if($_SESSION['notif']=="deleteSukses"){
						echo"<div class='alert alert-warning alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								Data ".$_SESSION['namanya']." telah dihapus
							</div>";
						unset($_SESSION['notif']);
						unset($_SESSION['namanya']);
					}
					else if($_SESSION['notif']=="deleteGagal"){
						echo"<div class='alert alert-danger alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								<strong>Kesalahan</strong> Data gagal dihapus, masih terdapat jadwal yang terkait dengan pengajar tersebut!
							</div>";
						unset($_SESSION['notif']);
						unset($_SESSION['namanya']);
					}
				}
			?>
			<!-- Pagination -->
		<?php
		$pagination = new pagination();		
		$num = $pagination->totalRecord('pengajar', $limit);
		if($page>1){
			$prev = $page - 1;
			$prevpage = "?p=pengajar&sub=lihat&page=$prev";
			$classprev = '';
		}
		else {
			$prevpage = '#';
			$classprev = 'disabled';
		}
		if($page<$num){
			$next = $page + 1;
			$nextpage = "?p=pengajar&sub=lihat&page=$next";
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
					$pagLink .= "<li><a href='?p=pengajar&sub=lihat&page=".$i."'>".$i."</a></li>";
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
                        <th>Pendidikan</th>
						<th>Tempat/Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th colspan="2" width="20%">Manage</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if($dataPengajar === null){
							echo"<tr>"
								. "<td colspan='7'><div class='alert alert-danger text-center'>Data Kosong"
								."</div></td>"
								. "</tr>";
						}
					else {
						$i=($page * 10)-9;
                        foreach ($dataPengajar as $data) {
                            if(isset($_GET['edit']) && $_GET['edit']==md5($data['id'])){
                                echo"<form role='form' method='post' action='content/proses.php?act=editPengajar'><tr class='br-grey'>"
                                    . "<td>".$i."<input type='hidden' class='form-control' name='idPengajar' value='".md5($data['id'])."' readonly></td>"
                                    . "<td><input class='form-control' name='namaPengajar' value='".$data['nama']."' required></td>"
									. "<td><input class='form-control' name='pendidikanPengajar' value='".$data['pendidikan']."'></td>"
                                    . "<td><input class='form-control' name='tempatPengajar' value='".$data['tempat']."'><input type='date' class='form-control' name='tanggalPengajar' value='".$data['tanggal']."'></td>"
                                    . "<td><input class='form-contr	ol' name='alamatPengajar' value='".$data['alamat']."' required></td>"
									. "<td><input class='form-contr	ol' name='telpPengajar' value='".$data['telepon']."' required></td>"
									. "<td><input type='submit' class='btn btn-success btn-block btn-sm' value='Simpan'></td>"
									. "<td><a href='?p=pengajar&sub=lihat&page=".$page."' class='btn btn-default btn-block btn-sm'>Batal</a></td>"
                                    . "</tr></form>";
                            }
							else if(isset($_GET['edit']) && $_GET['edit']!=md5($data['id'])){
                                echo"<tr>"
									. "<td>".$i."</td>"
                                    . "<td>".$data['nama']."</td>"
                                    . "<td>".$data['pendidikan']."</td>"
                                    . "<td>".$data['tempat']."/ ".tanggallahir($data['tanggal'])."</td>"
                                    . "<td>".$data['alamat']."</td>"
                                    . "<td>".$data['telepon']."</td>"
                                    . "<td><a href='?p=pengajar&sub=lihat&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm'  disabled='disabled'>Edit Data</a></td>"
                                    . "<td><a href='?p=pengajar&sub=lihat&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm'  disabled='disabled'>Hapus</a></td>"
                                    . "</tr>";
                            }
							else if(isset($_GET['c']) && $_GET['c']==md5($data['id'])){
								echo "<tr class='br-lred'>"
									."<td colspan='6'>"
									."<form role='form' method='post' action='content/proses.php?act=deletePengajar'>"
									."<p class='text-center'><strong>Yakin</strong> untuk menghapus data ini ?</p>"
									."<input type='hidden' class='form-control' name='idPengajar' value='".md5($data['id'])."' readonly>"
									."<input type='hidden' class='form-control' name='namaPengajar' value='".$data['nama']."' readonly></td>"
									."<td><input type='submit' class='btn btn-sm btn-block btn-danger pull-right' value='Hapus Data'></td>"
									."<td><a href='?p=pengajar&sub=lihat&page=".$page."' class='btn btn-sm btn-block btn-warning pull-right'>Batal</a></td>"
									."</form>"
									."</td></tr>";
							}
							else if(isset($_GET['c']) && $_GET['c']!=md5($data['id'])){
							   echo"<tr>"
									. "<td>".$i."</td>"
                                    . "<td>".$data['nama']."</td>"
                                    . "<td>".$data['pendidikan']."</td>"
                                    . "<td>".$data['tempat']."/ ".tanggallahir($data['tanggal'])."</td>"
                                    . "<td>".$data['alamat']."</td>"
                                    . "<td>".$data['telepon']."</td>"
                                    . "<td><a href='?p=pengajar&sub=lihat&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm'  disabled='disabled'>Edit Data</a></td>"
                                    . "<td><a href='?p=pengajar&sub=lihat&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm'  disabled='disabled'>Hapus</a></td>"
                                    . "</tr>";
							}
                            else{
                                echo"<tr>"
									. "<td>".$i."</td>"
                                    . "<td>".$data['nama']."</td>"
                                    . "<td>".$data['pendidikan']."</td>"
                                    . "<td>".$data['tempat']."/ ".tanggallahir($data['tanggal'])."</td>"
                                    . "<td>".$data['alamat']."</td>"
                                    . "<td>".$data['telepon']."</td>"
                                    . "<td><a href='?p=pengajar&sub=lihat&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm'>Edit Data</a></td>"
                                    . "<td><a href='?p=pengajar&sub=lihat&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm'>Hapus</a></td>"
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