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
                <th>Vegetable</th>
                <th>Category</th>
                <th>Purchase</th>
                <th>Unit</th>
                <th>Date</th>
                <th>From</th>
            </thead>
            <tbody>
                @if($count)
                @foreach($customerquery as $index=>$purchase)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$purchase->getName->display_name}}</td>
                    <td>{{$purchase->getName->getCategory->name}}</td>
                    <td>{{$purchase->weight}}</td>
                    <td>{{$purchase->getUnit->name}}</td>
                    <td>{{$purchase->date}}</td>
                    <td>{{$purchase->getPurchase->name}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-bold text-danger">No result found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>