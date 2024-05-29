<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>

        <div class="container">

            <div class="card">
                <div class="card-header">...</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div id="drag_drop">Drag & Drop Foto di Sini!</div>
                        </div>
                        <div class="col-md-3">&nbsp;</div>
                    </div>
                </div>
            </div>
            <br />
            <div class="progress" id="progress_bar" style="display:none; height:50px;">
                <div class="progress-bar bg-success" id="progress_bar_process" role="progressbar" style="width:0%; height:50px;">0%</div>
            </div>
            <div id="uploaded_image" class="row mt-5"></div>
        </div>
    </body>
</html>

<style>#drag_drop{background-color : #f9f9f9;border : #ccc 4px dashed;line-height : 250px;padding : 12px;font-size : 24px;text-align : center;}</style>

<script>

function _(element){return document.getElementById(element);}
_('drag_drop').ondragover = function(event){this.style.borderColor = '#333';return false;}
_('drag_drop').ondragleave = function(event){this.style.borderColor = '#ccc';return false;}
_('drag_drop').ondrop = function(event){event.preventDefault();var form_data  = new FormData();var image_number = 1;var error = '';

    var drop_files = event.dataTransfer.files;
    for(var count = 0; count < drop_files.length; count++)
    {
        if(!['image/jpeg', 'image/png', 'video/mp4'].includes(drop_files[count].type)){
            error += '<div class="alert alert-danger"><b>'+image_number+'</b> Selected File must be .jpg or .png Only.</div>';
        } else {
            form_data.append("images[]", drop_files[count]);
        }
        image_number++;
    }

    if(error != ''){
        _('uploaded_image').innerHTML = error;
        _('drag_drop').style.borderColor = '#ccc';
    } else {
        _('progress_bar').style.display = 'block';
        var ajax_request = new XMLHttpRequest();
        ajax_request.open("post", "upload.php");
        ajax_request.upload.addEventListener('progress', function(event){
            var percent_completed = Math.round((event.loaded / event.total) * 100);
            _('progress_bar_process').style.width = percent_completed + '%';
            _('progress_bar_process').innerHTML = percent_completed + '% completed';
        });
        ajax_request.addEventListener('load', function(event){
            _('uploaded_image').innerHTML = '<div class="alert alert-success">Foto Siap Diupload!</div>';
            _('drag_drop').style.borderColor = '#ccc';
        });
        ajax_request.send(form_data);
    }
}

</script>
