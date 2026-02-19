@extends('frontend.app')
@section('content')
@include('frontend.header');
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">Change Password</h3>
            </div>
            <!-- /.card-header -->
            <form action="{{ route('change-password-store')}}" id="" method="POST">
                <div class="card-body">
                    <input type="hidden" name="_token" class="token" value="{{csrf_token()}}">
                    <div class="form-group row">
                        <label for="old-password" class="col-sm-3 text-right control-label col-form-label">Old Password</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" id="old-password" placeholder="Enter Old Password" autocomplete="off" name="old_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new-password" class="col-sm-3 text-right control-label col-form-label">New Password</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" id="new-password" placeholder="Enter New Password" autocomplete="off" name="new_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirm" class="col-sm-3 text-right control-label col-form-label">Confirm New</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" id="confirm" placeholder="Enter Confirm New Password" autocomplete="off" name="confirm_password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-md-3 col-md-6">
                            <button type="Submit" id="Submit" value="Submit" class="btn btn-block btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection