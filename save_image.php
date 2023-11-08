<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['image'])) {
        $imageData = $data['image'];
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);
        
        $outputFolder = 'output/';
        $filename = $outputFolder . 'image_' . date('YmdHis') . '.png';
        
        if (file_put_contents($filename, $image)) {
            echo json_encode(['message' => 'Gambar berhasil disimpan']);
        } else {
            echo json_encode(['message' => 'Gagal menyimpan gambar']);
        }
    } else {
        echo json_encode(['message' => 'Data gambar tidak ditemukan']);
    }
} else {
    echo json_encode(['message' => 'Metode yang tidak diizinkan']);
}
?>


