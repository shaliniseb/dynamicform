@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center p-3 ">
            <h4 class="text-center p-3">Edit Form</h4>
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
                <form name="editForm" method="POST" action="{{ route('form.edit') }}">
                    @csrf
                    <input type="hidden" id="incrementer" name="incrementer" value="0">
                    <input type="hidden" id="totalEmenCount" name="totalEmenCount" value="{{ count($formData) }}">
                    <input type="hidden" id="formId" name="formId" value="{{ $form[0]->id }}">

                    <div class="col-md-6">
                        <label class="form-label">Form Name</label>
                        <input type="text" class="form-control" name="formName" id="formName" placeholder="Form name"
                            value="{{ $form[0]->form_name }}">
                        @error('formName')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="formElemts">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($formData as $elements)

                            @php
                                $i++;
                            @endphp
                            <div class="row" id="element_{{ $i }}">
                                <div class="col">
                                    <label class="form-label">Label Name</label>
                                    <input type="text" class="form-control" name="labelname_{{ $elements->id }}"
                                        id="labelname_{{ $elements->id }}" placeholder="Label name"
                                        value="{{ $elements->label_name }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Input Type</label>
                                    <select required id="inputType_{{ $elements->id }}"
                                        name="inputType_{{ $elements->id }}" class="form-select" required>
                                        <option value="">Choose...</option>
                                        <option value="text" @if ($elements->element_type == 'text')
                                            selected
                        @endif >Input Text</option>
                        <option value="number" @if ($elements->element_type == 'number')
                            selected
                            @endif >Input Number</option>
                        <option value="password" @if ($elements->element_type == 'password')
                            selected
                            @endif >Input Password</option>
                        <option value="select" @if ($elements->element_type == 'select')
                            selected
                            @endif >Input Select</option>

                        </select>
                    </div>
                    <div class="col" id="selValOption">
                        <label class="form-label">Enter comma separated values</label>
                        <textarea id="selectItems_{{ $elements->id }}" name="selectItems_{{ $elements->id }}"
                            class="form-control">{{ $elements->default_values }}</textarea>
                    </div>
                    <div class="col">
                        <label class="form-label btn btn-danger" id="deleteItem_{{ $elements->id }}"
                            onclick="deleteItemDb({{ $i }},{{ $elements->id }})">Delete</label>
                    </div>
            </div>
            @endforeach
        </div>
        <button type="login" class="btn btn-primary">Save</button>
        </form>
    </div>
    </div>
    </div>
    <script>
        //On button click generate form element
        $("#addElem").click(function() {
            let incrementer = parseInt($('#incrementer').val()) + 1;
            let totalEmenCount = parseInt($('#totalEmenCount').val()) + 1;
            let elemtList = '<div class="row" id="nelement_' + incrementer + '">' +
                '<div class="col">' +
                '<label class="form-label">Label Name</label>' +
                '<input type="text" class="form-control" name="nlabelname_' + incrementer + '"  id="nlabelname_' +
                incrementer + '" placeholder="Label name" required>' +
                '</div>' +
                '<div class="col">' +
                '<label class="form-label">Input Type</label>' +
                '<select required id="ninputType_' + incrementer + '" name="ninputType_' + incrementer +
                '" class="form-select">' +
                '<option selected value="">Choose...</option>' +
                '<option value="text">Input Text</option>' +
                '<option value="number">Input Number</option>' +
                '<option value="password">Input Password</option>' +
                '<option value="select">Input Select</option>' +
                '</select>' +
                '</div>' +
                '<div class="col" id="selValOption_' + incrementer + '">' +
                '<label class="form-label">Enter comma separated values</label>' +
                '<textarea id="nselectItems_' + incrementer + '" name="nselectItems_' + incrementer +
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // delete entry from table
        deleteItemDb = (itemId, elemetId) => {
            $.ajax({
                type: 'POST',
                url: "{{ route('deleteItem.post') }}",
                data: {
                    elementid: elemetId
                },
                success: function(data) {
                    alert(data.success);
                    $("#element_" + itemId).remove();

                }
            });
            $("#element_" + itemId).remove();

        }

        //remove form element
        deleteItem = (itemId) => {
            $("#nelement_" + itemId).remove();

        }
    </script>
@endsection
