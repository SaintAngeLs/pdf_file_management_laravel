@extends('layouts.app')

@section('content')
    <div class="container"
        style="position: absolute;
    left: 50%;
    top: 45%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%); max-width:500px">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name">{{ __('Name') }}</label>

                <div class="md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email">{{ __('Email Address') }}</label>

                <div class="md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- <div class="mb-3">
                <div class="form-group row">
                    <label for="date_of_birth" >Date of Birth</label>

                    <div class="col">
                        <input id="date_of_birth" type="date"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            name="date_of_birth" value="{{ old('date_of_birth') }}" required
                            autocomplete="date_of_birth" autofocus>

                        @error('date_of_birth')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
            </div> -->

            <div class="mb-3">
                <label for="password">{{ __('Password') }}</label>

                <div class="md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                <div class="md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password">
                </div>
            </div>

                    <button type="submit" class="btn btn-dark">
                        {{ __('Register') }}
                    </button>

        </form>

    </div>
@endsection


