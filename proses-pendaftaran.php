<?php

include("connection.php");

// cek apakah tombol daftar sudah diklik atau blum?
if(isset($_POST['daftar'])){

	// ambil data dari formulir
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$jk = $_POST['jenis_kelamin'];
	$agama = $_POST['agama'];
	$sekolah = $_POST['sekolah_asal'];
	$up = $file_upload['upload_photo'];
	
	// buat query
	$sql = "INSERT INTO calon_siswadigitaltalent (nama, alamat, jenis_kelamin, agama, sekolah_asal, upload_photo) VALUE ('$nama', '$alamat', '$jk', '$agama', '$sekolah', '$file_upload')";
	$query = mysqli_query($db, $sql);
	
	// apakah query simpan berhasil?
	if( $query ) {
		// kalau berhasil alihkan ke halaman index.php dengan status=sukses
		header('Location: index.php?status=sukses');
	} else {
		// kalau gagal alihkan ke halaman indek.ph dengan status=gagal
		header('Location: index.php?status=gagal');
	}
	
	
} else {
die("Akses dilarang, Jangan Masuk :) ...");
}


?>
