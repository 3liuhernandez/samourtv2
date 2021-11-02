@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" id="login">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form @submit.prevent="loginForm" id="loginForm">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" autocomplete="email" autofocus>

                                <span class="invalid-feedback d-block" role="alert">{% errors.email %}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" autocomplete="current-password">

                                <span class="invalid-feedback d-block" role="alert">{% errors.password %}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <vue-ladda type="submit" class="btn btn-primary" :loading="loading_submit">Iniciar sesión</vue-ladda>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('appFooter')
<script>
    new Vue({
        el: '#login',
        delimiters: ['{%', '%}'],
        mixins: [mixins],
        data() {
            return {
                loading_submit: false,
                errors: {
                    email: '',
                    password: '',
                }
            }
        },
        methods: {
            /**
             * Registra un usuario
             */
            loginForm(){
                this.loading_submit = true;
                var __data = new FormData(document.getElementById('loginForm'));
                $this = this;
                this.clearValues(this.errors);

                axios
                .post("{{ url('api') }}/login", __data, {
                headers: {
                    "Content-Type": "application/json"
                }
                })
                .then(resp => {
                    const data = resp.data;

                    if (data.success) {
                        $this.$toastr.s(data.message, 'Completado');
                        $this.loading_submit = false;
                        setTimeout(() => {
                            location.href = '{{ url("auth/login/") }}/'+data.body.access_token;
                        }, 1500);
                    } else {
                        throw data;
                    }
                })
                .catch(err => {
                    $this.loading_submit = false;
                    if(!err.hasOwnProperty('errors')){
                        $this.$toastr.e(err.error, 'Ups!');
                    }else{
                        $this.parseErrors($this.errors, err.errors);
                    }

                });
            }
        }
    })
</script>
@endsection
