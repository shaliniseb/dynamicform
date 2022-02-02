<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormList;
use App\Models\ElementList;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

/**
 * Add form and form elemnts to the database
 */
    function create(Request $request)
    {
        $validatedData = $request->validate([
            'formName' => 'required',
        ], [
            'formName.required' => 'Name is required',
        ]);

        $count = $request->input('incrementer');
        $formL = new FormList();
        $formL->form_name = $request->input('formName');
        $formL->save();

        //If there is any elements then add those elements to db
        if ($count > 0) {
            for ($i = 1; $i <= $count; $i++) {
                $elemtList = new ElementList();
                if ($request->has('labelname_' . $i)) {
                    $elemtList->label_name = $request->input('labelname_' . $i);
                }
                if ($request->has('inputType_' . $i)) {
                    $elemtList->element_type = $request->input('inputType_' . $i);
                }
                if ($request->has('selectItems_' . $i)) {
                    $elemtList->default_values = $request->input('selectItems_' . $i);
                }
                $elemtList->form_id = $formL->id;
                $elemtList->save();
            }
        }
        return back()->with('success', 'Form saved successfully.');
    }

    /**
     * fetch all forms and display
     */
    function lists()
    {
        $data = FormList::all();
        return view('formlist', ['formList' => $data]);
    }

    //Edit form - fill form with exististing data
    function editForm($formId)
    {
        $form =  DB::table('form_lists')->where('id', $formId)->get();
        $data =  DB::table('element_lists')->where('form_id', $formId)->get();
        return view('editform', ['formData' => $data, 'form' => $form]);
    }

    /**
     * @desc delete form element using js call
     */
    public function deleteElement(Request $request)
    {
        $res = ElementList::where('id', $request['elementid'])->delete();
        return response()->json(['success' => 'Successfully removed element']);
    }

    /**
     * @desc update form content
     */
    function updateForm(Request $request)
    {
        $count = $request->input('incrementer');
        $formId = $request->input('formId');
        $formL = FormList::find($request->input('formId'));
        $formL->form_name = $request->input('formName');
        $formL->update();

        //Add new items
        if ($count > 0) {
            for ($i = 1; $i <= $count; $i++) {
                $elemtList = new ElementList();
                if ($request->has('nlabelname_' . $i)) {
                    $elemtList->label_name = $request->input('nlabelname_' . $i);
                }
                if ($request->has('ninputType_' . $i)) {
                    $elemtList->element_type = $request->input('ninputType_' . $i);
                }
                if ($request->has('nselectItems_' . $i)) {
                    $elemtList->default_values = $request->input('nselectItems_' . $i);
                }
                $elemtList->form_id = $formId;
                $elemtList->save();
            }
        }

        //Update already existing items
        $elementIds = ElementList::where('form_id', '=', $formId)->pluck('id')->all();
        foreach ($elementIds as $elemtId) {
            $elemtList =  ElementList::find($elemtId);
            if ($request->has('labelname_' . $elemtId)) {
                $elemtList->label_name = $request->input('labelname_' . $elemtId);
            }
            if ($request->has('inputType_' . $elemtId)) {
                $elemtList->element_type = $request->input('inputType_' . $elemtId);
            }
            if ($request->has('selectItems_' . $elemtId)) {
                $elemtList->default_values = $request->input('selectItems_' . $elemtId);
            }
            $elemtList->form_id = $formId;
            $elemtList->update();
        }
        return back()->with('success', 'Form updated successfully.');
    }
}
