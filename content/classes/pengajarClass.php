<?php
	class pengajar extends dbController{
		public function getPengajar($start){
			$this->dbOpen();
			$start= mysqli_real_escape_string($this->conn, $start);
			
			if($start == "*"){
				$kondisi = "";
			}	
			else {
				$kondisi = "LIMIT $start, 10";
			}
			
			$sql = "SELECT id_pengajar, nama_pengajar, tempat_lahir, tanggal_lahir, pendidikan, alamat, telepon FROM pengajar ORDER BY nama_pengajar ASC $kondisi";
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataPengajar[$i]['id'] = $row[0];
					$dataPengajar[$i]['nama'] = $row[1];
					$dataPengajar[$i]['tempat'] = $row[2];
					$dataPengajar[$i]['tanggal'] = $row[3];
					$dataPengajar[$i]['pendidikan'] = $row[4];
					$dataPengajar[$i]['alamat'] = $row[5];
					$dataPengajar[$i]['telepon'] = $row[6];				
					$i++;
				}
			}else{ 
				$dataPengajar = null;
			}
			
			unset($i);
			$this->dbClose();
			return $dataPengajar;        
		}
		
		public function cekPengajar($nama, $tempat, $tanggal){
			$this->dbOpen();
			$sql = "SELECT COUNT(*) AS cekPengajar FROM pengajar WHERE nama_pengajar = '$nama' AND tempat_lahir = '$tempat' AND tanggal_lahir = '$tanggal'";
			$query = mysqli_query($this->conn, $sql);
			$row =  mysqli_fetch_array($query);
			$rows = $row['cekPengajar'];
			return $rows;
		}
		
		public function savePengajar($nama, $tempat, $tanggal, $pendidikan, $alamat, $telp) {
			$this->dbOpen();
			$nama = mysqli_real_escape_string($this->conn, $nama);
			$tempat= mysqli_real_escape_string($this->conn, $tempat);
			$tanggal = mysqli_real_escape_string($this->conn, $tanggal);
			$pendidikan= mysqli_real_escape_string($this->conn, $pendidikan);			
			$alamat= mysqli_real_escape_string($this->conn, $alamat);
			$telp= mysqli_real_escape_string($this->conn, $telp);
			
			$baris = $this->cekPengajar($nama, $tempat, $tanggal);
			
			if($baris!=0){
				$_SESSION['notif']="duplicate";
				$_SESSION['nama']= $nama;
				$_SESSION['tempat']= $tempat;
				$_SESSION['tanggal']= $tanggal;
				$_SESSION['pendidikan']= $pendidikan;
				$_SESSION['telp']= $telp;
				$_SESSION['alamat']= $alamat;
				header('Location: ../?p=pengajar&sub=tambah');
			}
			else{
				$sql="INSERT INTO pengajar(id_pengajar, nama_pengajar, tempat_lahir, tanggal_lahir, pendidikan, alamat, telepon)"
					. "VALUES ('', '$nama', '$tempat', '$tanggal', '$pendidikan', '$alamat', '$telp')";
				$query=mysqli_query($this->conn, $sql);
				if ($query==true){
					$_SESSION['notif']="success";
				}
				else {
					$_SESSION['notif']="fail";
				}
				$this->dbClose();
				header('Location: ../?p=pengajar&sub=tambah');
			}
		}
		
		public function editPengajar($id, $nama, $tempat, $tanggal, $pendidikan, $alamat, $telepon) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$nama = mysqli_real_escape_string($this->conn, $nama);
			$tempat = mysqli_real_escape_string($this->conn, $tempat);
			$tanggal = mysqli_real_escape_string($this->conn, $tanggal);
			$pendidikan = mysqli_real_escape_string($this->conn, $pendidikan);
			$alamat = mysqli_real_escape_string($this->conn, $alamat);
			$telepon = mysqli_real_escape_string($this->conn, $telepon);
			
			$sql = "UPDATE pengajar SET nama_pengajar='$nama', tempat_lahir='$tempat', tanggal_lahir='$tanggal', pendidikan='$pendidikan', alamat='$alamat', telepon='$telepon' WHERE md5(id_pengajar)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="editSukses";
				$_SESSION['namanya']=$nama;
			}
			else {
				$_SESSION['notif']="editGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=pengajar&sub=lihat');
		}
		public function deletePengajar($id, $nama) {
			$this->dbOpen();
			$id = mysqli_real_escape_string($this->conn, $id);
			$nama = mysqli_real_escape_string($this->conn, $nama);
					
			$sql = "DELETE FROM pengajar WHERE md5(id_pengajar)='$id'";
			$query = mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="deleteSukses";
				$_SESSION['namanya']=$nama;
			}
			else {
				$_SESSION['notif']="deleteGagal";
		   }
		   $this->dbClose();
		   header('Location: ../?p=pengajar&sub=lihat');
		}
		
		public function takeName($id){
			$this->dbOpen();
			$id= mysqli_real_escape_string($this->conn, $id);
			
			$sql = "SELECT nama_pengajar FROM pengajar WHERE md5(id_pengajar) = '$id'";
			
			$query = mysqli_query($this->conn, $sql);
			$row =  mysqli_fetch_array($query);
			$rows = $row[0];
			$this->dbClose();
			return $rows;
		}
	}
?>