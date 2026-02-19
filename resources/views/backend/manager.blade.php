@extends('backend.app')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"></h3>
        <button type="button" class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#exampleModal">
            Add Manager
        </button>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
        @foreach($managers as $index=>$unit)
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$unit->getBranch->name}}</h3>
                <p>{{$unit->name}}</p>
                <p>{{$unit->created_at->diffForHumans()}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
              <a href="{{route('manager-index',$unit->id)}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endforeach
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
                <form role="form" method="POST" action="{{route('admin-create-manager-store')}}">
                <div class="modal-body">
                <!-- form start -->
                    <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="name">Name: </label>
                        <input type="name" class="form-control" name="name" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address: </label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone No: </label>
                        <input type="text" class="form-control" name="phone_no" id="phone" placeholder="Enter Pnone no">
                    </div>
                    <div class="form-group">
                        <label for="phone">Address: </label>
                        @foreach($addresses as $add=>$address)
                        <select class="form-control" name="address_id">
                            <option value="{{$address}}">{{$add}}</option>
                        </select>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="phone">Branch: </label>
                        <select class="form-control" name="branch_id">
                        @foreach($branches as $bra=>$branch)
                            <option value="{{$branch}}">{{$bra}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Register Now!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

@endsection