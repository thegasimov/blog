@extends('layouts.guest')

@section('content')
    <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                <div class="text-center mt-4">
                    <h1 class="h2">Xoş gəlmişsiniz</h1>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="m-sm-4">


                            <form action="{{ route('login.post') }}" method="POST">
                                @csrf

                                <x-input-error :messages="$errors->all()" />

                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input id="email" class="form-control form-control-lg" type="email" name="email" :value="old('email')" placeholder="E-mail ünvanınızı daxil edin..." required autofocus />
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Şifrə</label>
                                    <input id="password" class="form-control form-control-lg" type="password" name="password" placeholder="Şifrənizi daxil edin..." required autocomplete="current-password" />
                                </div>

                              {{--
                                <div class="mb-3">
                                    <label class="form-check align-items-center">
                                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                        <span class="ml-2">Hesabıma girişi aktiv saxla</span>
                                    </label>
                                </div>
                              --}}

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-lg btn-success"><i class="fas fa-check"></i> Giriş et</button>

                                {{--
                                <hr>
                                    <p class="mt-4">Hesabınız yoxdur? İndi <a class="btn btn-sm btn-outline-primary" href="{{ route('register') }}">Qeydiyyatdan keç</a></p>
                                    <p class="mb-0"><a href="{{ route('password.request') }}">Şifrəni unutmusan?</a></p>

                             --}}

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
