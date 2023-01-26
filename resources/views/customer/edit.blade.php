@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>
    Edit Customer
</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Customer Info
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    @if(session('status'))
                    <div class="alert alert-success mb-1 mt-1">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- form start -->
                    <form action="{{ route('customer.update', ['customer' => $customer->id]) }}" method="post" role="form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group {{ $errors->has('secret_code') ? 'has-error' : ''}}">
                                <label for="secret_code">Secret Code</label>
                                <input class="form-control" name="secret_code" id="secret_code" placeholder="Secret Code" type="text" value="{{ old('secret_code') ? old('secret_code') : $customer->secret_code }}">
                                @error('secret_code')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                                <label for="phone">Phone</label>
                                <input class="form-control" name="phone" id="phone" placeholder="Phone" type="text" value="{{ old('phone') ? old('phone') : $customer->phone }}">
                                @error('phone')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="active" type="checkbox" value="{{ old('active') ? old('active') : $customer->active }}"
                                        {{ (old('active') ? old('active') : $customer->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                                @error('active')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Save</button>
                            <a class="btn btn-default ml-2" href="{{ route('customer.view') }}"> Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop


@section('js')
<script>
    console.log('Hi!');
</script>
@stop

