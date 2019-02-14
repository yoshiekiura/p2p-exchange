@extends('auth.layouts.master')
@section('page.name', __('Login'))
@section('page.body')
    <div class="content-body">

        <section class="login-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-xl-4 col-md-6 col-12 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                        <div class="card-header border-0">
                            <div class="card-title text-center">
                                <a href="{{url('/')}}">
                                    <img src="{{config('app.logo_brand') ?: asset('/images/logo/logo-dark.png')}}" alt="branding logo">
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                <span>{{__('Login')}}</span>
                            </p>

                            {!! Form::open(['route' => 'login', 'method' => 'POST', 'class' => 'form-horizontal',  'id' => 'auth-form', 'novalidate' => true]) !!}

                            <div class="card-body">
                                @include('auth.includes.alerts')

                                <fieldset class="form-group my-2 position-relative has-icon-left {{ $errors->has('name') ? 'error' : '' }}">
                                    {!! Form::text('name', null, ['id' => 'name', 'class' => 'round form-control', 'placeholder' => __('Your Username'), 'required' => true]) !!}
                                    <div class="form-control-position"><i class="ft-user"></i></div>
                                </fieldset>

                                <fieldset class="form-group my-2 position-relative has-icon-left {{ $errors->has('password') ? 'error' : '' }}">
                                    {!! Form::password('password', ['class' => 'round form-control', 'placeholder' => __('Enter Password'), 'required' => true]) !!}
                                    <div class="form-control-position"><i class="ft-lock"></i></div>
                                </fieldset>
                            </div>

                            @if($errors->has('token'))
                                <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2">
                                    <span>{{__('Verify your Identity')}}</span>
                                </p>
                                <div class="card-body pb-0">
                                    <fieldset class="form-group position-relative has-icon-left">
                                        {!! Form::text('token', null, ['class' => 'round form-control', 'placeholder' => __('2FA Token'), 'required' => true]) !!}
                                        <div class="form-control-position"><i class="la la-key"></i></div>
                                    </fieldset>
                                </div>
                            @endif

                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col text-center skin-square text-sm-left">
                                        <fieldset>
                                            {!! Form::checkbox('remember', 1, null, ['class' => 'chk-remember']) !!}
                                            <label for="remember"> {{__('Remember Me')}}</label>
                                        </fieldset>
                                    </div>
                                    <div class="col float-sm-left text-center text-sm-right">
                                        <a href="{{route('password.request')}}"
                                           class="card-link">{{__('Forgot Password?')}}</a>
                                    </div>
                                </div>

                                @include('auth.includes.nocaptcha', [
									'button' => [
										'title'         => '<i class="ft-unlock"></i> '. __('Login'),
										'attributes'    => ['class' => 'btn btn-info btn-block round ladda-button', 'id' => 'submit']
									]
								])

                            </div>
                            {!! Form::close(); !!}

                            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                <span>{{__('New to :name?', ['name' => config('app.name')])}}</span>
                            </p>

                            <div class="card-body">
                                <a href="{{route('register')}}" class="btn btn-outline-success round btn-block">
                                    <i class="ft-user"></i> {{__('Register')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

{{--@if($errors->has('token'))--}}
{{--@push('scripts')--}}
{{--<script> document.getElementById('two-factor').style.display = 'block'; </script>--}}
{{--@endpush--}}
{{--@endif--}}


