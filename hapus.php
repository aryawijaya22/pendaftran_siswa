<?php

include("connection.php");

if( isset($_GET['id']) ){
	
	$id = $_GET['id'];
	
	$sql = "DELETE FROM calon_siswadigitaltalent WHERE id=$id";
	$query = mysqli_query($db, $sql);
	
	if( $query ){
		header('Location: list-siswadaftar.php');
	} else {
		die("gagal menghapus...");
	}
	
} else {
	die("akses dilarang...");
}

?>
