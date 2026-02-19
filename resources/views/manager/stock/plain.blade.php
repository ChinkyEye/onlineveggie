@extends('manager.app')
@section('content')
<style type="text/css">
    table, tr, td, thead, tbody {display: block!important;}
    tr {float: left!important; width: 50%!important;}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center my-md-0 font-weight-bold float-none text-danger">Price List of Grocery Items, Vegetables and Fruits on : {{date('d M, Y')}}</div>
            </div>
            <div class="card-body">
                    <div class="col-md-12">
                        <table class="table">
                            <!-- <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Unit</th>
                                </tr>
                            </thead> -->
                            <tbody>
                    @foreach($data_lists as $index=>$list)
                                <tr><td><span class="text-info">{{$list->getName->display_name}}</span><span class="text-danger"> Rs: {{$list->getPurchaseMinLatestI->rate}}</span> / <span class="text-warning">{{$list->getPurchaseMinLatestI->getUnit->name}}</span></td></tr>
                    @endforeach
                            </tbody>
                        </table>
                        <!-- <div class="card">
                            <div class="card-footer text-center p-0">
                                <h6 class="bg-gray-dark color-palette py-1 m-0">{{$list->getName->display_name}}</h6>
                                <p class="m-0 py-1 text-danger font-weight-bold">Rs. {{$list->getPurchaseMinLatestI->rate}} / {{$list->getPurchaseMinLatestI->getUnit->name}}</p>
                            </div>
                        </div> -->
                    </div>    
            </div>
                        {!! $data_lists->links("pagination::bootstrap-4") !!}
        </div>
    </div>
</div>
@endsection