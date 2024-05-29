var varaktifkan = false;
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function aktifkan() {
    if (varaktifkan == false) {
        varaktifkan = true;
        btn_aktifkan.style = "opacity:0;cursor:none;visibility:hidden";
        const lokalKamera = document.getElementById('lokalKamera');
        const semuaKamera = document.querySelectorAll('.deteksiKamera');
        const cameraSelect = document.getElementById('cameraSelect');
        
        Promise.all([
            faceapi.nets.faceRecognitionNet.loadFromUri('/assets/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/assets/models'),
            faceapi.nets.ssdMobilenetv1.loadFromUri('/assets/models')
        ]).then(start)

        function start() {
            btn_aktifkan.style = 'display:none';
            btn_pilihkamera.classList.remove("d-none");
            btn_pilihkamera.classList.add("d-flex");
            //mulaiKameraLokal()
            //recognizeFaces(lokalKamera);
            cameraSelect.addEventListener('change', (event) => {
                showCamera(event.target.value);
            });
            showCamera(cameraSelect.value);

            semuaKamera.forEach((element, index) => {
                if (element.id === 'lokalKamera') {
                    return;
                }
                
                var iniKamera = element;
                iniKamera.classList.remove("d-none");

                recognizeFaces(iniKamera);
            });
        }

        function showCamera(selectedCameraId) {
            semuaKamera.forEach((element) => {
                if (element.id === 'lokalKamera') {
                    return;
                }

                if (element.id === selectedCameraId) {
                    element.classList.remove('hiddenCam');
                    element.classList.add('showCam');
                } else {
                    element.classList.remove('showCam');
                    element.classList.add('hiddenCam');
                }
            });
        }

        function mulaiKameraLokal() {
            navigator.mediaDevices.getUserMedia({ video: {} })
                .then(stream => {
                    lokalKamera.srcObject = stream;
                })
                .catch(err => console.error(err));
        }

        async function recognizeFaces(videoElement) {
            const labeledDescriptors = await loadLabeledImages();
            //console.log(labeledDescriptors);
            const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.5);

            console.log(`Memulai deteksi wajah untuk ${videoElement.alt}`);
            const canvas = faceapi.createCanvasFromMedia(videoElement);
            document.body.append(canvas);
            const displaySize = { width: videoElement.width, height: videoElement.height };
            faceapi.matchDimensions(canvas, displaySize);

            let dataTerdeteksi = [];

            intervalDeteksi = setInterval(async () => {
                const detections = await faceapi.detectAllFaces(videoElement).withFaceLandmarks().withFaceDescriptors();
                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                resizedDetections.forEach((detection, i) => {
                    const result = faceMatcher.findBestMatch(detection.descriptor);
                    const box = detection.detection.box;
                    const nama_person = result.toString();
                    const namafix = nama_person.replace(/\s\([^)]*\)/, '');
                    if (namafix !== "unknown") {
                        if (!dataTerdeteksi.includes(namafix)) {
                            absenMasuk(namafix);
                            dataTerdeteksi.push(namafix);
                        }

                        if (videoElement.classList.contains('showCam')) {
                            const mirroredX = displaySize.width - (box.x + box.width);
                            const mirroredBox = { x: mirroredX, y: box.y, width: box.width, height: box.height };
                            const drawBox = new faceapi.draw.DrawBox(mirroredBox, { label: nama_person });
    
                            var rect = videoElement.getBoundingClientRect();
                            canvas.style.top = rect.top + 'px';
                            canvas.style.left = rect.left + 'px';
                            drawBox.draw(canvas);
                        }

                        //orang.innerText = namafix;
                    }
                });
            }, 100);

            //ipCamInterval = intervalDeteksi;
            //videoElement.onerror = clearInterval(ipCamInterval);
        }

        function absenMasuk(nama) {
            fetch('/absensi-masuk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ nama_person: nama })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data.success);
                    } else {
                        console.error(data.error || data.message);
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        }

        function loadLabeledImages() {
            return Promise.all(
                labels.map(async (label) => {
                    const descriptions = []
                    for (let i = 1; i <= 2; i++) {
                        const img = await faceapi.fetchImage(`/assets/img/labeled_images/${label}/${i}.jpg`);
                        const detectionsArray = await faceapi.detectAllFaces(img).withFaceLandmarks().withFaceDescriptors();
                        if (detectionsArray && detectionsArray.length > 0) {
                            detectionsArray.forEach(detections => {
                                //console.log(label + i + JSON.stringify(detections));
                                descriptions.push(detections.descriptor);
                            });
                        }
                    }
                    return new faceapi.LabeledFaceDescriptors(label, descriptions)
                })
            )
        }

    }
}