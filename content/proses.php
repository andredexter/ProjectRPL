<?php
    session_start();
    require_once ('classes/mainClass.php');
    require_once ('classes/shiftClass.php');
    require_once ('classes/pengajarClass.php');
    require_once ('classes/instrumentClass.php');
    require_once ('classes/siswaClass.php');
    require_once ('classes/jadwalClass.php');
    require_once ('classes/absensiClass.php');
    require_once ('classes/pembayaranClass.php');
    
    $act=$_GET['act'];
    
    if($act==null){
        header('Location: ../');
    }
    
    else{
        if($act=='login'){
            $user= new userController();            
            $user->userLogin($_POST['name'], $_POST['password']);
        }

        elseif ($act=='logout') {
            $user= new userController();
            $user->userLogout();
        }
        
        else if($act=='saveShift'){
			$newShift = new shiftTime();
			$newShift->saveShift($_POST['idhari'], $_POST['jam_awal'], $_POST['jam_akhir']);
		}
		else if($act=='editShift'){
			$newShift = new shiftTime();
			$newShift->editShift($_POST['idshift'], $_POST['awal'], $_POST['akhir']);
		}
		else if($act=='deleteShift'){
			$newShift = new shiftTime();
			$newShift->deleteShift($_POST['idshift']);
		}
		else if($act=='savePengajar'){
			$newPengajar = new pengajar();
			$newPengajar->savePengajar($_POST['name'], $_POST['tempat'], $_POST['tanggal'], $_POST['pendidikan'], $_POST['alamat'], $_POST['telp']);
		}
		else if($act=='editPengajar'){
			$newPengajar = new pengajar();
			$newPengajar->editPengajar($_POST['idPengajar'], $_POST['namaPengajar'], $_POST['tempatPengajar'], $_POST['tanggalPengajar'], $_POST['pendidikanPengajar'], $_POST['alamatPengajar'], $_POST['telpPengajar']);
		}
		else if($act=='deletePengajar'){
			$newPengajar = new pengajar();
			$newPengajar->deletePengajar($_POST['idPengajar'], $_POST['namaPengajar']);
		}
		else if($act=='saveSiswa'){
			$newsiswa = new siswa();
			$total= str_replace('.','',$_POST['total']);
			$newsiswa->saveSiswa($_POST['nama'], $_POST['tempatlahir'], $_POST['tanggallahir'], $_POST['alamat'], $_POST['telepon'], $_POST['tanggaldaftar'], $total, $_POST['instrument']);
		}
		else if($act=='editSiswa'){
			$newsiswa = new siswa();
			$newsiswa->editSiswa($_POST['idSiswa'], $_POST['nama'], $_POST['tempatlahir'], $_POST['tanggallahir'], $_POST['alamat'], $_POST['telepon'], $_POST['instrument'], $_POST['tingkat']);
		}
		else if($act=='deleteSiswa'){
			$newsiswa = new siswa();
			$newsiswa->deleteSiswa($_POST['idSiswa'], $_POST['namaSiswa']);
		}
		else if($act=='saveInstrument'){
			$newinstrument = new instrument();
			$newinstrument->saveInstrument($_POST['jenis'], $_POST['biaya']);
		}
		else if($act=='editInstrument'){
			$newinstrument = new instrument();
			$newinstrument->editInstrument($_POST['idInstrument'], $_POST['namaInstrument'], $_POST['biayaInstrument']);
		}
		else if($act=='deleteInstrument'){
			$newinstrument = new instrument();
			$newinstrument->deleteInstrument($_POST['idInstrument'], $_POST['namaInstrument']);
		}
		else if($act=='saveJadwal'){
			$newjadwal = new jadwal();
			$newjadwal->saveJadwal($_POST['siswa'], $_POST['pengajar'], $_POST['shift']);
		}
		else if($act=='deleteJadwal'){
			$newjadwal = new jadwal();
			$newjadwal->deleteJadwal($_POST['idjadwal']);
		}
		else if($act=='saveAbsen'){
			$newAbsensi = new absensi();
			$newAbsensi->saveAbsen($_POST['bln'], $_POST['jumlah'], $_POST['idsiswa'], $_POST['idpengajar'], $_POST['siswa'], $_POST['pengajar']);
		}
		else if($act=='editAbsen'){
			$newAbsensi = new absensi();
			$newAbsensi->editAbsen($_POST['idabsen'], $_POST['siswa'], $_POST['pengajar']);
		}
		else if($act=='savePembayaran'){
			$newbayar = new pembayaran();
			$newbayar->savePembayaran($_POST['bln'], $_POST['idsiswa'], $_POST['jumlah']);
		}
		else if($act=='editPembayaran'){
			$newbayar = new pembayaran();
			$newbayar->editPembayaran($_POST['idbayar'], $_POST['jumlah']);
		}
		else if($act=='saveInfo'){
			$informasi = new settingApps();
			$informasi->saveInfo('judul', $_POST['judulweb']);
			$informasi->saveInfo('nama', $_POST['namasekolah']);
			$informasi->saveInfo('telepon', $_POST['notelp']);
			$informasi->saveInfo('alamat', $_POST['alamat']);
			$informasi->saveInfo('kota', $_POST['kota']);
			$informasi->saveInfo('pemilik', $_POST['pemilik']);
		}
		else if($act=='getBiaya'){
			$instrument= new instrument();
			echo $instrument->getBiaya($_POST['id']);
		}
    }
    
?>
