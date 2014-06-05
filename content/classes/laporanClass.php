<?php
	class laporangaji extends dbController{
		public function getPenggajian($bln) {
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);
			
			$sql = "SELECT a.bulan, a.id_pengajar, b.nama_pengajar, (select count(e.id_pengajar) from absen e where e.bulan Like '$bln%' AND e.id_pengajar = a.id_pengajar) as mengajar FROM absen a RIGHT JOIN pengajar b ON a.id_pengajar = b.id_pengajar AND a.bulan LIKE '$bln%' GROUP BY b.id_pengajar";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataGaji[$i]['bln'] = $row[0];
					$dataGaji[$i]['id_pengajar'] = $row[1];
					$dataGaji[$i]['nama_pengajar'] = $row[2];
					$dataGaji[$i]['jumlah_mengajar'] = $row[3];
					$i++;
				}
			}else{ 
				$dataGaji = null;
			}
			unset($i);
			$this->dbClose();
			return $dataGaji;        	
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

		public function getName($siswa){
			$this->dbOpen();		
			$siswa= mysqli_real_escape_string($this->conn, $siswa);
			
			$sql = "SELECT nama_siswa FROM siswa WHERE id_siswa = $siswa";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			
			$row =  mysqli_fetch_array($query);			
			
			return $row['nama_siswa'];
		}
		
		public function getMonthName($bln){
			$day = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
			$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
					
			$tgl = explode('-', $bln);
			
			return $nama_bln[intval($tgl[1])]." ".$tgl[0];
		}
		
		public function getGaji($bln, $id) {
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);
			$id= mysqli_real_escape_string($this->conn, $id);
			
			$sql = "SELECT b.nama_pengajar, c.jumlah_pengajar, a.hadir_pengajar, cast((45/100)/a.jumlah_absen*e.biaya_instrument as unsigned) as biaya, d.nama_siswa, e.nama_instrument FROM absen a LEFT JOIN pembagian c ON a.id_absen = c.id_absen LEFT JOIN pengajar b ON a.id_pengajar = b.id_pengajar LEFT JOIN siswa d ON a.id_siswa = d.id_siswa LEFT JOIN instrument e ON d.id_instrument = e.id_instrument WHERE md5(a.id_pengajar) = '$id' AND a.bulan LIKE '$bln%'";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataGaji[$i]['nama_pengajar'] = $row[0];
					$dataGaji[$i]['jumlah_pengajar'] = $row[1];
					$dataGaji[$i]['hadir_pengajar'] = $row[2];
					$dataGaji[$i]['biaya'] = $row[3];
					$dataGaji[$i]['nama_siswa'] = $row[4];
					$dataGaji[$i]['nama_instrument'] = $row[5];
					$i++;
				}
			}else{ 
				$dataGaji = null;
			}
			unset($i);
			$this->dbClose();
			return $dataGaji;        	
		}
		
	}
	class neraca extends dbController{
		public function getDaftar($bln){
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);			
			
			$sql = "SELECT COUNT(uang_masuk) AS banyak_masuk, COALESCE(SUM(uang_masuk), 0) AS jumlah_masuk FROM siswa WHERE tanggal_masuk LIKE '$bln%'";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataMasuk[$i]['banyak_masuk'] = $row[0];
					$dataMasuk[$i]['jumlah_masuk'] = $row[1];
					$i++;
				}
			}else{ 
				$dataMasuk = null;
			}
			unset($i);
			$this->dbClose();
			return $dataMasuk;
		}
		public function getBayar($bln){
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);			
			
			$sql = "SELECT COUNT(jumlah) AS banyak_bayar, COALESCE(SUM(jumlah), 0) AS jumlah_bayar FROM pembayaran WHERE bulan LIKE '$bln%'";

			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataBayar[$i]['banyak_bayar'] = $row[0];
					$dataBayar[$i]['jumlah_bayar'] = $row[1];
					$i++;
				}
			}else{ 
				$dataBayar = null;
			}
			unset($i);
			$this->dbClose();
			return $dataBayar;
		}
		public function getGaji($bln){
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);			
			
			$sql = "SELECT COUNT(b.id_pengajar) AS banyak, SUM(a.jumlah_pengajar) as jumlah FROM pembagian a LEFT JOIN absen b ON a.id_absen = b.id_absen WHERE b.bulan LIKE '$bln%'";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataGaji[$i]['banyak_gaji'] = $row[0];
					$dataGaji[$i]['jumlah_gaji'] = $row[1];
					$i++;
				}
			}else{ 
				$dataGaji = null;
			}
			unset($i);
			$this->dbClose();
			return $dataGaji;
		}
		
		private function getDaftarBefore($bln){
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);			
			
			$sql = "SELECT COALESCE(SUM(uang_masuk), 0) AS jumlah_masuk FROM siswa WHERE CAST(tanggal_masuk AS UNSIGNED) < '$bln%'";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$row = mysqli_fetch_array($query);
			
			$this->dbClose();
			return $row[0];
		}
		private function getBayarBefore($bln){
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);			

			$sql = "SELECT COALESCE(SUM(jumlah), 0) AS jumlah_bayar FROM pembayaran WHERE CAST(bulan AS UNSIGNED) < '$bln%'";

			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$row = mysqli_fetch_array($query);			
			
			$this->dbClose();
			return $row[0];
		}
		private function getGajiBefore($bln){
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);			
			
			$sql = "SELECT SUM(a.jumlah_pengajar) as jumlah FROM pembagian a LEFT JOIN absen b ON a.id_absen = b.id_absen WHERE CAST(b.bulan AS UNSIGNED) < '$bln%'";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$row = mysqli_fetch_array($query);
			
			$this->dbClose();
			return $row[0];
		}
		
		public function getSaldoBefore($bln){
			$this->dbOpen();
			$bln= mysqli_real_escape_string($this->conn, $bln);
			
			$a = $this->getDaftarBefore($bln);
			$b = $this->getBayarBefore($bln);
			$c = $this->getGajiBefore($bln);
			
			return $a + $b - $c;
		}
	}
?>