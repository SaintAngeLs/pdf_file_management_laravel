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
    <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">email</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($userData as $data)
            <tr>
                <th scope="row">1</th>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>
                    <a href="{{ route('user.documents', ['user_id' => $data->id]) }}" class="btn btn-dark">Documents</a>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
