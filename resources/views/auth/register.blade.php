@extends('auth.layouts.master')
@section('page.name', __('Register'))
@section('page.body')
    <div class="content-body">

        <section class="login-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-xl-4 col-md-6 col-12 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                        <div class="card-header border-0">
                            <div class="card-title text-center">
                                <a href="{{url('/')}}">
                                    <img src="{{asset('images/logo/logo-dark.png')}}" alt="branding logo">
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                <span>{{__('Register')}}</span>
                            </p>
                            <div class="card-body">
                                @include('auth.includes.alerts')
                                {!! Form::open(['route' => 'register', 'method' => 'POST', 'class' => 'form-horizontal',  'id' => 'auth-form', 'novalidate' => true]) !!}

                                <fieldset class="form-group my-2 position-relative has-icon-left {{ $errors->has('name') ? 'error' : '' }}">
                                    {!! Form::text('name', null, ['class' => 'round form-control', 'placeholder' => __('Username'), 'data-validation-regex-regex' => '^[a-zA-Z0-9_-]{3,15}$', 'required' => true]) !!}
                                    <div class="form-control-position"><i class="ft-user"></i></div>
                                </fieldset>

                                <fieldset class="form-group my-2 position-relative has-icon-left {{ $errors->has('email') ? 'error' : '' }}">
                                    {!! Form::email('email', null, ['class' => 'round form-control', 'placeholder' => __('Email Address'), 'required' => true]) !!}
                                    <div class="form-control-position"><i class="ft-mail"></i></div>
                                </fieldset>

                                <fieldset class="form-group my-2 position-relative has-icon-left {{ $errors->has('password') ? 'error' : '' }}">
                                    {!! Form::password('password', ['class' => 'round form-control', 'placeholder' => __('Password'), 'required' => true]) !!}
                                    <div class="form-control-position"><i class="ft-lock"></i></div>
                                </fieldset>

                                <fieldset class="form-group my-2 mb-3 position-relative has-icon-left {{ $errors->has('password') ? 'error' : '' }}">
                                    {!! Form::password('password_confirmation', ['class' => 'round form-control', 'placeholder' => __('Verify Password'),
									'data-validation-matches-match' => 'password', 'required' => true]) !!}
                                    <div class="form-control-position"><i class="ft-lock"></i></div>
                                </fieldset>

                                @include('auth.includes.nocaptcha', [
									'button' => [
										'title'         => '<i class="ft-user"></i> '. __('Register'),
										'attributes'    => ['class' => 'btn btn-success round btn-block']
									]
								])

                                {!! Form::close(); !!}
                            </div>
                            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                <span>{{__('Already have an account?')}}</span>
                            </p>
                            <div class="card-body">
                                <a href="{{route('login')}}" class="btn btn-outline-info round btn-block">
                                    <i class="ft-unlock"></i> {{__('Login')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
