<div class="card-body py-1 row">
    <div class="col-12">
        <h6 class="mr-3 d-inline-block">Total Result found: <span class="badge badge-info">{{$count}}</span></h6>
        @if($date)<h6 class="d-inline-block">Search for: {{$req_to}}</h6>@endif
        <div class="d-inline-block float-right">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped w-100 my-table">
            <thead class="bg-secondary">                  
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Bill ID</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Due</th>
                <th>Grand Total</th>
                <th>Created By</th>
                <th>Created At</th>
            </thead>
            <tbody>
                @if($count)
                    @foreach($customerquery as $index=>$customer)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$customer->getCustomer->name}}</td>
                        <td><a href="{{route('print_bill',$customer->bill_id)}}">{{$customer->bill_id}}</a></td>
                        <td>{{$customer->total}}</td>
                        <td>{{$customer->discount}}</td>
                        <td>{{$customer->due}}</td>
                        <td>{{$customer->grand_total}}</td>
                        <td>{{$customer->getUser->name}}</td>
                        <td>{{date('D, j M Y', strtotime($customer->created_at))}}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-bold text-danger">No result found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>