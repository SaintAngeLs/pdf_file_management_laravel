<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CMS Backend Assignment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <title>{{ env('APP_NAME_IN_TITLE') }}</title>
        <style>
            .kartu {
                position: relative;
                display: inline-block;
            }

            .badge {
                position: absolute;
                top: 7px;
                left: 7px;
                background-color: #007bff;
                color: #fff;
                font-weight: bold;
                z-index: 1;
            }
        </style>
    </head>

    <body>
        @include('layouts.navbar')
        <div class="row g-0 ">

            <div class="col-4 ">
                <div style="padding-top: 35px;"></div>
                <div style="padding-left: 35px;">

                    <div class="kartu">
                        <div class="badge bg-primary text-wrap ">
                           {{$documentData->category->name}}
                        </div>
                        <a href="">
                            <img src="{{ route('img.show', ['imageName' => $bookData->image]) }}" class="rounded"style="width: 450px; height: 615px;"
                                alt="...">
                        </a>

                    </div>
                </div>
            </div>

            <div style="max-width:950px">
                <h1 style="padding-top: 2vw;">{{$documentData->title}}</h1>
                @if(Auth::user()->role == 'admin')
                    <h6>Kategori :  <a href="{{ route('user.category.specify', ['user_id'=>$bookData->user_id,'category' => $bookData->category->name]) }}">{{$bookData->category->name}}</a></h6>
                @else
                    <h6>Kategori :  <a href="{{ route('category.specify', ['category' => $bookData->category->name]) }}">{{$bookData->category->name}}</a></h6>
                @endif


                <p>Deskripsi : {{$bookData->description}} </p>
                <a href="{{ route('pdf.show', ['pdfName' => $bookData->pdf]) }}"><button type="button" class="btn btn-dark">Baca</button></a>
                <div class="container">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
    </body>

    </html>
