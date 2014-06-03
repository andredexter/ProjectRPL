<?php
	$limit = 10;  
	if (isset($_GET["page"])) { $page = $_GET["page"]; } else { $page=1; };
	$start_from = ($page-1) * $limit;
    require_once ('content/classes/fungsiClass.php');
    require_once ('content/classes/instrumentClass.php');
	$fungsi = new fungsi();
    $instrument= new instrument();
    $dataInstrument = $instrument->getInstrument($start_from);  

?>
<div class="page-content">
	<!-- Heading -->
	<div class="single-head">
		<!-- Heading -->
		<h3 class="pull-left"><i class="fa fa-table purple"></i> Data Instrument</h3>
		<div class="clearfix"></div>
	</div>
	<!-- Table Page -->
	<div class="page-tables">
		<!-- Heading -->
		<?php
			if(!isset($_GET['sub'])){
				echo "<a href='?p=instrument&sub=tambah'><button type='button' class='btn btn-primary'>Tambah Baru</button></a><br><br>";
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
			}
		?>
		<!-- Pagination -->
		<?php
		$pagination = new pagination();		
		$num = $pagination->totalRecord('instrument', $limit);
		if($page>1){
			$prev = $page - 1;
			$prevpage = "?p=instrument&page=$prev";
			$classprev = '';
		}
		else {
			$prevpage = '#';
			$classprev = 'disabled';
		}
		if($page<$num){
			$next = $page + 1;
			$nextpage = "?p=instrument&page=$next";
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
					$pagLink .= "<li><a href='?p=instrument&page=".$i."'>".$i."</a></li>";
			  };  
			  echo $pagLink;
		echo "<li class='".$classnext."'><a href='".$nextpage."'>&raquo;</a></li>"
			."</ul>"
			."<div class='clearfix'></div>";
			// echo $pagLink . “</div>”;  
		?>
		
		<!-- Table -->
		<div class="table-responsive">
			<table class="table table-bordered ">
				<thead>
					<tr>
						<th>#</th>
						<th>Jenis Instrument</th>
						<th>Biaya Per Bulan</th>
						<th colspan="2" width="15%">Manage</th>	
					</tr>
				</thead>
				<tbody>
					<?php
						if($dataInstrument === null){
							echo"<tr>"
								. "<td colspan='4'><div class='alert alert-danger text-center'>Data Kosong"
								."</div></td>"
								. "</tr>";
						}
						else {
							$i=($page * 10)-9;
							foreach ($dataInstrument as $data) {
								if(isset($_GET['edit']) && $_GET['edit']==md5($data['id'])){
									echo"<form role='form' method='post' action='content/proses.php?act=editInstrument'><tr class='br-grey'>"
										. "<td>".$i."<input type='hidden' class='form-control' name='idInstrument' value='".md5($data['id'])."' readonly></td>"
										. "<td><input class='form-control' name='namaInstrument' value='".$data['nama']."' required></td>"
										. "<td><input class='form-control' name='biayaInstrument' value='".$data['biaya']."' required></td>"
										. "<td><input type='submit' class='btn btn-success btn-block btn-sm' value='Simpan'></td>"
										. "<td><a href='?p=instrument&page=".$page."' class='btn btn-default btn-block btn-sm'>Batal</a></td>"
										. "</tr></form>";
								}
								else if(isset($_GET['edit']) && $_GET['edit']!=md5($data['id'])){
									echo"<tr class=''>"
										. "<td>".$i."</td>"
										. "<td>".$data['nama']."</td>"
										. "<td>".$data['biaya']."</td>"
										. "<td><a href='?p=instrument&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm' disabled='disabled'>Edit Data</a></td>"
										. "<td><a href='?p=instrument&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm' disabled='disabled'>Hapus</a></td>"
										. "</tr>";
								}
								else if(isset($_GET['c']) && $_GET['c']==md5($data['id'])){
									echo "<tr class='br-lred'>"
										."<td colspan='3'>"
										."<form role='form' method='post' action='content/proses.php?act=deleteInstrument'>"
										."<p class='text-center'><strong>Yakin</strong> untuk menghapus data ini ?</p>"
										."<input type='hidden' class='form-control' name='idInstrument' value='".md5($data['id'])."' readonly>"
										."<input type='hidden' class='form-control' name='namaInstrument' value='".$data['nama']."' readonly></td>"
										."<td><input type='submit' class='btn btn-sm btn-block btn-danger pull-right' value='Hapus Data'></td>"
										."<td><a href='?p=instrument&page=".$page."' class='btn btn-sm btn-block btn-default pull-right'>Batal</a></td>"
										."</form>"
										."</td></tr>";
								}
								else if(isset($_GET['c']) && $_GET['c']!=md5($data['id'])){
									echo"<tr>"
										. "<td>".$i."</td>"
										. "<td>".$data['nama']."</td>"
										. "<td>".$data['biaya']."</td>"
										. "<td><a href='?p=instrument&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm' disabled='disabled'>Edit Data</a></td>"
										. "<td><a href='?p=instrument&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm' disabled='disabled'>Hapus</a></td>"
										. "</tr>";
								}
								else{
									echo"<tr>"
										. "<td>".$i."</td>"
										. "<td>".$data['nama']."</td>"
										. "<td> Rp. ".$fungsi->formatindo($data['biaya'])."</td>"
										. "<td><a href='?p=instrument&page=".$page."&edit=".md5($data['id'])."' class='btn btn-warning	btn-block  btn-sm'>Edit Data</a></td>"
										. "<td><a href='?p=instrument&page=".$page."&c=".md5($data['id'])."' class='btn btn-danger	btn-block  btn-sm'>Hapus</a></td>"
										. "</tr>";
								}
								$i++;
							}
						}
                    ?>   	  
				</tbody>
			</table>
		</div>
		
	</div>
</div>