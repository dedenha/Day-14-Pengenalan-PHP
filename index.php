<?php
session_start();

// Daftar Buku Awal
if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [
        '1' => 'Clean Code',
        '2' => 'The Pragmatic Programmer',
        '3' => 'Design Patterns',
        '4' => 'Refactoring',
        '5' => 'You Don\'t Know JS',
    ];
}

// Daftar Buku yang Dipinjam
if (!isset($_SESSION['borrowed_books'])) {
    $_SESSION['borrowed_books'] = [];
}

function displayBooks($books)
{
    if (empty($books)) {
        echo "Tidak ada buku tersedia.<br>";
    } else {
        foreach ($books as $id => $title) {
            echo "$id. $title<br>";
        }
    }
}

function borrowBook($bookId)
{
    if (isset($_SESSION['books'][$bookId])) {
        $_SESSION['borrowed_books'][$bookId] = $_SESSION['books'][$bookId];
        unset($_SESSION['books'][$bookId]);
        echo "Buku berhasil dipinjam.<br>";
    } else {
        echo "Buku tidak ditemukan.<br>";
    }
}

function returnBook($bookId)
{
    if (isset($_SESSION['borrowed_books'][$bookId])) {
        $_SESSION['books'][$bookId] = $_SESSION['borrowed_books'][$bookId];
        unset($_SESSION['borrowed_books'][$bookId]);
        echo "Buku berhasil dikembalikan.<br>";
    } else {
        echo "Buku tidak ditemukan di daftar peminjaman.<br>";
    }
}

// Proses Input Pengguna
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case '1':
            echo "=== Daftar Buku Tersedia ===<br>";
            displayBooks($_SESSION['books']);
            break;

        case '2':
            if (isset($_POST['book_id'])) {
                $bookId = $_POST['book_id'];
                borrowBook($bookId);
            } else {
                echo "Masukkan ID buku yang ingin dipinjam.<br>";
            }
            break;

        case '3':
            if (isset($_POST['book_id'])) {
                $bookId = $_POST['book_id'];
                returnBook($bookId);
            } else {
                echo "Masukkan ID buku yang ingin dikembalikan.<br>";
            }
            break;

        case '4':
            session_destroy();
            echo "Anda telah keluar.";
            break;

        default:
            echo "Pilihan tidak valid.<br>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Perpustakaan</title>
</head>
<body>
    <h2>Sistem Manajemen Perpustakaan Sederhana</h2>
    <form action="index.php" method="post">
        <p>Pilih opsi:</p>
        <p>1. Lihat Daftar Buku</p>
        <p>2. Pinjam Buku</p>
        <p>3. Kembalikan Buku</p>
        <p>4. Keluar</p>
        
        <label for="action">Masukkan pilihan (1-4): </label>
        <input type="number" id="action" name="action" required><br><br>

        <label for="book_id">Masukkan ID buku (untuk peminjaman/pengembalian): </label>
        <input type="number" id="book_id" name="book_id"><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
