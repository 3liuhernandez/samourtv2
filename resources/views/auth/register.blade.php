@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" id="register">
                <div class="card-header text-dark">Registro de usuario</div>

                <div class="card-body">
                    <form @submit.prevent="registerForm" id="registerForm">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right text-dark">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>

                                <span class="invalid-feedback d-block" role="alert">{% errors.name %}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right text-dark">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" autocomplete="email">

                                <span class="invalid-feedback d-block" role="alert">{% errors.email %}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right text-dark">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">

                                <span class="invalid-feedback d-block" role="alert">{% errors.password %}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right text-dark">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">

                                <span class="invalid-feedback d-block" role="alert">{% errors.password_confirmation %}</span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <vue-ladda type="submit" class="btn btn-primary" :loading="loading_submit">Registrarse</vue-ladda>
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
        el: '#register',
        delimiters: ['{%', '%}'],
        mixins: [mixins],
        data() {
            return {
                loading_submit: false,
                errors: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                }
            }
        },
        methods: {
            /**
             * Registra un usuario
             */
            registerForm(){
                this.loading_submit = true;
                var __data = new FormData(document.getElementById('registerForm'));
                $this = this;
                this.clearValues(this.errors);

                axios
                .post("{{ url('api') }}/register", __data, {
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
                            location.href = '{{ url('login') }}';
                        }, 1500);
                    } else {
                        throw data;
                    }
                })
                .catch(err => {
                    if(!err.hasOwnProperty('error')){
                        $this.$toastr.e(err.message, 'Ups!');
                    }else{
                        $this.parseErrors($this.errors, err.error);
                    }
                    $this.loading_submit = false;
                });
            }
        }
    })
</script>
@endsection