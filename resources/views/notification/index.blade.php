@extends('adminlte::page')

@section('title', 'Notification')

@section('content_header')
<h1>
    Notification
</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
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
                        <table class="table table-bordered table-hover" id="mytable">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Notification
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
<div aria-hidden="true" class="modal fade" id="myModal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Notification
                </h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" name="id" id="id">
                <div class="form-group">
                    <label for="notification">Notification</label>
                    <textarea class="form-control" name="notification" id="notification" placeholder="Enter Notification"></textarea>
                </div>
                <div class="invalid-feedback">
                  Please enter notification.
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

@section('js')
<script src="{{ asset('pages/notification_index.js') }}">
</script>
@stop
