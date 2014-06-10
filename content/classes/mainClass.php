<?php
    class webApp{
        public function createWebApp(){
            if(!isset($_SESSION['usernya'])){
                include ('content/view/login.php');
				header('../');               
            }
            else{
                include ('content/view/layout.php');
            }
        }
		
        public function loadContent() {
            if(!isset($_GET['p'])){
                $page="content/view/page/home.php";
            }
            else if (isset($_GET['p'])) {
				if(isset($_GET['sub'])) {
					$page="content/view/page/".$_GET['p']."-".$_GET['sub'].".php";
				}
				else{
					$page="content/view/page/".$_GET['p'].".php";
				}
            }
            if(file_exists($page)){
                include($page);
            }
            else{
				echo '<script>document.location="404.php"</script>';
            }
        }
    }

    class dbController{
        private $host="localhost";
        private $user="root";
        private $pass="";
        private $dbname="salsainternational";
        protected $conn;
        
        protected function dbOpen(){
            $this->conn = mysqli_connect("$this->host", "$this->user", "$this->pass", "$this->dbname");
            if(mysqli_connect_error()){
                echo "Koneksi ke database MySQL gagal: ".  mysqli_connect_error();
            }      
        }
        
        protected function dbClose(){
            mysqli_close($this->conn);
        }
    }
    
    class userController extends dbController{
        public function userLogin($id, $pass){
            $this->dbOpen();
            $id= mysqli_real_escape_string($this->conn, $id);
            $pass= mysqli_real_escape_string($this->conn, $pass);
            $pass= md5($pass);
			
            $sql="SELECT username, jenis FROM login WHERE username='$id' AND password='$pass'";
            
			$query=mysqli_query($this->conn, $sql);
            
			if(mysqli_num_rows($query)==1){
                while ($row=  mysqli_fetch_array($query)){
					$_SESSION['notif'] = "welcome";
					$_SESSION['nama'] = $row[1];
					$_SESSION['usernya'] = $row[1];
					if($row[1] == 'pemilik'){						
						$_SESSION['prive'] = 0;
					}
					else if($row[1] == 'admin'){
						$_SESSION['prive'] = 1;
					}
                    else{
                        $_SESSION['login']="auth";
                    }                    
                }
                $this->dbClose();
            }
            else{
               $_SESSION['login']='fail';
            }            
        }
		
        public function userLogout() {
            unset($_SESSION['usernya']);            
            unset($_SESSION['prive']);
        }
		
		public function saveUser($username, $passwordold, $passwordnew, $validasi, $prive){
			$this->dbOpen();
			$username= mysqli_real_escape_string($this->conn, $username);
			$passwordold= mysqli_real_escape_string($this->conn, $passwordold);
			$passwordnew= mysqli_real_escape_string($this->conn, $passwordnew);
			$validasi= mysqli_real_escape_string($this->conn, $validasi);
			if($prive == 0){
				$prive = "pemilik";
			}
			else if($prive == 1){
				$prive = "admin";
			}
			
			if($passwordnew == $validasi){
				$passwordnew = md5($passwordnew);
				
				$valid = $this->cekPassword($passwordold, $prive);
				
				if($valid == 1){
					$sql = "INSERT INTO login (username, password,jenis) VALUES('$username', '$passwordnew', '$prive') ON DUPLICATE KEY UPDATE username='$username', password='$passwordnew'";

					$query=mysqli_query($this->conn, $sql);
					if ($query==true){
						$_SESSION['notif']="suksesUpdate";
					}
					else {
						$_SESSION['notif']="gagalUpdate";
				   }
				   $this->dbClose();
				}
				else{
					$_SESSION['notif']="wrongPass";
				}
			}
			else{
				$_SESSION['notif']="notValid";
			}
			
		}
		
		public function pickUser($prive){
			$this->dbOpen();
			$prive= mysqli_real_escape_string($this->conn, $prive);
			if($prive == 0){
				$prive = "pemilik";
			}
			else if($prive == 1){
				$prive = "admin";
			}
			$sql = "SELECT username FROM login WHERE jenis = '$prive'";

			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$row =  mysqli_fetch_array($query);			
			return $row[0];
		}
		private function cekPassword($pass, $jenis){
			$this->dbOpen();		
			
			$sql = "SELECT COUNT(*) FROM login WHERE jenis = '$jenis' AND password = md5('$pass')";			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			$row =  mysqli_fetch_array($query);			
			
			return $row[0];
		}
    }
     
    class settingApps extends dbController{
        public function loadSetting($values){
            $this->dbOpen();
            $load= mysqli_real_escape_string($this->conn, $values);
            
            $sql="SELECT value FROM `setting` where nama_setting = '$load'";
            $query=mysqli_query($this->conn, $sql);
            $row=  mysqli_fetch_array($query);
			$hasil =  $row[0];
            $this->dbClose();
            
			return $hasil;
        }
		
        public function saveInfo($nama, $value){
			$this->dbOpen();
			$nama= mysqli_real_escape_string($this->conn, $nama);
			$value= mysqli_real_escape_string($this->conn, $value);
						
			$sql = "INSERT INTO setting (nama_setting, value) VALUES('$nama', '$value') ON DUPLICATE KEY UPDATE value='$value'";

			$query=mysqli_query($this->conn, $sql);
			if ($query==true){
				$_SESSION['notif']="suksesUpdate";
			}
			else {
				$_SESSION['notif']="gagalUpdate";
		   }
		   $this->dbClose();
		}

    }
    
    class menuController{
        public function dropdownMenu($title, $icon, $position, $array, $privilege) {
            if(isset($_GET['f']) && isset($_GET['act'])){
                $menu="<li class='has_submenu'>";
            }
            else{
                $menu="<li class='has_submenu'>";
            }
            $menu.="<a href='#'><i class='fa ".$icon."'></i> ".$title." <span class='nav-caret fa fa-caret-down'></span></a>
                    <ul class='list-unstyled'>";
            foreach ($array as $row) {
                $menu.="<li><a href=".$row['link']."><i class='fa ".$row['icon']."'></i> ".$row['title']."</a></li>";
            }
            $menu.="   </ul>
                  </li>";
            if($privilege==$_SESSION['prive'] || $privilege=='*'){
                echo $menu;
            }
        }
        
        public function singleMenu($title, $link, $icon, $position, $privilege) {
            if(isset($_GET['p']) && $_GET['p']==$position){
                $menu="<li><a href=".$link." class='active'>";
            }
            else if(!isset ($_GET['p']) && $position=="Home"){
                $menu="<li><a href=".$link." class='active'>";
            }
            else{
                $menu="<li><a href=".$link.">";
            }
            $menu.="<i class='fa ".$icon."'></i> ".$title."</a></li>";
            if($privilege==$_SESSION['prive'] || $privilege=='*'){
                echo $menu;
            }            
        }
		
		public function headingmenu($position, $title, $privilege) {
			if($position == '0') {
				$menu = "<div class='side-nav-block'><h4>".$title."</h4><ul class='list-unstyled'>";
			}
			else if($position == '1') {
				$menu = "</ul></div>";
			}
			if($privilege==$_SESSION['prive'] || $privilege=='*'){
                echo $menu;
            }
			
		}
    }
    
	
	class pagination extends dbController{
		function totalRecord($table, $limit){
			$this->dbOpen();		
			$table= mysqli_real_escape_string($this->conn, $table);
			
			$sql = "SELECT COUNT(*) AS count FROM $table";			
			
			$query = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
			
			$row =  mysqli_fetch_array($query);
			$total_records = $row['count'];
			$total_pages = ceil($total_records / 10);  
			return $total_pages;
		}
	}
?>