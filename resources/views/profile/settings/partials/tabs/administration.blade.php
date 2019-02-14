@can('edit user role')
    <div class="card border-top-primary">
        <div class="card-head ">
            <div class="card-header">
                <h4 class="card-title">{{__('UPDATE ROLE')}}</h4>
            </div>
        </div>

        <div class="card-content">
            <div class="card-body">

                {!! Form::open(['url' => route('profile.settings.update-role', ['user' => $user->name]), 'class' => 'form form-horizontal', 'method' => 'POST']) !!}

                <div class="form-body">
                    <div class="form-group row">
                        {!! Form::label('role', 'ROLE', ['class' => 'col-md-3 text-bold-600']) !!}

                        <div class="col-md-9">
                            {!! Form::select('role[]', \App\Models\Role::all()->pluck('name', 'name'), $user->getRoleNames(), ['multiple' => true, 'is' => 'select2', 'html-class' => 'form-control']) !!}

                            <small class="help-block">
                                {{__('Please exercise CAUTION while making changes to the user role. You will only be allowed to update user role if the priority of their current role is less than yours.')}}
                            </small>
                        </div>

                    </div>
                </div>

                <div class="form-actions right">
                    <button type="submit" class="btn btn-primary ladda-button">
                         {{__('UPDATE')}}
                    </button>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endif


<div class="card border-top-primary">
    <div class="card-head ">
        <div class="card-header">
            <h4 class="card-title">{{__('MODERATION ACTIVITIES')}}</h4>
            <a class="heading-elements-toggle">
                <i class="la la-ellipsis-h font-medium-3"></i>
            </a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li>
                        <a data-action="reload">
                            <i class="ft-rotate-cw"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table id="moderation-activities" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                    <thead>
                    <tr>
                        <th></th>
                        <th class="all">{{__('Moderator')}}</th>
                        <th class="all">{{__('Activity')}}</th>
                        <th>{{__('Comment')}}</th>
                        <th>{{__('Date')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="all">{{__('Moderator')}}</th>
                        <th class="all">{{__('Activity')}}</th>
                        <th>{{__('Comment')}}</th>
                        <th>{{__('Date')}}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

