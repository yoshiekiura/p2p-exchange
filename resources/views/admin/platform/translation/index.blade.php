@extends('admin.layouts.master')
@section('page.name', __('Translation'))
@section('page.body')
    <admin-platform-translation-page inline-template>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">
                        {{__('Translation')}}
                    </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            {{ Breadcrumbs::render('admin.platform.translation') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header border-top-primary">
                                <h4 class="card-title">
                                    {{__('Locale Setup')}}
                                </h4>
                            </div>

                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['class' => 'form form-horizontal']) !!}
                                    <div class="form-body">
                                        <div class="bs-callout-success callout-border-left mb-1 p-1">
                                            <p class="card-text">
                                                <b>{{__('Upcoming!')}}</b> {{__('Ability to edit phrases manually will be made available in future updates!')}}
                                            </p>
                                        </div>

                                        <div class="form-group row">
                                            {!! Form::label('APP_LOCALE', __('Select Locale'), ['class' => 'col-md-3']) !!}
                                            <div class="col-md-9">
                                                {!! Form::select('APP_LOCALE', getAvailableLocales(), $env['APP_LOCALE']['value'], ['is' => 'select2', 'class' => 'form-control', 'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions right">
                                        <button type="submit" class="btn ladda-button btn-success">
                                            <i class="la la-check-square-o"></i> {{__('Save')}}
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </admin-platform-translation-page>
@endsection
