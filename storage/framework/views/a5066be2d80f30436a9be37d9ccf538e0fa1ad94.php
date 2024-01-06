<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(env('APP_NAME_IN_TITLE')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-lg">
    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if($documentCount == 0): ?>
    <center>
      <p style="padding-top: 40vh;">"No documents has been added"</p>
      <a class="btn btn-primary" href="<?php echo e(route('document.add')); ?>">Add document</a>
    </center>
    <?php else: ?>
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
            <?php $__currentLoopData = $documentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>
                <td><?php echo e($document->id); ?></td>
                <td><?php echo e($document->title); ?></td>
                <td><?php echo e($document->upload_date); ?></td>
                <td><?php echo e($document->pdf); ?></td>

                <td>
                    <div class="btn-group" role="group" aria-label="Status update">
                        <button type="button" id="visible-btn-<?php echo e($document->id); ?>" class="btn btn-sm <?php echo e($document->status ? 'btn-success' : 'btn-outline-success'); ?> btn-sm" onclick="updateStatus('<?php echo e($document->id); ?>', 'visible')">Visible</button>
                        <button type="button" id="invisible-btn-<?php echo e($document->id); ?>" class="btn btn-sm <?php echo e(!$document->status ? 'btn-danger' : 'btn-outline-danger'); ?> btn-sm" onclick="updateStatus('<?php echo e($document->id); ?>', 'invisible')">Invisible</button>
                    </div>
                </td>
                <!-- <?php echo e($document->status); ?> -->

                <!-- <td><?php echo e($document->status ? 'Visible' : 'Invisible'); ?></td> -->

                <td>
                    <a class="btn btn-dark btn-sm" href="#" onclick="viewPdf('<?php echo e(route('pdf.show', ['pdfName' => $document->pdf])); ?>', '<?php echo e($document->pdf); ?>')">View PDF</a>
                    <button class="btn btn-success btn-sm"  onclick="copyToClipboard('<?php echo e(route('article.view', ['hash' => $document->hash])); ?>')">Copy Link</button>
                    <a class="btn btn-primary btn-sm" href="<?php echo e(route('document.edit', ['documentId' => $document->id])); ?>">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo e($document->id); ?>">
                        Delete
                    </button>

                </td>

                <!-- <td>

                    <form action="<?php echo e(route('document.update.status', $document->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <select name="status" onchange="this.form.submit()">
                            <option value="visible" <?php echo e($document->status ? 'selected' : ''); ?>>Visible</option>
                            <option value="invisible" <?php echo e(!$document->status ? 'selected' : ''); ?>>Invisible</option>
                        </select>
                    </form>
                </td> -->

<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="exampleModal<?php echo e($document->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Remove "<?php echo e($document->title); ?>" document</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete the document <?php echo e($document->title); ?>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form method="POST" action="<?php echo e(route('document.delete')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id"
                value="<?php echo e($document->id); ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        </div>
      </div>
    </div>
  </div>
                </td>
              </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          </tbody>
        </table>
      </div>
      <?php endif; ?>
      <div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('Link is copied to clipboard');
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // CSRF token for Laravel
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
        function viewPdf(url, pdfName) {
            fetch(url, { method: 'HEAD' })
                .then(response => {
                    if (response.ok) {
                        window.open(url, '_blank');
                    } else {
                        showToast('PDF file does not exist.');
                    }
                }).catch(error => {
                    showToast('Error checking PDF file: ' + error);
                });
        }

    </script>

  </body>
</html>



<?php /**PATH /home/kaliuser/Documents/portfolio/a_work/bridge_test/pdf-management-system/resources/views/user/documents/index.blade.php ENDPATH**/ ?>