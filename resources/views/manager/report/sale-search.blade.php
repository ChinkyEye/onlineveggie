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
                <th>Sold</th>
                <th>Unit</th>
            </thead>
            <tbody>
            @if($count)
                @foreach($customerquery as $index=>$sale)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$sale->getName->display_name}}</td>
                    <td>{{$sale->getName->getCategory->name}}</td>
                    <td>{{$sale->qty_sum}}</td>
                    <td>{{$sale->getCalcUnit->name}}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-bold text-danger">No result found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>