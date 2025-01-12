@extends('layouts.main_layout')

@section('content')
    <div class="container vh-100 d-flex align-items-center" style="margin-top: -3rem;">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">

                    <!-- logo -->
                    <div class="text-center p-3">
                        <img src="assets/images/logo.png" alt="Notes logo">
                    </div>

                    <!-- form -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="{{ route('register.submit') }}" method="post" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control bg-dark text-info" name="username" value="{{ old('username') }}">
                                    {{-- show error --}}
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control bg-dark text-info" name="password">
                                    {{-- show error --}}
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control bg-dark text-info" name="password_confirmation">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-secondary w-100">REGISTER</button>
                                </div>
                            </form>

                            {{-- invalid registration --}}
                            @if(session('registrationError'))
                                <div class="alert alert-danger text-center">
                                    {{ session('registrationError') }}
                                </div>
                            @endif

                            <!-- Login Link -->
                            <div class="text-center mt-3">
                                <small>Already have an account? <a href="{{ route('login') }}">Login here</a></small>
                            </div>
                        </div>
                    </div>

                    <!-- copy -->
                    <div class="text-center text-secondary mt-3">
                        <small>&copy; <?= date('Y') ?> Notes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection