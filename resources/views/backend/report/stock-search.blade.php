<div class="card-body py-1 row">
    <div class="col-12">
        <h6 class="d-inline-block">Total Result found: <span class="badge badge-info">{{$count}}</span></h6>
        <div class="d-inline-block float-right">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped w-100 my-table">
            <thead class="bg-secondary">                  
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Purchase</th>
                <th>Sold</th>
                <th>Stock</th>
                <th>Unit</th>
                <th>Branch</th>
            </thead>
            <tbody>
                @if($count)
                @foreach($customerquery as $index=>$stock)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$stock->getName->display_name}}</td>
                    <td>{{$stock->getName->getCategory->name}}</td>
                    <td>{{$stock->getItem->weight}}</td>
                    <td>{{$stock->qty_sum}}</td>
                    <td>{{$stock->getItem->weight - $stock->qty_sum}}</td>
                    <td>{{$stock->getCalcUnit->name}}</td>
                    <td>{{$customer->getUser->name}}</td>
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