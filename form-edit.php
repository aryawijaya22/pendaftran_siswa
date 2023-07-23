<?php
include("connection.php");

if (!isset($_GET['id'])) {
	header('Location: list-siswadaftar.php');
}

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM calon_siswadigitaltalent WHERE id=$id";
$query = mysqli_query($db, $sql);
$siswa = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) < 1) {
	die("Data tidak ditemukan...");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Proses gambar yang diunggah oleh user
	if ($_FILES['upload_photo']['name']) {
		$target_dir = "upload/";
		$target_file = $target_dir . basename($_FILES['upload_photo']['name']);
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		// Memeriksa apakah file yang diunggah adalah gambar
		$check = getimagesize($_FILES['upload_photo']['tmp_name']);
		if ($check === false) {
			die("File yang diunggah bukan gambar.");
		}

		// Memeriksa apakah file sudah ada di server
		if (file_exists($target_file)) {
			die("Maaf, file gambar sudah ada.");
		}

		// Memeriksa ukuran file
		if ($_FILES['upload_photo']['size'] > 500000) {
			die("Maaf, ukuran file terlalu besar.");
		}

		// Memeriksa jenis format gambar yang diizinkan
		if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
			die("Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
		}

		// Jika semua pemeriksaan berhasil, unggah gambar
		if (move_uploaded_file($_FILES['upload_photo']['tmp_name'], $target_file)) {
			// Simpan informasi gambar ke database
			$upload_photo = basename($_FILES['upload_photo']['name']);
			$sql_update = "UPDATE calon_siswadigitaltalent SET upload_photo='$upload_photo' WHERE id=$id";
			mysqli_query($db, $sql_update);
			echo "<script>alert('Berhasil memasukkan gambar. Terima kasih.')</script>";
		} else {
			die("Maaf, terjadi kesalahan saat mengunggah file.");
		}
	}

	// Proses data siswa yang diedit
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$jenis_kelamin = $_POST['jenis_kelamin'];
	$agama = $_POST['agama'];
	$sekolah_asal = $_POST['sekolah_asal'];

	$sql_edit = "UPDATE calon_siswadigitaltalent SET nama='$nama', alamat='$alamat', jenis_kelamin='$jenis_kelamin', agama='$agama', sekolah_asal='$sekolah_asal' WHERE id=$id";
	mysqli_query($db, $sql_edit);

	echo "<script>alert('Berhasil menyimpan perubahan data.')</script>";
	// Redirect ke halaman list-siswadaftar.php setelah berhasil menyimpan perubahan
	header('Location: list-siswadaftar.php');
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Formulir Edit Siswa Digital Talent | STMIK IKMI CIREBON</title>
</head>

<body>
	<header>
		<h3>Formulir Edit Siswa</h3>
	</header>

	<form action="form-edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" name="id" value="<?php echo $siswa['id'] ?>" />
			<p>
				<label for="nama">Nama: </label>
				<input type="text" name="nama" placeholder="nama lengkap" value="<?php echo $siswa['nama'] ?>" />
			</p>
			<p>
				<label for="alamat">Alamat: </label>
				<textarea name="alamat"><?php echo $siswa['alamat'] ?></textarea>
			</p>
			<p>
				<label for="jenis_kelamin">Jenis Kelamin: </label>
				<?php $jk = $siswa['jenis_kelamin']; ?>
				<label><input type="radio" name="jenis_kelamin" value="laki-laki" <?php echo ($jk == 'laki-laki') ? "checked" : "" ?>> Laki-laki</label>
				<label><input type="radio" name="jenis_kelamin" value="perempuan" <?php echo ($jk == 'perempuan') ? "checked" : "" ?>> Perempuan</label>
			</p>
			<p>
				<label for="agama">Agama: </label>
				<?php $agama = $siswa['agama']; ?>
				<select name="agama">
					<option <?php echo ($agama == 'Islam') ? "selected" : "" ?>>Islam</option>
					<option <?php echo ($agama == 'Kristen') ? "selected" : "" ?>>Kristen</option>
					<option <?php echo ($agama == 'Hindu') ? "selected" : "" ?>>Hindu</option>
					<option <?php echo ($agama == 'Budha') ? "selected" : "" ?>>Budha</option>
					<option <?php echo ($agama == 'Atheis') ? "selected" : "" ?>>Atheis</option>
				</select>
			</p>
			<p>
				<label for="sekolah_asal">Sekolah Asal: </label>
				<input type="text" name="sekolah_asal" placeholder="nama sekolah" value="<?php echo $siswa['sekolah_asal'] ?>" />
			</p>
			<p>
				<!-- Tambahkan input untuk mengunggah gambar baru -->
				<label for="upload_photo">Upload Photo: </label>
				<input type="file" name="upload_photo" accept="image/*" />
			</p>
			<p>
				<input type="submit" value="Simpan" name="simpan" />
			</p>
		</fieldset>
	</form>

</body>

</html>
