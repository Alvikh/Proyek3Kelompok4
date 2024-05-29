<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deteksi Orang</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="{{ asset('assets/js/tfjs.js') }}"></script>
  <script src="{{ asset('assets/js/cocossd.js') }}"></script>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center mt-3">
      <div class="col-md-6">
        <video id="webcam" width="100%" height="auto" autoplay></video>
        <canvas id="canvas" style="position: absolute; left: 0; top: 0;"></canvas>
        <p class="text-center mt-2">Jumlah Orang dalam Kamera: <span id="count">0</span></p>
      </div>
    </div>
  </div>

  <script>
    async function run() {
      const video = document.getElementById('webcam');
      const canvas = document.getElementById('canvas');
      const countDisplay = document.getElementById('count');
      const context = canvas.getContext('2d');
      const model = await cocoSsd.load();

      if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
          .then(function (stream) {
            video.srcObject = stream;
          })
          .catch(function (error) {
            console.error('Error accessing the webcam: ', error);
          });
      }

      setInterval(async () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.clearRect(0, 0, canvas.width, canvas.height);
        const predictions = await model.detect(video);
        let humanCount = 0;
        predictions.forEach(prediction => {
          if (prediction.class === 'person') {
            const [x, y, width, height] = prediction.bbox;
            const centerX = x + width / 2;// - width * 0.1;
            const centerY = y + height / 2;// - height * 0.3;
            const radius = Math.min(width, height) * 0.3;

            context.beginPath();
            context.arc(centerX, centerY, radius, 0, Math.PI * 2);
            context.fillStyle = 'rgba(0, 0, 255, 0.2)';
            context.fill();
            context.fillStyle = 'white';
            context.fillText('Orang', centerX - radius, centerY - radius - 5);
            humanCount++;
          }
        });
        countDisplay.textContent = humanCount;
      }, 100);
    }

    run();
  </script>
</body>
</html>