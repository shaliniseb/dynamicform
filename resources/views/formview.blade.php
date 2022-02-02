@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center p-3 ">
            <div id="formElemts">
                @empty($formData)
                    @foreach ($formData as $items)
                        <div class="row">
                            <div class="col">
                                <label class="form-label">{{ $items->label_name }}</label>
                                @if ($items->element_type == 'select')
                                    <select id="" name="" class="form-select">
                                        @php $options = explode(',', $items->default_values) @endphp
                                        @foreach ($options as $value)
                                            <option value="{{ $value }}">{{ $value }} </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="{{ $items->element_type }}" class="form-control" name="" id=""
                                        value="{{ $items->default_values }}">
                                @endif
                    @endforeach
                @else
                    <p class="bg-danger text-white p-1">No form found</p>
                    <a href="{{ url('addform') }}">Add Form</a>
                @endempty
            </div>
        </div>
    </div>
@endsection
