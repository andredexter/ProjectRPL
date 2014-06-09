<?php
	class pembayaran extends dbController{
		public function getSiswa() {
			$this->dbOpen();
		
			$sql = "SELECT q.id_siswa, q.nama_siswa, p.nama_instrument FROM siswa q LEFT JOIN instrument p ON q.id_instrument = p.id_instrument LEFT JOIN jadwal r ON r.id_siswa = q.id_siswa WHERE r.id_siswa = q.id_siswa AND id_tingkat != 5 ORDER BY nama_siswa ASC";			
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataSiswa[$i]['id_siswa'] = $row[0];
					$dataSiswa[$i]['nama_siswa'] = $row[1];
					$dataSiswa[$i]['nama_instrument'] = $row[2];
					$i++;
				}
			}else{ 
				$dataSiswa = null;
			}
			unset($i);
			$this->dbClose();
			return $dataSiswa;        	
		}
		
		public function cekPembayaran($bln, $siswa) {
			$this->dbOpen();
			$bln = mysqli_real_escape_string($this->conn, $bln);
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			
			$sql = "SELECT a.id_pembayaran, a.bulan, a.jumlah, a.id_siswa, b.nama_siswa, c.nama_instrument, c.biaya_instrument FROM pembayaran a LEFT JOIN siswa b ON a.id_siswa = b.id_siswa LEFT JOIN instrument c ON b.id_instrument = c.id_instrument WHERE a.bulan LIKE '$bln%' AND a.id_siswa = '$siswa'";	
			$_SESSION['sql'] = $sql;
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataBayar[$i]['id_pembayaran'] = $row[0];
					$dataBayar[$i]['bulan'] = $row[1];
					$dataBayar[$i]['jumlah'] = $row[2];
					$dataBayar[$i]['id_siswa'] = $row[3];
					$dataBayar[$i]['nama_siswa'] = $row[4];
					$dataBayar[$i]['nama_instrument'] = $row[5];
					$dataBayar[$i]['biaya_instrument'] = $row[6];
					$i++;
				}
			}else{ 
				$dataBayar = null;
			}
			unset($i);
			$this->dbClose();
			return $dataBayar;        	
		}
		
		public function getPembayaran($siswa) {
			$this->dbOpen();
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			
			$sql = "SELECT b.id_siswa, b.nama_siswa, c.nama_instrument, c.biaya_instrument FROM siswa b LEFT JOIN instrument c ON b.id_instrument = c.id_instrument WHERE b.id_siswa = '$siswa'";	
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataSiswa[$i]['id_siswa'] = $row[0];
					$dataSiswa[$i]['nama_siswa'] = $row[1];
					$dataSiswa[$i]['nama_instrument'] = $row[2];
					$dataSiswa[$i]['biaya_instrument'] = $row[3];
					$i++;
				}
			}else{ 
				$dataSiswa = null;
			}
			unset($i);
			$this->dbClose();
			return $dataSiswa;        	
		}
		
		public function savePembayaran($bln, $idsiswa, $jumlah) {
			$this->dbOpen();
			
			$bln= mysqli_real_escape_string($this->conn, $bln);
			$idsiswa= mysqli_real_escape_string($this->conn, $idsiswa);
			$jumlah= mysqli_real_escape_string($this->conn, $jumlah);
			$jumlah = str_replace('.','',$jumlah);
			
			$sql="INSERT INTO pembayaran(id_pembayaran, bulan, id_siswa, jumlah)"
			   . "VALUES ('', '$bln', '$idsiswa', '$jumlah')";
			$query=mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="success";
			}
			$this->dbClose();
			header('Location: ../?p=pembayaran');
		}
		
		public function editPembayaran($id, $jumlah) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$jumlah= mysqli_real_escape_string($this->conn, $jumlah);
			$jumlah = str_replace('.','',$jumlah);
			
			$sql = "UPDATE pembayaran SET jumlah='$jumlah' WHERE md5(id_pembayaran)='$id'";

			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="editSukses";
			}
			else {
				$_SESSION['notif']="editGagal";				
		   }
		   $this->dbClose();
		   header('Location: ../?p=pembayaran');
		}
		
		public function getName($siswa){
			$this->dbOpen();		
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			
			$sql = "SELECT nama_siswa FROM siswa WHERE id_siswa = $siswa";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$row =  mysqli_fetch_array($query);			
			
			return $row[0];
		}
	}
?>