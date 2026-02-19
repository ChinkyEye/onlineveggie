@foreach($datas as $key => $data)
<tr>
	<td>{{$key + 1}}</td>
	<td>{{$data->title}}</td>
	<td class="text-center">
		<img src="{{URL::to('/')}}/images/slider/{{$data->image}}" class="img-fluid" style="height:50px;width: 50px">
	</td>
	<td class="text-center">
		<!-- <input type="text" name="" id="{{$data->id}}" ids="{{$data->id}}" class="text-center sort w-100" page="slider" contenteditable="true" value="{{$data->sort_id}}"> -->
		<p name="" id="{{$data->id}}" ids="{{$data->id}}" class="text-center sort w-100" page="slider" contenteditable="plaintext-only" value="{{$data->sort_id}}"></p>
	</td>
	<td class="text-center">
		<a href="{{URL::to('/')}}/manager/slider/{{$data->id}}/isActive" class=" {{$data->is_active == '0' ? 'text-danger' : 'text-success'}}"><i class="fas {{ $data->is_active == '1' ? 'fa-check':'fa-times'}}"></i></a>
	</td>
	<td class="text-center">
		<a href="#" class="mr-2"><i class="fas fa-edit"></i></a>
		<a href="{{URL::to('/')}}/manager/slider/{{$data->id}}/delete"><i class="fa fa-trash"></i></a>
	</td>
</tr>
@endforeach
