<?php
	class jadwal extends dbController{
		public function selectJadwal() {
			$this->dbOpen();
			$sql = "SELECT id_jadwal, p.id_shift, q.id_hari, nama_hari, jam_mulai, jam_akhir, p.id_pengajar, nama_pengajar, p.id_siswa, nama_siswa, nama_instrument FROM jadwal p LEFT JOIN shift q ON p.id_shift = q.id_shift LEFT JOIN hari t ON q.id_hari = t.id_hari LEFT JOIN pengajar r ON p.id_pengajar = r.id_pengajar LEFT JOIN siswa s ON p.id_siswa = s.id_siswa LEFT JOIN instrument y ON s.id_instrument = y.id_instrument ORDER BY jam_mulai";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataJadwal[$i]['id_jadwal'] = $row[0];
					$dataJadwal[$i]['id_shift'] = $row[1];
					$dataJadwal[$i]['id_hari'] = $row[2];
					$dataJadwal[$i]['nama_hari'] = $row[3];
					$dataJadwal[$i]['jam_mulai'] = $row[4];
					$dataJadwal[$i]['jam_akhir'] = $row[5];
					$dataJadwal[$i]['id_pengajar'] = $row[6];
					$dataJadwal[$i]['nama_pengajar'] = $row[7];
					$dataJadwal[$i]['id_siswa'] = $row[8];
					$dataJadwal[$i]['nama_siswa'] = $row[9];
					$dataJadwal[$i]['nama_instrument'] = $row[10];
					$i++;
				}
			}else{ 
				$dataJadwal= null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataJadwal;        		
		}
		
		
		public function cekJadwal($id, $awal, $akhir){
			$this->dbOpen();
			$sql = "SELECT COUNT(*) AS cekJadwal FROM jadwal WHERE id_hari = '$id' AND jam_mulai = '$awal' AND jam_akhir = '$akhir'";
			$query = mysqli_query($this->conn, $sql);
			$row =  mysqli_fetch_array($query);
			$rows = $row['cekJadwal'];
			return $rows;
		}
		
		public function generateJam($jam) {
			return $jam.":00.000000";
		}
		public function regenerateJam($jam) {
			$time=explode(":",$jam);
			$time = $time[0].":".$time[1];
			return $time;
		}
		
		public function saveJadwal($siswa, $pengajar, $shift) {
			$this->dbOpen();
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			$pengajar= mysqli_real_escape_string($this->conn, $pengajar);
			$shift= mysqli_real_escape_string($this->conn, $shift);
						
			$sql="INSERT INTO jadwal(id_jadwal, id_shift, id_pengajar, id_siswa)"
			   . "VALUES ('', '$shift', '$pengajar', '$siswa')";
			$query=mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="successJadwal";
			}
			$this->dbClose();
			header('Location: ../?p=jadwal');			
		}
		
		public function deleteJadwal($id) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
					
			$sql = "DELETE FROM jadwal WHERE md5(id_jadwal)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="deleteSukses";
			}
			else {
				$_SESSION['notif']="deleteGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=jadwal');
		}
		function showJam($time){
			$time=explode(":",$time);
			$time = $time[0].":".$time[1];
			return $time;
		}
		
		function getShift($id){
			$this->dbOpen();
			$sql = "SELECT * FROM shift WHERE id_hari = '$id' ORDER BY jam_mulai";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataShift[$i]['id_shift'] = $row[0];
					$dataShift[$i]['jam_mulai'] = $row[2];
					$dataShift[$i]['jam_akhir'] = $row[3];
					$i++;
				}
			}else{ 
				$dataShift = null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataShift; 
		}
		
		function getSiswa(){
			$this->dbOpen();
			$sql = "SELECT l.id_siswa, l.nama_siswa, l.id_instrument, m.nama_instrument FROM siswa l, instrument m WHERE l.id_instrument = m.id_instrument AND l.id_tingkat != 5 AND l.id_siswa NOT IN ( SELECT id_siswa FROM jadwal r )";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataSiswa[$i]['id_siswa'] = $row[0];
					$dataSiswa[$i]['nama_siswa'] = $row[1];
					$dataSiswa[$i]['id_instrument'] = $row[2];
					$dataSiswa[$i]['nama_instrument'] = $row[3];
					$i++;
				}
			}else{ 
				$dataSiswa= null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataSiswa; 
		}
		
		function getPengajar(){
			$this->dbOpen();
			$sql = "SELECT l.id_pengajar, l.nama_pengajar FROM pengajar l ORDER BY l.nama_pengajar ASC";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataPengajar[$i]['id_pengajar'] = $row[0];
					$dataPengajar[$i]['nama_pengajar'] = $row[1];
					$i++;
				}
			}else{ 
				$dataPengajar= null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataPengajar; 
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
			$sql = "SELECT count(id_hari) AS 'total' FROM shift	 GROUP BY (id_hari) ORDER BY (total) DESC LIMIT 1";
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