<?php
	class fungsi extends dbController{
		public function getMonth($tgl){
			$tgl = explode('-', $tgl);
			return $tgl[0]."-".$tgl[1];
		}
		
		public function generateJam($jam) {
			return $jam.":00.000000";
		}
		
		public function regenerateJam($jam) {
			$time=explode(":",$jam);
			return $time[0].":".$time[1];
		}
		
		function formatindo($angka){
			$uang = number_format( $angka, 0 , '' , '.' );
			return $uang;
		}

		public function selectHari($id){
			 $day = array("Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
			 return $day[$id-1];
		}
		
		function listJam(){
			$list='';
			for($i=0;$i<=24;$i++){
				$list.= "<option value='".$i."'>".$this->pad($i)."</option>";
			}
			return $list;
		}
		function listMenit(){
			$list='';
			for($i=0;$i<=60;$i++){
				$list.= "<option value='".$i."'>".$this->pad($i)."</option>";
			}
			return $list;
		}
		
		function pad($x) {
			if($x < 10)	{
				return '0'.$x;
			}
			else {
				return $x;
			}
		}
		public function tglindo($tgl) {
			$monthExplode = explode("-", $tgl);
			$namaBulan = array( "01" => "Januari",
								"02" => "Februari",
								"03" => "Maret",
								"04" => "April",
								"05" => "Mei",
								"06" => "Juni",
								"07" => "Juli",
								"08" => "Agustus",
								"09" => "September",
								"10" => "Oktober",
								"11" => "November",
								"12" => "Desember",
							  );
			$hari=$monthExplode[2];
			$bln=$namaBulan[$monthExplode[1]];
			$thn = $monthExplode[0];
			return $hari." ".$bln." ".$thn;
		}
				
		public function getMonthName($bln){
			$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
					
			$tgl = explode('-', $bln);
			
			return $nama_bln[intval($tgl[1])]." ".$tgl[0];
		}
		
		public function casttanggal($tgl){
			$tgl = explode('-', $tgl);
			$tgl[2] = (isset($tgl[2])) ? $tgl[2] : "01";
			return $tgl[0].$tgl[1].$tgl[2];
		}
		public function tanggallahir($tgl){
			$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
			$tgl = explode('-', $tgl);
			return $tgl[2]." ".$nama_bln[intval($tgl[1])]." ".$tgl[0];
		}
		
		public function delComma($nStr){
			return str_replace('.','',$nStr);
		}
		
		public function validasiText($str){
		
		}
	}
?>