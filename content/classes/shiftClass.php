<?php
	require_once ('fungsiClass.php');

	class shiftTime extends dbController{
		public function selectShift() {
			$this->dbOpen();
			$sql = "SELECT * FROM shift ORDER BY jam_mulai ASC";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataShift[$i]['id'] = $row[0];
					$dataShift[$i]['id_hari'] = $row[1];
					$dataShift[$i]['mulai'] = $row[2];
					$dataShift[$i]['akhir'] = $row[3];
					$i++;
				}
			}else{ 
				$dataShift= null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataShift;        		
		}
				
		public function cekShift($id, $awal, $akhir){
			$this->dbOpen();
			$sql = "SELECT COUNT(*) AS cekShift FROM shift WHERE id_hari = '$id' AND jam_mulai = '$awal' AND jam_akhir = '$akhir'";
			$query = mysqli_query($this->conn, $sql);
			$row =  mysqli_fetch_array($query);
			$rows = $row['cekShift'];
			return $rows;
		}
		
		public function saveShift($id, $awal, $akhir) {
			$this->dbOpen();
			$fungsi = new fungsi();
			$id = mysqli_real_escape_string($this->conn, $id);
			$awal= mysqli_real_escape_string($this->conn, $awal);
			$akhir= mysqli_real_escape_string($this->conn, $akhir);
			
			$baris = $this->cekShift($id, $fungsi->generateJam($awal), $fungsi->generateJam($akhir));
			
			if($baris!=0){
				$_SESSION['notif']="wrongShift";
				$_SESSION['jam_awal']=$fungsi->regenerateJam($awal);
				$_SESSION['jam_akhir']=$fungsi->regenerateJam($akhir);
				header('Location: ../?p=shift&sub=add&id='.$id);
			}
			else{
				$sql="INSERT INTO shift(id_shift, id_hari, jam_mulai, jam_akhir)"
				   . "VALUES ('', '$id', '$awal', '$akhir')";
				$query=mysqli_query($this->conn, $sql);
				if ($query==true){
					$_SESSION['notif']="successShift";
				}
				$this->dbClose();
				header('Location: ../?p=shift');
			}
		}
		
		public function editShift($id, $mulai, $akhir) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$mulai= mysqli_real_escape_string($this->conn, $mulai);
			$akhir= mysqli_real_escape_string($this->conn, $akhir);
			
			$sql = "UPDATE shift SET jam_mulai='$mulai', jam_akhir='$akhir' WHERE md5(id_shift)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="editSukses";
			}
			else {
				$_SESSION['notif']="editGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=shift');
		}
		
		public function deleteShift($id) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
					
			$sql = "DELETE FROM shift WHERE md5(id_shift)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="deleteSukses";
				$_SESSION['namanya']=$nama;
			}
			else {
				$_SESSION['notif']="deleteGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=shift');
		}

		function selectDays(){
			$this->dbOpen();
			$sql = "SELECT * FROM hari ORDER BY id_hari";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataHari[$i]['id'] = $row[0];
					$dataHari[$i]['nama'] = $row[1];
					$i++;
				}
			}else{ 
				$dataHari = null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataHari;        
		}
		
		function maxHari(){
			$this->dbOpen();
			$sql = "SELECT count(id_hari) AS 'total' FROM shift GROUP BY (id_hari) ORDER BY (total) DESC LIMIT 1";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$max = $row[0];
					$i++;
				}
			}else{ 
				$max = 7;
			}
			
			unset($i);
			$this->dbClose();
			return $max;        		
		}

	}
?>