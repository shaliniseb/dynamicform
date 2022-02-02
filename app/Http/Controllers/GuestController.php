<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormList;
use App\Models\ElementList;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{


    function view($formId)
    {
        $data =  DB::table('element_lists')->where('form_id', $formId)->get();
        return view('formview', ['formData' => $data]);
    }

    function index()
    {
        $data = FormList::all();
        return view('welcome', ['formList' => $data]);
    }

}
