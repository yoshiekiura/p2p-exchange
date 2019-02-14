@if(config()->get('services.nocaptcha.enable'))
    <div class="text-center">
        @if(config()->get('services.nocaptcha.type') != 'invisible')
            {!! NoCaptcha::display(); !!}

            @php $attribute = array_merge($button['attributes'], ['type' => 'submit']);@endphp

            {!! Form::button($button['title'], $attribute); !!}
        @else
            {!! NoCaptcha::displaySubmit('auth-form', $button['title'], $button['attributes']) !!}
        @endif

        @push('scripts')
            {!! NoCaptcha::renderJs() !!}
        @endpush
    </div>
@else
    @php
        $attribute = array_merge($button['attributes'], ['type' => 'submit']);
    @endphp

    {!! Form::button($button['title'], $attribute); !!}
@endif
