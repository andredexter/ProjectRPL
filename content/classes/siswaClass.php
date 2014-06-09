<?php
	require_once('pembayaranClass.php');
	
	class siswa extends dbController{
		public function getSiswa($start) {
			$this->dbOpen();
			$start= mysqli_real_escape_string($this->conn, $start);
			
			if($start == "*"){
				$kondisi = "";
			}	
			else {
				$kondisi = "LIMIT $start, 10";
			}
			
			$sql = "SELECT id_siswa, nama_siswa, tempat_lahir, tanggal_lahir, alamat, telepon, tanggal_masuk, uang_masuk, p.id_tingkat, q.class, q.nama_tingkat, p.id_instrument, nama_instrument, biaya_instrument FROM siswa p LEFT JOIN instrument pk ON p.id_instrument = pk.id_instrument LEFT JOIN tingkat q ON p.id_tingkat = q.id_tingkat ORDER BY p.id_tingkat ASC $kondisi";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataSiswa[$i]['id'] = $row[0];
					$dataSiswa[$i]['nama'] = $row[1];
					$dataSiswa[$i]['tempatlahir'] = $row[2];
					$dataSiswa[$i]['tanggallahir'] = $row[3];
					$dataSiswa[$i]['alamat'] = $row[4];
					$dataSiswa[$i]['telepon'] = $row[5];				
					$dataSiswa[$i]['tanggalmasuk'] = $row[6];				
					$dataSiswa[$i]['uangmasuk'] = $row[7];				
					$dataSiswa[$i]['id_tingkat'] = $row[8];				
					$dataSiswa[$i]['class'] = $row[9];				
					$dataSiswa[$i]['tingkat'] = $row[10];
					$dataSiswa[$i]['id_instrument'] = $row[11];
					$dataSiswa[$i]['nama_instrument'] = $row[12];				
					$dataSiswa[$i]['biaya_instrument'] = $row[13];				
					$i++;
				}
			}else{ 
				$dataSiswa = null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataSiswa;        
		}
		
		public function cekSiswa($nama, $tempat, $tanggal){
			$this->dbOpen();
			$sql = "SELECT COUNT(*) AS cekSiswa FROM siswa WHERE nama_siswa = '$nama' AND tempat_lahir = '$tempat' AND tanggal_lahir = '$tanggal'";
			$query = mysqli_query($this->conn, $sql);
			$row =  mysqli_fetch_array($query);
			return $row[0];
		}
		
		public function saveSiswa($nama, $tempat, $tanggal, $alamat, $telp, $daftar, $biaya, $uangbulanan, $instrument) {
			$this->dbOpen();
			$nama = mysqli_real_escape_string($this->conn, $nama);
			$tempat= mysqli_real_escape_string($this->conn, $tempat);
			$tanggal = mysqli_real_escape_string($this->conn, $tanggal);
			$alamat= mysqli_real_escape_string($this->conn, $alamat);
			$telp= mysqli_real_escape_string($this->conn, $telp);
			$daftar= mysqli_real_escape_string($this->conn, $daftar);
			$biaya= mysqli_real_escape_string($this->conn, $biaya);
			$biaya= mysqli_real_escape_string($this->conn, $biaya);
			$uangbulanan= mysqli_real_escape_string($this->conn, $uangbulanan);
			$instrument= mysqli_real_escape_string($this->conn, $instrument);
			
			$baris = $this->cekSiswa($nama, $tempat, $tanggal);
			
			if($baris!=0){
				$_SESSION['notif']="duplicate";
				$_SESSION['nama']= $nama;
				$_SESSION['tempat']= $tempat;
				$_SESSION['tanggal']= $tanggal;
				$_SESSION['alamat']= $alamat;
				$_SESSION['telp']= $telp;
				$_SESSION['daftar']= $daftar;
				$_SESSION['biaya']= $biaya;
				$_SESSION['instrument']= $instrument;
				header('Location: ../?p=siswa&sub=tambah');
			}
			else{
				$sql="INSERT INTO siswa(id_siswa, nama_siswa, tempat_lahir, tanggal_lahir, alamat, telepon, tanggal_masuk, uang_masuk, id_tingkat, id_instrument)"
					. "VALUES ('', '$nama', '$tempat', '$tanggal', '$alamat', '$telp', '$daftar', '$biaya', '1', '$instrument')";
				$query=mysqli_query($this->conn, $sql);
				if ($query==true){
					$_SESSION['notif']="success";
					
					$bln = explode('-',$daftar);
					$bulan = $bln[0]."-".$bln[1]."-01";
					
					$this->savePembayaranSiswa($nama, $tempat, $tanggal, $telp, $bulan, $uangbulanan);
				}
				else {
					$_SESSION['notif']="fail";
				}
				$this->dbClose();
				header('Location: ../?p=siswa&sub=tambah');
			}
		}
		
		public function editSiswa($id, $nama, $tempat, $tanggal, $alamat, $telepon, $instrument, $tingkat) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$nama = mysqli_real_escape_string($this->conn, $nama);
			$tempat = mysqli_real_escape_string($this->conn, $tempat);
			$tanggal = mysqli_real_escape_string($this->conn, $tanggal);
			$alamat = mysqli_real_escape_string($this->conn, $alamat);
			$telepon = mysqli_real_escape_string($this->conn, $telepon);
			$instrument= mysqli_real_escape_string($this->conn, $instrument);
			$tingakt = mysqli_real_escape_string($this->conn, $tingakt);
			
			$sql = "UPDATE siswa SET nama_siswa='$nama', tempat_lahir='$tempat', tanggal_lahir='$tanggal', alamat='$alamat', telepon='$telepon', id_instrument='$instrument', id_tingkat='$tingkat' WHERE md5(id_siswa)='$id'";

			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="editSukses";
				$_SESSION['namanya']=$nama;
			}
			else {
				$_SESSION['notif']="editGagal";
				$_SESSION['namanya']=$nama;
		   }
		   $this->dbClose();
		   header('Location: ../?p=siswa&sub=lihat');
		}
		
		public function deleteSiswa($id, $nama) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$nama = mysqli_real_escape_string($this->conn, $nama);
					
			$sql = "DELETE FROM siswa WHERE md5(id_siswa)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="deleteSukses";
				$_SESSION['namanya']=$nama;
			}
			else {
				$_SESSION['notif']="deleteGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=siswa&sub=lihat');
		}
		
		public function savePembayaranSiswa($nama, $tempat, $tanggal, $telepon, $bulan, $uangbulanan){
			$this->dbOpen();
			$sql = "SELECT id_siswa FROM siswa WHERE nama_siswa= '$nama' AND tempat_lahir = '$tempat' AND tanggal_lahir = '$tanggal' AND telepon = '$telepon'";
			
			$query = mysqli_query($this->conn, $sql);
			$row =  mysqli_fetch_array($query);

			$id_siswa =  $row[0];
			
			$sql="INSERT INTO pembayaran(id_pembayaran, bulan, id_siswa, jumlah)"
			   . "VALUES ('', '$bulan', '$id_siswa', '$uangbulanan')";
			$query=mysqli_query($this->conn, $sql);
			$this->dbClose();
		}
		
		public function pickSiswa($id){
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$sql = "SELECT a.id_siswa, a.nama_siswa, a.tempat_lahir, a.tanggal_lahir, a.alamat, a.telepon, a.tanggal_masuk, a.uang_masuk, a.id_instrument, b.nama_instrument, b.biaya_instrument FROM siswa a LEFT JOIN instrument b ON a.id_instrument = b.id_instrument WHERE md5(a.id_siswa) = '$id'";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataSiswa[$i]['id_siswa'] = $row[0];
					$dataSiswa[$i]['nama_siswa'] = $row[1];
					$dataSiswa[$i]['tempat_lahir'] = $row[2];
					$dataSiswa[$i]['tanggal_lahir'] = $row[3];
					$dataSiswa[$i]['alamat'] = $row[4];
					$dataSiswa[$i]['telepon'] = $row[5];
					$dataSiswa[$i]['tanggal_masuk'] = $row[6];
					$dataSiswa[$i]['uang_masuk'] = $row[7];
					$dataSiswa[$i]['id_instrument'] = $row[8];
					$dataSiswa[$i]['nama_instrument'] = $row[9];
					$dataSiswa[$i]['biaya_instrument'] = $row[10];
					$i++;
				}
			}else{ 
				$dataSiswa = null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataSiswa;    
		}
		
		public function countSiswa(){
			$this->dbOpen();
			
			$sql = "SELECT count(id_siswa) as semua, (SELECT count(id_siswa) FROM siswa WHERE id_tingkat != 5) as aktif,(SELECT count(id_siswa) FROM siswa WHERE id_tingkat = 5) as tamat FROM siswa";
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			$i=0;
			$row = mysqli_fetch_array($query);
			$datasiswa[$i]['semua'] = $row[0];
			$datasiswa[$i]['aktif'] = $row[1];
			$datasiswa[$i]['tamat'] = $row[2];
				
			$this->dbClose();
			return $datasiswa;
		}
		
		public function cekBayar($bulan, $id){
			$this->dbOpen();
			$bulan = mysqli_real_escape_string($this->conn, $bulan);
			$id= mysqli_real_escape_string($this->conn, $id);
			$sql = "SELECT a.jumlah FROM pembayaran a, siswa b WHERE a.id_siswa = b.id_siswa AND a.bulan LIKE '$bulan%' AND a.id_siswa = '$id'";
			$query = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_array($query);
			
			$this->dbClose();
			return $row[0];
		}
	}
?>