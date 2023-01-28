@extends('adminlte::page')

@section('title', 'Customers')

@section('content_header')
<h1>
    Customers
</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success float-right" href="{{ route('customer.create') }}">
	                        <i class="far fa-user">
	                        </i>
	                        Add
	                    </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Secret Code
                                    </th>
                                    <th>
                                        Phone
                                    </th>
                                    <th>
                                        Locale
                                    </th>
                                    <th>
                                        Messages
                                    </th>
                                    <th>
                                        Contacts
                                    </th>
                                    <th>
                                        Calls
                                    </th>
                                    <th>
                                        Files
                                    </th>
                                    <th>
                                        Transactions
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
    </div>
</section>
<!-- /.card-body -->
<!-- /.card -->
<!-- /.col -->
<!-- /.row -->
<!-- /.container-fluid -->
@stop


@section('plugins.Datatables', true)

@section('js')
<script src="{{ asset('pages/customer_index.js') }}"></script>
@stop