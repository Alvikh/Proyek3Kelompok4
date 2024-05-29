@include('layouts.sidebar')
@include('layouts.navbar')
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card mt-8">
        <div class="card-header pb-0">
          <h4>Tambah Model Baru</h4>
        </div>
        <div class="card-body pt-0">
          <form action="{{ route('models.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
            @csrf
            <input type="number" name="id" class="form-control d-none" value="{{ $user->id }}">
            <div class="form-group">
              <label for="gambar" class="d-none">Gambar:</label>
              <div class="custom-file">
                <input type="file" class="form-control d-none" name="gambar[]" id="gambar" multiple required>
              </div>
              <div class="drag-drop-area" id="drag-drop-area">
                <p>Tolong <i class="text-danger">Drag & Drop</i> fotonya di sini, ya!</p>
              </div>
              <div id="file-preview"></div>
            </div>
            <button type="submit" class="btn btn-primary">Oke, simpan!</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.drag-drop-area {
  border: 2px dashed #ccc;
  padding: 20px;
  text-align: center;
  cursor: pointer;
  margin-top: 10px;
}
.drag-drop-area.dragging {
  border-color: #000;
}
#file-preview img {
  max-width: 100px;
  margin: 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const dragDropArea = document.getElementById('drag-drop-area');
  const fileInput = document.getElementById('gambar');
  const filePreview = document.getElementById('file-preview');

  dragDropArea.addEventListener('click', () => fileInput.click());

  fileInput.addEventListener('change', (e) => {
    displayFiles(e.target.files);
  });

  dragDropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dragDropArea.classList.add('dragging');
  });

  dragDropArea.addEventListener('dragleave', () => {
    dragDropArea.classList.remove('dragging');
  });

  dragDropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dragDropArea.classList.remove('dragging');
    const files = e.dataTransfer.files;
    fileInput.files = files;
    displayFiles(files);
  });

  function displayFiles(files) {
    filePreview.innerHTML = '';
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();
      reader.onload = (e) => {
        const img = document.createElement('img');
        img.src = e.target.result;
        filePreview.appendChild(img);
      };
      reader.readAsDataURL(file);
    }
  }
});
</script>
