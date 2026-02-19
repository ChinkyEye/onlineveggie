@extends('backend.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"></h3>
        <button type="button" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#exampleModal">
            Add Branch
        </button>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <input type="hidden" name="_token" class="token" value="{{ csrf_token() }}">
        <div class="table-resposive">
            <table class="table table-bordered table-hover table-striped w-100 my-table">
                <thead class="bg-secondary"> 
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Created At</th>
                    </tr>                 
                </thead>
                <tbody>
                    @foreach($branches as $index=>$branch)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$branch->name}}</td>
                        <td>{{date('D, j M Y', strtotime($branch->created_at))}} <span class="badge badge-success">{{$branch->created_at->diffForHumans()}}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h4 class="modal-title text-capitalize">{{str_replace('-',' ',Route::currentRouteName())}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" method="POST" action="{{route('admin-create-branch-store')}}">
                <div class="modal-body">
                    <!-- form start -->
                    <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" class="form-control" name="name" id="name" placeholder="Enter branch name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Now!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

@endsection