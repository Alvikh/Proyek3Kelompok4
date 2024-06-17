var varaktifkan = false;
var lokasiTerdeteksi = null;
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const gedungSelect = document.getElementById('gedungSelect');
const ruangSelect = document.getElementById('ruangSelect');
const kameraSelect = document.getElementById('kameraSelect');

gedungSelect.addEventListener('change', function () {
    const gedungId = this.value;
    if (gedungId) {
        fetch(`/api/get-ruang/${gedungId}`)
            .then(response => response.json())
            .then(data => {
                ruangSelect.innerHTML = '<option value="">Pilih Ruang</option>';
                data.forEach(ruang => {
                    ruangSelect.innerHTML += `<option value="${ruang.id}">${ruang.nama_ruang}</option>`;
                });
                ruangSelect.classList.remove('d-none');
            });
    } else {
        ruangSelect.classList.add('d-none');
        kameraSelect.classList.add('d-none');
    }
});

ruangSelect.addEventListener('change', function () {
    const ruangId = this.value;
    if (ruangId) {
        fetch(`/api/get-kamera/${ruangId}`)
            .then(response => response.json())
            .then(data => {
                kameraSelect.innerHTML = '<option value="">Pilih Kamera</option>';
                data.forEach((kamera, index) => {
                    kameraSelect.innerHTML += `<option value="videoInput${index + 1}">${kamera.nama_kamera}</option>`;
                });
                kameraSelect.classList.remove('d-none');
            });
    } else {
        kameraSelect.classList.add('d-none');
    }
});

document.getElementById('btn_aktifkan').addEventListener('click', function () {
    aktifkan();
});

kameraSelect.addEventListener('change', (event) => {
    if (btn_aktifkan.classList.contains('d-none')) {
        btn_aktifkan.classList.remove('d-none');
    } else {
        showCamera(event.target.value);
    }
});

function aktifkan() {
    if (!varaktifkan) {
        varaktifkan = true;
        btn_aktifkan.style = "opacity:0;cursor:none;visibility:hidden";
        const lokalKamera = document.getElementById('lokalKamera');
        const semuaKamera = document.querySelectorAll('.deteksiKamera');
        const kameraSelect = document.getElementById('kameraSelect');

        Promise.all([
            faceapi.nets.faceRecognitionNet.loadFromUri('/assets/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/assets/models'),
            faceapi.nets.ssdMobilenetv1.loadFromUri('/assets/models')
        ]).then(start);

        async function start() {    
            const labeledDescriptors = await loadLabeledImages();
            btn_aktifkan.style = 'display:none';
            btn_pilihkamera.classList.remove("d-none");
            btn_pilihkamera.classList.add("d-flex");

            showCamera(kameraSelect.value);

            semuaKamera.forEach((element, index) => {
                if (element.id === 'lokalKamera') {
                    return;
                }
                
                var iniKamera = element;
                setTimeout(function(){
                    lokasiTerdeteksi = parseInt(iniKamera.getAttribute('data-id'));
                    recognizeFaces(iniKamera, labeledDescriptors, lokasiTerdeteksi);
                },1000);
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

        async function recognizeFaces(videoElement, labeledDescriptors, lokasiTerdeteksi) {
            //const labeledDescriptors = await loadLabeledImages();
            //console.log(labeledDescriptors);
            const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.5);

            //console.log(`Memulai deteksi wajah untuk ${videoElement.alt}`);
            const canvas = faceapi.createCanvasFromMedia(videoElement);
            document.body.append(canvas);
            const displaySize = { width: videoElement.width, height: videoElement.height };
            faceapi.matchDimensions(canvas, displaySize);

            let dataTerdeteksi = [];

            const masukkanData = (name) => {
                if (!dataTerdeteksi.includes(name)) {
                    dataTerdeteksi.push(name);
                    absenMasuk(name, lokasiTerdeteksi);
                    setTimeout(() => {
                        const index = dataTerdeteksi.indexOf(name);
                        if (index > -1) {
                            dataTerdeteksi.splice(index, 1);
                        }
                    }, 10000);
                }
            };

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
                        console.log(dataTerdeteksi);
                        masukkanData(namafix);
                        /*if (!dataTerdeteksi.includes(namafix)) {
                            absenMasuk(namafix, lokasiTerdeteksi);
                            dataTerdeteksi.push(namafix);
                        }*/

                        if (videoElement.classList.contains('showCam')) {
                            const mirroredX = displaySize.width - (box.x + box.width);
                            const mirroredBox = { x: mirroredX, y: box.y, width: box.width, height: box.height };
                            const drawBox = new faceapi.draw.DrawBox(mirroredBox, { label: namafix, boxColor: 'blue' });

                            var rect = videoElement.getBoundingClientRect();
                            canvas.style.top = rect.top + 'px';
                            canvas.style.left = rect.left + 'px';
                            drawBox.draw(canvas);
                        }

                        //orang.innerText = namafix;
                    }
                });
            }, 200);

            ipCamInterval = intervalDeteksi;
            //videoElement.onerror = clearInterval(ipCamInterval);
        }

        function absenMasuk(nama, lokasiTerdeteksi) {
            const data = { nama_person: nama, keterangan: lokasiTerdeteksi };

            fetch('/absensi-masuk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
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