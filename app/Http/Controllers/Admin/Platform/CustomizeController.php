<?php

namespace App\Http\Controllers\Admin\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomizeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.platform.customize.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $message = __('Platform settings was updated!');

        platformSettings()->update([
            'template' => $request->template,
            'theme_color' => $request->theme_color,
            'style' => $request->style
        ]);

        return success_response($request, $message);
    }
}
