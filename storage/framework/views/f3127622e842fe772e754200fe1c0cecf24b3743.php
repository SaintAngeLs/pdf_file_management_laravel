<!doctype html>
    <html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(env('APP_NAME_IN_TITLE')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<style>
    form {
        width: 55vw;
        height: 25vh;
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .disabled-input {
        pointer-events: none;
        opacity: 0.6;
    }
</style>

<body>
    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if($errors->any()): ?>
    <div class="p-4">
        <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($error); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    </div>
    <?php endif; ?>

    <form class="row g-3 needs-validation" novalidate action="<?php echo e(route('document.edit.save')); ?>" method="POST" enctype="multipart/form-data" id="documentForm">
            <?php echo csrf_field(); ?>

            <!-- Document Title Field -->
            <div class="col-md-12">
                <label for="title" class="form-label">Document Title</label>
                <input type="hidden" name="id" value="<?php echo e($data->id); ?>" required>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo e($data->title); ?>" required>
                <div class="invalid-feedback">
                    Please provide a title for the document.
                </div>
            </div>

            <!-- Current File Uploaded Field -->
            <div class="col-md-12">
                <label for="fileExistenceInfo" class="form-label">Current Uploaded File</label>
                <div id="fileExistenceInfo" class="text-muted">Checking file...</div>
            </div>


            <!-- PDF Field -->
            <div class="col-md-12">
                <label for="pdf" class="form-label">PDF File (Replace if needed)</label>
                <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf">
            </div>


            <!-- Upload Date Field -->
            <div class="col-md-12">
                <label for="uploadDate" class="form-label">Upload Date</label>
                <input type="date" class="form-control" id="uploadDate" name="upload_date" value="<?php echo e($data->upload_date); ?>" required>
                <div class="invalid-feedback">
                    Please select an upload date.
                </div>
            </div>


            <!-- Status Field -->
            <div class="col-md-12">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="1" <?php echo e($data->status ? 'selected' : ''); ?>>Visible</option>
                    <option value="0" <?php echo e(!$data->status ? 'selected' : ''); ?>>Invisible</option>
                </select>
                <div class="invalid-feedback">
                    Please select the status of the document.
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-12">
                <button class="btn btn-dark" type="submit">Save Changes</button>
            </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <script>
        (function() {
            'use strict';

            var form = document.getElementById('documentForm');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Additional validation for file type
                var pdfInput = document.getElementById('pdf');
                if (pdfInput.files.length > 0) {
                    var fileType = pdfInput.files[0].type;
                    var isValidPDF = fileType === 'application/pdf';
                    if (!isValidPDF) {
                        pdfInput.classList.add('is-invalid');
                        event.preventDefault();
                    } else {
                        pdfInput.classList.remove('is-invalid');
                    }
                }

                form.classList.add('was-validated');
            }, false);
        })();
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var pdfName = "<?php echo e($data->pdf); ?>";
        if (pdfName) {
            checkFileExistence(pdfName);
        }
    });

    function checkFileExistence(fileName) {
    fetch('/check-file-existence?fileName=' + fileName)
        .then(response => response.json())
        .then(data => {
            var fileExistenceInfo = document.getElementById('fileExistenceInfo');
            if (data.exists) {
                fileExistenceInfo.innerHTML = '<div style="text-align: left;">' +
                                              '<img src="/pdf-icon.svg" alt="PDF Icon" style="height: 40px; width: 40px;"/>' +
                                              '<div>Current file: ' + fileName + '</div>' +
                                              '</div>';
            } else {
                fileExistenceInfo.textContent = 'No file found on server.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('fileExistenceInfo').textContent = 'Error checking file.';
        });
    }

</script>

</body>

</html>
<?php /**PATH /home/kaliuser/Documents/portfolio/a_work/brige_AAAoriginal/bridge_newsletter/resources/views/user/documents/edit.blade.php ENDPATH**/ ?>