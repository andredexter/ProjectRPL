<?php
	class absensi extends dbController{
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
		
		public function cekAbsensi($bln, $siswa) {
			$this->dbOpen();
			$bln = mysqli_real_escape_string($this->conn, $bln);
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			
			$sql = "SELECT a.id_absen, a.bulan, a.id_pengajar, b.nama_pengajar, a.hadir_pengajar, a.id_siswa, c.nama_siswa, a.hadir_siswa, f.nama_hari, e.jam_mulai, e.jam_akhir, a.jumlah_absen FROM absen a LEFT JOIN pengajar b ON a.id_pengajar = b.id_pengajar LEFT JOIN siswa c ON a.id_siswa = c.id_siswa LEFT JOIN jadwal d ON a.id_siswa = d.id_siswa LEFT JOIN shift e ON d.id_shift = e.id_shift LEFT JOIN hari f ON e.id_hari = f.id_hari WHERE a.bulan LIKE '$bln%' AND a.id_siswa = '$siswa'  AND d.id_pengajar = a.id_pengajar";	
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataAbsen[$i]['id_absen'] = $row[0];
					$dataAbsen[$i]['bulan'] = $row[1];
					$dataAbsen[$i]['id_pengajar'] = $row[2];
					$dataAbsen[$i]['nama_pengajar'] = $row[3];
					$dataAbsen[$i]['hadir_pengajar'] = $row[4];
					$dataAbsen[$i]['id_siswa'] = $row[5];
					$dataAbsen[$i]['nama_siswa'] = $row[6];
					$dataAbsen[$i]['hadir_siswa'] = $row[7];
					$dataAbsen[$i]['nama_hari'] = $row[8];
					$dataAbsen[$i]['jam_mulai'] = $row[9];
					$dataAbsen[$i]['jam_akhir'] = $row[10];
					$dataAbsen[$i]['jumlah'] = $row[11];
					$i++;
				}
			}else{ 
				$dataAbsen = null;
			}
			unset($i);
			$this->dbClose();
			return $dataAbsen;        	
		}
		
		public function cekJadwal($siswa) {
			$this->dbOpen();
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			
			$sql = "SELECT a.id_pengajar, b.nama_pengajar, a.id_siswa, c.nama_siswa, d.nama_hari, e.jam_mulai, e.jam_akhir FROM jadwal a LEFT JOIN pengajar b ON a.id_pengajar = b.id_pengajar LEFT JOIN siswa c ON a.id_siswa = c.id_siswa LEFT JOIN shift e ON a.id_shift = e.id_shift LEFT JOIN hari d ON e.id_hari = d.id_hari WHERE a.id_siswa = '$siswa'";	
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataJadwal[$i]['id_pengajar'] = $row[0];
					$dataJadwal[$i]['nama_pengajar'] = $row[1];
					$dataJadwal[$i]['id_siswa'] = $row[2];
					$dataJadwal[$i]['nama_siswa'] = $row[3];
					$dataJadwal[$i]['nama_hari'] = $row[4];
					$dataJadwal[$i]['jam_mulai'] = $row[5];
					$dataJadwal[$i]['jam_akhir'] = $row[6];
					$i++;
				}
			}else{ 
				$dataJadwal = null;
			}
			unset($i);
			$this->dbClose();
			return $dataJadwal;        	
		}
		
		public function saveAbsen($bln, $jumlah, $idsiswa, $idpengajar, $hadirsiswa, $hadirpengajar) {
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);
			$jumlah= mysqli_real_escape_string($this->conn, $jumlah);
			$idsiswa= mysqli_real_escape_string($this->conn, $idsiswa);
			$idpengajar= mysqli_real_escape_string($this->conn, $idpengajar);
			$hadirsiswa= mysqli_real_escape_string($this->conn, $hadirsiswa);
			$hadirpengajar= mysqli_real_escape_string($this->conn, $hadirpengajar);
						
			$sql="INSERT INTO absen(id_absen, bulan, jumlah_absen, id_pengajar, hadir_pengajar, id_siswa, hadir_siswa)"
			   . "VALUES ('', '$bln', '$jumlah', '$idpengajar', '$hadirpengajar', '$idsiswa', '$hadirsiswa')";
			
			$query=mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="success";
				$bagiGaji = new pembagian();
				$bagiGaji->bagiGaji($bln, $idsiswa, 0);
			}
			$this->dbClose();
			header('Location: ../?p=absensi');			
		}
		
		public function editAbsen($id, $hadirsiswa, $hadirpengajar) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$hadirsiswa = mysqli_real_escape_string($this->conn, $hadirsiswa);
			$hadirpengajar = mysqli_real_escape_string($this->conn, $hadirpengajar);
			
			$sql = "UPDATE absen SET hadir_pengajar='$hadirpengajar', hadir_siswa='$hadirsiswa' WHERE md5(id_absen)='$id'";

			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="editSukses";
				$bagiGaji = new pembagian();
				$bagiGaji->bagiGaji($id,0,1);
			}
			else {
				$_SESSION['notif']="editGagal";				
		   }
		   $this->dbClose();
		   header('Location: ../?p=absensi');
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
	
	class pembagian extends dbController{
		private function getIdAbsen($bln, $siswa){		
			$this->dbOpen();
			
			$sql = "SELECT a.id_absen FROM absen a LEFT JOIN pengajar b ON a.id_pengajar = b.id_pengajar LEFT JOIN siswa c ON a.id_siswa = c.id_siswa LEFT JOIN jadwal d ON a.id_siswa = d.id_siswa LEFT JOIN shift e ON d.id_shift = e.id_shift LEFT JOIN hari f ON e.id_hari = f.id_hari WHERE a.bulan LIKE '$bln%' AND a.id_siswa = '$siswa'";	
			$_SESSION['sqla'] = $sql;
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			$row = mysqli_fetch_array($query);
			$data = $row[0];
			
			return $data;        
		}
		
		public function bagiGaji($bln, $siswa, $status){
			$this->dbOpen();
			$bln = mysqli_real_escape_string($this->conn, $bln);
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			
			if($status == 0){
				$id_absen = md5($this->getIdAbsen($bln, $siswa));
			}
			else if($status == 1){
				$id_absen = $bln;
			}

			$sqla = "INSERT DELAYED INTO pembagian(id_bagi, id_absen, jumlah_pengajar, jumlah_management) SELECT e.id_bagi, a.id_absen, cast((a.hadir_pengajar/a.jumlah_absen)*(45/100)*d.biaya_instrument as unsigned) as pengajar,cast(d.biaya_instrument - ((a.hadir_pengajar/a.jumlah_absen)*(45/100)*d.biaya_instrument) as unsigned) as manajemen FROM absen a LEFT JOIN pengajar b ON a.id_pengajar = b.id_pengajar LEFT JOIN siswa c ON a.id_siswa = c.id_siswa LEFT JOIN instrument d ON c.id_instrument = d.id_instrument LEFT JOIN pembagian e ON a.id_absen = e.id_absen WHERE md5(a.id_absen) = '$id_absen' ORDER BY a.id_absen ON DUPLICATE KEY UPDATE `id_absen`= a.id_absen, `jumlah_pengajar` = cast((a.hadir_pengajar/a.jumlah_absen)*(45/100)*d.biaya_instrument as unsigned), `jumlah_management` = cast(d.biaya_instrument - ((a.hadir_pengajar/a.jumlah_absen)*(45/100)*d.biaya_instrument) as unsigned)";
						
			$query = mysqli_query($this->conn, $sqla) or die(mysqli_error($this->conn)); 
			
			$this->dbClose();
		}
	}
?>