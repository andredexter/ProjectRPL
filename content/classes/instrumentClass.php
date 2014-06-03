<?php
	class instrument extends dbController{
		public function getInstrument($start) {
			$this->dbOpen();
			$start= mysqli_real_escape_string($this->conn, $start);
			
			if($start == "*"){
				$kondisi = "";
			}	
			else {
				$kondisi = "LIMIT $start, 10";
			}
			
			$sql = "SELECT id_instrument, nama_instrument, biaya_instrument FROM instrument ORDER BY nama_instrument ASC $kondisi";			
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataInstrument[$i]['id'] = $row[0];
					$dataInstrument[$i]['nama'] = $row[1];
					$dataInstrument[$i]['biaya'] = $row[2];
					$i++;
				}
			}else{ 
				$dataInstrument = null;
			}
			unset($i);
			$this->dbClose();
			return $dataInstrument;        	
		}
		
		public function cekInstrument($nama){
			$this->dbOpen();
			$sql = "SELECT COUNT(*) AS cekInstrument FROM instrument WHERE nama_instrument = '$nama'";
			$query = mysqli_query($this->conn, $sql);
			$row =  mysqli_fetch_array($query);
			$rows = $row['cekInstrument'];
			return $rows;
		}
		
		public function saveInstrument($nama, $biaya) {
			$this->dbOpen();
			$nama= mysqli_real_escape_string($this->conn, $nama);
			$biaya= mysqli_real_escape_string($this->conn, $biaya);
			$cek= $this->cekInstrument($nama);
			
			if($cek!=0){
				$_SESSION['notif']="duplicate";
				header('Location: ../?p=instrument&sub=tambah');
			}
			else{
				$sql="INSERT INTO instrument(id_instrument, nama_instrument, biaya_instrument)"
					. "VALUES ('', '$nama', '$biaya')";
				$query=mysqli_query($this->conn, $sql);
				if ($query==true){
					$_SESSION['notif']="successSave";
				}
				else {
					$_SESSION['notif']="failSave";
				}
				$this->dbClose();
				header('Location: ../?p=instrument&sub=tambah');
			}
		}
		
		public function editInstrument($id, $nama, $biaya) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$nama= mysqli_real_escape_string($this->conn, $nama);
			$biaya= mysqli_real_escape_string($this->conn, $biaya);
			
			$sql = "UPDATE instrument SET nama_instrument='$nama', biaya_instrument='$biaya' WHERE md5(id_instrument)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="editSukses";
				$_SESSION['namanya']=$nama;
			}
			else {
				$_SESSION['notif']="editGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=instrument');
		}
		
		public function deleteInstrument($id, $nama) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$nama= mysqli_real_escape_string($this->conn, $nama);
					
			$sql = "DELETE FROM instrument WHERE md5(id_instrument)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="deleteSukses";
				$_SESSION['namanya']=$jenis;
			}
			else {
				$_SESSION['notif']="deleteGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=instrument');
		}
		
		public function getBiaya($id) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
					
			$sql = "SELECT biaya_instrument FROM instrument WHERE id_instrument = '$id'";
			$query = mysqli_query($this->conn, $sql);
			$row=  mysqli_fetch_array($query);
			$this->dbClose();
			
			return $row['biaya_instrument'];
		}
	}
?>