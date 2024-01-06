<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(env('APP_NAME_IN_TITLE')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            padding-top: 20px;
            background-color: #f8f9fa;
        }
        .pdf-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .pdf-container canvas {
            border: none;
            display: block;
            margin: 0 auto;
            padding: 0;

        }
        .navigation-arrows {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .arrow {
            color: #FFD932;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .arrow:hover {
            transform: scale(1.1);
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf_viewer.min.css" rel="stylesheet">
</head>
<body>
    <?php echo $__env->make('layouts.navbarnoauth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- <a href="https://en.bridge.pl/"><img src="/path/to/bridge-logo.png" alt="Bridge Logo"></a> -->

    <!-- PDF Embed -->
    <!-- <embed src="<?php echo e($pdfUrl); ?>" type="application/pdf" width="100%" height="600px" /> -->
    <div class="container">
        <!-- PDF Embed -->
        <!-- <div class="pdf-container">
            <embed src="<?php echo e($pdfUrl); ?>" style="width:100%; height:600px; border: none;" allowfullscreen></embed>
        </div> -->
        <div class="pdf-container" id="pdf-container" style="overflow-y: auto;">
            <canvas id="pdf-canvas" style=" box-sizing:border-box;"></canvas>
        </div>

        <div class="navigation-arrows">
            <?php if($previousHash && $previousDocument && $previousDocument->status): ?>
                <a href="<?php echo e(route('article.view', ['hash' => $previousHash])); ?>" class="arrow">&#9664;Previous</a>
            <?php endif; ?>
            <?php if($nextHash && $nextDocument && $nextDocument->status): ?>
                <a href="<?php echo e(route('article.view', ['hash' => $nextHash])); ?>" class="arrow">&#9654;Next</a>
            <?php endif; ?>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var url = '<?php echo e($pdfUrl); ?>'; // URL of the PDF file
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';

        var pdfDoc = null,
            pageNum = 1,
            pdfContainer = document.getElementById('pdf-container');

        function renderPage(num) {
            pdfDoc.getPage(num).then(function(page) {
                var containerWidth = pdfContainer.clientWidth;
                var viewport = page.getViewport({scale: 1.5});
                var scale = containerWidth / viewport.width;
                var scaledViewport = page.getViewport({scale: scale});


                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                canvas.height = scaledViewport.height;
                canvas.width = scaledViewport.width;

                canvas.style.width = '100%';
                canvas.style.height = '100%';

                var renderContext = {
                    canvasContext: ctx,
                    viewport: scaledViewport
                };
                page.render(renderContext).promise.then(function() {
                    pdfContainer.appendChild(canvas);
                    if (pageNum <= pdfDoc.numPages) {
                        pageNum++;
                        renderPage(pageNum);
                    }
                });
            });
        }

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            renderPage(pageNum);
        }).catch(function(error) {
            console.error('Error loading PDF: ', error);
        });

    </script>

</body>
</html>
<?php /**PATH /home/kaliuser/Documents/portfolio/a_work/bridge_test/pdf-management-system/resources/views/articles/article.blade.php ENDPATH**/ ?>