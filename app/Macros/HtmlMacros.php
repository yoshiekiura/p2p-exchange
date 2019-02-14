<?php

// Alert...
HTML::macro('alert', function($message = '', $type = 'primary', $icon = '<i class="la la-info-circle"></i>'){
    $alert = '';

    $alert .= "<div class='alert round alert-$type alert-dismissible mb-2' role='alert'>";

    $alert .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>";

    $alert .= $message;

    $alert .= "</div>";

    return $alert;
});
