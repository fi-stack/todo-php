<?php
// menyiapkan array
$todos = [];
// apakah ada file todo.txt
if (file_exists('todo.txt')) {
    // membaca file todo.txt
    $file = file_get_contents('todo.txt');
    // mengubah format serialize menjadi array
    $todos = unserialize($file);
}

function saveData($schedule)
{
    file_put_contents('todo.txt', $schedule);
    header('location:index.php');
}
// jika ditemukan todo yang dikirim melalui method POST
if (isset($_POST['todo'])) {
    $data = $_POST['todo'];
    $todos[] = [
        'todo' => $data,
        'status' => 0
    ];
    $schedule = serialize($todos);
    saveData($schedule);
}
// jika ditemukan $_GET['status']
if (isset($_GET['status'])) {
    // ubah status
    $todos[$_GET['key']]['status'] = $_GET['status'];
    $schedule = serialize($todos);
    saveData($schedule);
}
// jika ditemukan perintah hapus / $_GET['hapus']
if (isset($_GET['hapus'])) {
    // hapus data dengan key sesuai yang dipilih
    unset($todos[$_GET['key']]);
    $schedule = serialize($todos);
    saveData($schedule);
}
// print_r($todos);
?>
<h1>Todo App</h1>
<form method="POST">
    <label>Aktifitas Hari Ini</label><br>
    <input type="text" name="todo">
    <button type="submit">Simpan</button>
</form>
<ol>
    <?php foreach ($todos as $key => $value) : ?>
        <li>
            <input type="checkbox" name="todo" onclick="window.location.href='index.php?status=<?php echo ($value['status'] == 1) ? '0' : '1'; ?>&key=<?php echo $key; ?>'" ; <?php if ($value['status'] == 1) echo 'checked' ?>>
            <label>
                <?php
                if ($value['status'] == 1) {
                    echo '<del>' . $value['todo'] . '</del>';
                } else {
                    echo $value['todo'];
                }
                ?>
            </label>
            <a href="index.php?hapus=1&key=<?= $key; ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">hapus</a>
        </li>
    <?php endforeach; ?>
</ol>