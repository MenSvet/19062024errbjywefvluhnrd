<?php
// Включаем отображение всех ошибок (для отладки)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, был ли файл загружен и не произошла ли ошибка при загрузке
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['productImage']['tmp_name'];
        $fileName = $_FILES['productImage']['name'];
        $fileSize = $_FILES['productImage']['size'];
        $fileType = $_FILES['productImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Определяем директорию для загрузки
        $uploadFileDir = './uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }
        $dest_path = $uploadFileDir . $fileName;

        // Перемещаем файл в директорию загрузки
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            echo json_encode(['status' => 'success', 'path' => $dest_path]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'There was an error moving the uploaded file']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or there was an upload error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
