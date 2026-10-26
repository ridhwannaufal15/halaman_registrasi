<?php
session_start();
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

$errors = [];
$nama = $email = $username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = htmlspecialchars($_POST["nama"]);
    $email    = htmlspecialchars($_POST["email"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    if (empty($nama)) $errors[] = "Nama wajib diisi.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";
    if (empty($username)) $errors[] = "Username wajib diisi.";
    if (empty($password)) $errors[] = "Password wajib diisi.";
    if (empty($errors)) {
        $_SESSION['users'][] = [
            'nama' => $nama, 
            'email' => $email, 
            'username' => $username
        ];
        $nama = $email = $username = ""; 
        echo "<p style='color:green;'>Berhasil didaftarkan!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Registrasi</h2>

    <?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>

    <form method="post">
        Nama: <input type="text" name="nama" value="<?= $nama ?>"><br><br>
        Email: <input type="text" name="email" value="<?= $email ?>"><br><br>
        Username: <input type="text" name="username" value="<?= $username ?>"><br><br>
        Password: <input type="password" name="password"><br><br>
        <button type="submit">Daftar</button>
    </form>

    <hr>
    <h3>Data Terdaftar</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Username</th>
        </tr>
        <?php if (empty($_SESSION['users'])): ?>
            <tr><td colspan="4">Belum ada data.</td></tr>
        <?php else: ?>
            <?php foreach ($_SESSION['users'] as $i => $u): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= $u['nama'] ?></td>
                <td><?= $u['email'] ?></td>
                <td><?= $u['username'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>