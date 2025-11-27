<?php
echo "Upload max filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "Post max size: " . ini_get('post_max_size') . "<br>";
echo "Temp dir: " . sys_get_temp_dir() . "<br>";
echo "Writable: " . (is_writable(sys_get_temp_dir()) ? 'OUI' : 'NON') . "<br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test" accept="image/*">
    <button type="submit">Tester</button>
</form>