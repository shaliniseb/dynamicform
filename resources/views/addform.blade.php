@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center p-3 ">
            <h4 class="text-center p-3">Create Form</h4>
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
            @endif
            <input type="button" class="btn btn-primary col-md-2" id="addElem" value="Add Element">
            <div id="formDiv" class="p-3">
                <form name="saveForm" method="POST" action="addform">
                    @csrf
                    <input type="hidden" id="incrementer" name="incrementer" value="0">
                    <input type="hidden" id="totalEmenCount" name="totalEmenCount" value="0">
                    <div class="col-md-6">
                        <label class="form-label">Form Name</label>
                        <input type="text" required class="form-control" name="formName" id="formName"
                            placeholder="Form name">
                        @error('formName')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="formElemts">
                    </div>
                    <button type="login" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script>

        //On button click add element to form
        $("#addElem").click(function() {
            let incrementer = parseInt($('#incrementer').val()) + 1;
            let totalEmenCount = parseInt($('#totalEmenCount').val()) + 1;
            let elemtList = '<div class="row" id="element_' + incrementer + '">' +
                '<div class="col">' +
                '<label class="form-label">Label Name</label>' +
                '<input required type="text" class="form-control" name="labelname_' + incrementer +
                '"  id="labelname_' +
                incrementer + '" placeholder="Label name">' +
                '</div>' +
                '<div class="col">' +
                '<label class="form-label">Input Type</label>' +
                '<select required id="inputType_' + incrementer + '" name="inputType_' + incrementer +
                '" class="form-select">' +
                '<option selected>Choose...</option>' +
                '<option value="text">Input Text</option>' +
                '<option value="number">Input Number</option>' +
                '<option value="password">Input Password</option>' +
                '<option value="select">Input Select</option>' +
                '</select>' +
                '</div>' +
                '<div class="col" id="selValOption_' + incrementer + '">' +
                '<label class="form-label">Enter comma separated values</label>' +
                '<textarea id="selectItems_' + incrementer + '" name="selectItems_' + incrementer +
                '" class="form-control"></textarea>' +
                '</div>' +
                '<div class="col">' +
                '<label class="form-label btn btn-danger" id="deleteItem_' + incrementer +
                '" onclick="deleteItem(' +
                incrementer + ')">Delete</label>' +
                '</div>' +
                '</div>';
            $('#formElemts').append(elemtList);
            $('#incrementer').val(incrementer);
            $('#totalEmenCount').val(totalEmenCount);

        });

        //remove element from form
        deleteItem = (itemId) => {
            $("#element_" + itemId).remove();
        }
    </script>
@endsection
