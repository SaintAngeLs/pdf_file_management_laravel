<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME_IN_TITLE') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-lg">
    @include('layouts.navbar')
    @if($documentCount == 0)
    <center>
      <p style="padding-top: 40vh;">"No document has beed uploaded."</p>
    </center>
    @else
     <!-- Toast Container -->
    <div id="toastContainer" aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <!-- Toasts will appear here -->
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">id</th>
              <th scope="col">Title</th>
              <th scope="col">Date</th>
              <th scope="col">Pdf URI</th>
              <th scope="col">Status</th>
              <th scope="col">Options</th>
            </tr>
          </thead>
          <tbody>
            @foreach($documentData as $document)

            <tr>
                <td>{{ $document->id }}</td>
                <td>{{ $document->title }}</td>
                <td>{{ $document->upload_date }}</td>
                <td>{{ $document->pdf }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Status update">
                        <button type="button" id="visible-btn-{{ $document->id }}" class="btn  {{ $document->status ? 'btn-success btn-sm' : 'btn-outline-success btn-sm ' }} btn-sm" onclick="updateStatus('{{ $document->id }}', 'visible')">Visible</button>
                        <button type="button" id="invisible-btn-{{ $document->id }}" class="btn btn-sm {{ !$document->status ? 'btn-danger btn-sm' : 'btn-outline-danger btn-sm' }} btn-sm" onclick="updateStatus('{{ $document->id }}', 'invisible')">Invisible</button>
                    </div>
                </td>


                <td>
                    <a class="btn btn-dark btn-sm" href="#" onclick="viewPdf('{{ route('pdf.show', ['pdfName' => $document->pdf]) }}', '{{ $document->pdf }}')">View PDF</a>
                    <button class="btn btn-success btn-sm"  onclick="copyToClipboard('{{ route('article.view', ['hash' => $document->hash]) }}')">Copy Link</button>
                    <a class="btn btn-primary btn-sm" href="{{ route('document.edit', ['documentId' => $document->id]) }}">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $document->id }}">
                        Delete
                    </button>

                </td>

            </tr>

<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="exampleModal{{ $document->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Remove "{{ $document->title }}" document</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete the document {{ $document->title }}?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form method="POST" action="{{ route('document.delete') }}">
            @csrf
            <input type="hidden" name="id"
                value="{{ $document->id }}">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        </div>
      </div>
    </div>
  </div>
                </td>
              </tr>
@endforeach

          </tbody>
        </table>
      </div>
</div>
      @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('The link is copied to clipboard.');
            }).catch(function(error) {
                showToast('Error in copying text: ' + error);
            });
        }

        function showToast(message) {
            var toastContainer = document.getElementById('toastContainer').getElementsByClassName('toast-container')[0];
            var toastId = 'toast' + new Date().getTime(); // Unique ID for each toast
            var toastHtml = `
                <div class="toast" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="2000">
                    <div class="toast-header">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            var toastEl = document.getElementById(toastId);
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        // Group button status update
        function updateStatus(documentId, newStatus) {
            fetch('/document/' + documentId + '/update-status', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
                },
                body: JSON.stringify({ id: documentId, status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (newStatus === 'visible') {
                    document.getElementById('visible-btn-' + documentId).classList.replace('btn-outline-success', 'btn-success');
                    document.getElementById('invisible-btn-' + documentId).classList.replace('btn-danger', 'btn-outline-danger');
                } else {
                    document.getElementById('visible-btn-' + documentId).classList.replace('btn-success', 'btn-outline-success');
                    document.getElementById('invisible-btn-' + documentId).classList.replace('btn-outline-danger', 'btn-danger');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }


    </script>

    <script>
        function viewPdf(pdfUrl, pdfName) {
            fetch(pdfUrl, { method: 'HEAD' })
                .then(response => {
                    if (response.ok) {
                        window.open(pdfUrl, '_blank');
                    } else {
                        showToast('PDF file does not exist.');
                    }
                }).catch(error => {
                    showToast('Error: ' + error.message);
                });
        }

    </script>
  </body>
</html>


