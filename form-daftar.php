<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Formulir Pendaftaran Siswa Baru Digital Talent | STMIK IKMI CIREBON</title>
</head>

<body>
	<header>
		<h3>Formulir Pendaftaran Siswa Baru Digital Talent</h3>
	</header>

	<form action="proses-pendaftaran.php" method="POST" enctype="multipart/form-data">

		<fieldset>

			<p>
				<label for="nama">Nama: </label>
				<input type="text" name="nama" placeholder="nama lengkap" />
			</p>
			<p>
				<label for="alamat">Alamat: </label>
				<textarea name="alamat"></textarea>
			</p>
			<p>
				<label for="jenis_kelamin">Jenis Kelamin: </label>
				<label><input type="radio" name="jenis_kelamin" value="laki-laki"> Laki-laki</label>
				<label><input type="radio" name="jenis_kelamin" value="perempuan"> Perempuan</label>
			</p>
			<p>
				<label for="agama">Agama: </label>
				<select name="agama">
					<option>Islam</option>
					<option>Kristen</option>
					<option>Hindu</option>
					<option>Budha</option>
					<option>Atheis</option>
				</select>
			</p>
			<p>
				<label for="sekolah_asal">Sekolah Asal: </label>
				<input type="text" name="sekolah_asal" placeholder="nama sekolah" />
			</p>
			<p>
				<label for="upload_photo">Upload Photo :</label>
				<input type="file" name="upload_photo" accept="image/*">
			</p>
			<p>
				<input type="submit" value="Daftar" name="daftar" />
			</p>

		</fieldset>

	</form>

</body>

</html>