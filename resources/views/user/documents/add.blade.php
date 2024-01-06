<!doctype html>
    <html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME_IN_TITLE') }}</title>
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
        z-index: -1;
    }

    .disabled-input {
        pointer-events: none;
        opacity: 0.6;
    }
</style>

<body>
    <div class="container">
    @include('layouts.navbar')
    @if ($errors->any())
    <div class="p-20">
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            {{ $error }}
            @endforeach
    </div>
    </div>
    @endif


    <form class="row g-3 needs-validation" novalidate action="{{route('document.add.save')}}" method="POST" enctype="multipart/form-data" id="documentForm">
        @csrf

        <div class="col-md-12">
                <label for="title" class="form-label">Document Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
                <div class="invalid-feedback">
                    Please provide a title for the document.
                </div>
            </div>

            <!-- PDF Field -->
            <div class="col-md-12">
                <label for="pdf" class="form-label">PDF</label>
                <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" required>
                <div class="invalid-feedback">
                    Please upload a PDF file.
                </div>
            </div>

            <!-- Upload Date Field -->
            <div class="col-md-12">
                <label for="uploadDate" class="form-label">Upload Date</label>
                <input type="date" class="form-control" id="uploadDate" name="upload_date" required>
                <div class="invalid-feedback">
                    Please select an upload date.
                </div>
            </div>

            <!-- Status Field -->
            <div class="col-md-12">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="invisible">Invisible</option>
                    <option value="visible">Visible</option>
                </select>
                <div class="invalid-feedback">
                    Please select the status of the document.
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-dark" type="submit">Save Changes</button>
            </div>
    </form>
</div>

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
        // Set today's date as the default for the upload date input
        document.addEventListener('DOMContentLoaded', (event) => {
            var today = new Date();
            var dateStr = today.toISOString().split('T')[0];
            document.getElementById('uploadDate').value = dateStr;
        });
    </script>

</body>

</html>
