@extends('adminlte::page')

@section('title', 'Call Logs')

@section('content_header')
<h1>
    Customer Call Logs
</h1>
@stop

@section('css')
<link href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <style type="text/css">
        #mytable td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 100%;
        }
    </style>
    @stop

@section('content')
<section class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Call Logs
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="mytable">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                                <th class="{{ $customer_id ?? 'd-none' }}">
                                    Customer
                                </th>
                                <th>
                                    Number
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Time
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('plugins.Datatables', true)

@section('js')
    <script>
        var customer_id = "{{ $customer_id ?? 'all' }}"
    </script>
    <script src="{{ asset('pages/calls_index.js') }}">
    </script>
    @stop
</link>