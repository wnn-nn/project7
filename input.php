<?php
// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Folder tempat gambar akan diunggah
$uploadDir = "uploads/";

// Cek apakah folder uploads sudah ada
if (!is_dir($uploadDir)) {
    // Jika folder belum ada, buat folder uploads
    if (mkdir($uploadDir, 0777, true)) {
        echo "Folder 'uploads' berhasil dibuat.<br>";
    } else {
        echo "Gagal membuat folder 'uploads'. Pastikan server memiliki izin yang cukup.<br>";
        exit;
    }
} else {
    echo "Folder 'uploads' sudah ada.<br>";
}

// Pastikan folder uploads dapat ditulisi oleh server
if (!is_writable($uploadDir)) {
    echo "Folder 'uploads' tidak dapat ditulisi oleh server. Pastikan izin folder sudah benar.<br>";
    exit;
}

// Cek apakah data telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data yang diperlukan ada
    if (isset($_POST['nama_produk']) && isset($_POST['deskripsi']) && isset($_POST['harga']) && isset($_POST['stok'])) {
        // Ambil data produk dari formulir
        $nama_produk = $_POST["nama_produk"];
        $deskripsi = $_POST["deskripsi"];
        $harga = $_POST["harga"];
        $stok = $_POST["stok"];
        
        // Tampilkan data produk yang dikirim
        echo "<h3>Data Produk yang Dikirim:</h3>";
        echo "Nama Produk: " . htmlspecialchars($nama_produk) . "<br>";
        echo "Deskripsi: " . htmlspecialchars($deskripsi) . "<br>";
        echo "Harga: " . htmlspecialchars($harga) . "<br>";
        echo "Stok: " . htmlspecialchars($stok) . "<br>";
        
        // Cek apakah gambar ada dan berhasil diunggah
        if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
            $gambar = $_FILES["gambar"];
            $uploadFile = $uploadDir . basename($gambar["name"]);

            // Validasi tipe file gambar
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            if (in_array($gambar["type"], $allowedTypes)) {
                // Cek apakah file berhasil diunggah
                if (move_uploaded_file($gambar["tmp_name"], $uploadFile)) {
                    echo "Gambar berhasil diunggah: " . $uploadFile . "<br>";
                    echo "<img src='" . $uploadFile . "' alt='Gambar Produk' style='max-width: 300px;'><br>";
                } else {
                    echo "Gagal mengunggah gambar.<br>";
                }
            } else {
                echo "Tipe file tidak valid. Harus berupa gambar JPG, PNG, atau GIF.<br>";
            }
        } else {
            echo "Tidak ada gambar yang diunggah atau terjadi kesalahan saat mengunggah gambar.<br>";
        }
    } else {
        echo "Data tidak lengkap, silakan periksa kembali formulir Anda.<br>";
    }
} else {
    echo "Formulir belum disubmit.<br>";
}
?>
