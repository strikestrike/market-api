@extends('adminlte::page')

@section('title', 'Transactions')

@section('content_header')
<h1>
    Customer Transactions
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
                    <button class="btn btn-success float-right" id="btn_new" type="button">
                        <i class="fa fa-plus">
                        </i>
                        Add
                    </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="mytable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                                <th class="{{ $customer_id ?? 'd-none' }}">
                                    Customer
                                </th>
                                <th>
                                    Transaction ID
                                </th>
                                <th>
                                    Created At
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

<div aria-hidden="true" class="modal fade" id="myModal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Transaction
                </h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="form-group {{ is_numeric($customer_id) && $customer_id > 0 ? 'd-none' : '' }}">
                  <label>Customer</label>
                  <div class="select2-purple">
                    <select class="select2" {{-- multiple="multiple" --}} name="customer_id" id="customer_id" data-placeholder="Select a Customer" data- 
                              dropdown-css-class="select2-purple" style="width: 100%;" value="{{ is_numeric($customer_id) && $customer_id > 0 ? $customer_id : '' }}">
                      @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->secret_code }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                    <label for="transaction_id">Transaction ID</label>
                    <textarea class="form-control" name="transaction_id" id="transaction_id" placeholder="Enter Transaction ID"></textarea>
                </div>
                <div class="invalid-feedback">
                  Please enter Transaction ID.
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Close
                </button>
                <button class="btn btn-primary" type="button" id="btn_save">
                    Save
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        var customer_id = "{{ $customer_id ?? 'all' }}"
    </script>
    <script src="{{ asset('pages/transactions_index.js') }}">
    </script>
    @stop
</link>