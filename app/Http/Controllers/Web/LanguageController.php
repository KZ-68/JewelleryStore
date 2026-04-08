<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{

    public function postChangeLanguage(Request $request) : \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $languagesAvailable = config('app.available_locales');

        $rules = [
            'language' => "in:$languagesAvailable"
        ];

        $language = $request->input('locale');
        $validator = Validator::make(compact($language),$rules);

        if($validator->passes())
        {
            Session::put('locale',$language);
            App::setLocale($language);
            return redirect(URL::previous());
        } else {
            return redirect(URL::previous());
        }
    }
}