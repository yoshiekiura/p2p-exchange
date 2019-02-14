<?php

namespace App\Http\Controllers\Admin\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Jackiedo\DotenvEditor\DotenvEditor;

class TranslationController extends Controller
{
    /**
     * @var DotenvEditor
     */
    protected $editor;

    /**
     * GeneralController constructor.
     *
     * @param DotenvEditor $editor
     * @throws \Exception
     */
    public function __construct(DotenvEditor $editor)
    {
        $this->editor = $editor;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $keys = collect($this->environment())->keys()->toArray();

        $env = $this->editor->getKeys($keys);

        return view('admin.platform.translation.index')
            ->with(compact('env'));
    }

    /**
     * Update general configurations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $environment = collect($this->environment())
            ->intersectByKeys($request->all());

        $rules = $environment->mapWithKeys(function ($value, $key) {
            return [$key => $value['rules']];
        });

        $this->validate($request, $rules->toArray());

        $values = $environment->map(function ($value, $key) use ($request) {
            $data = [
                'key'   => $key,
                'value' => $request->get($key)
            ];

            if (isset($value['save'])) {
                $data = [
                    'key'   => $key,
                    'value' => $value['save']($request)
                ];
            }

            return $data;
        });

        $this->editor->setKeys($values->toArray());
        $this->editor->save();

        $message = __("Your settings has been updated!");

        return success_response($request, $message);
    }

    /**
     * Define environment properties
     *
     * @return array
     */
    private function environment()
    {
        return [
            'APP_LOCALE' => [
                'rules' => [
                    'required', Rule::in(array_keys(getAvailableLocales()))
                ],
            ],
        ];
    }
}
