@if($data->status)
    <a href="{{route('home.offers.toggle', ['token' => $data->token])}}"
       data-swal="confirm-ajax" data-ajax-type="POST" data-icon="warning" class="btn btn-icon btn-sm btn-pure darken-4 danger"
       data-text="{{__("This offer will be disabled and hidden from other users!")}}">
        <i class="ft-power"></i>
    </a>
@else
    <a href="{{route('home.offers.toggle', ['token' => $data->token])}}"
       data-swal="confirm-ajax" data-ajax-type="POST" data-icon="success" class="btn btn-icon btn-sm btn-pure darken-4 success"
       data-text="{{__("This offer will be enabled and shown to other users!")}}">
        <i class="ft-power"></i>
    </a>
@endif

@if($data->status)
    <a href="{{route('home.offers.index', ['token' => $data->token])}}" class="btn btn-icon btn-sm btn-pure primary">
        <i class="ft-eye"></i>
    </a>
@endif

<a href="{{route('home.offers.delete', ['token' => $data->token])}}"
   data-swal="confirm-ajax" data-ajax-type="DELETE" data-icon="error" class="btn btn-icon btn-sm btn-pure secondary"
   data-text="{{__("This offer will be removed from the marketplace!")}}">
    <i class="ft-trash"></i>
</a>
