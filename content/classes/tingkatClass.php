<?php
	class tingkat extends dbController{
		public function getTingkat() {
			$this->dbOpen();
			$sql = "SELECT id_tingkat, class, nama_tingkat FROM tingkat ORDER BY id_tingkat ASC";			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$num_results = mysqli_num_rows($query); 
			
			if ($num_results > 0){ 
				$i=0;
				while ($row = mysqli_fetch_array($query)){
					$dataTingkat[$i]['id_tingkat'] = $row[0];
					$dataTingkat[$i]['class'] = $row[1];
					$dataTingkat[$i]['nama_tingkat'] = $row[2];
					$i++;
				}
			}else{ 
				$dataTingkat = null;
			}
			unset($i);
			$this->dbClose();
			return $dataTingkat;        	
		}
	}
?>