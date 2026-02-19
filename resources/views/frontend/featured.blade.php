<section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @foreach($categories as $category)
                            <li data-filter=".{{$category->slug}}">{{$category->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                @foreach($data_lists as $data)
                <div class="col-lg-3 col-md-4 col-sm-6 mix {{$data->getCategory->slug}} fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg img-thumbnail" data-setbg="{{url('/')}}/images/vegetable/{{$data->getName->image}}">
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">{{$data->getName->display_name}}</a></h6>
                            <h6>Rs {{$data->getPurchaseMinLatestI->rate}}/{{$data->getPurchaseMinLatestI->getUnit->name}}</h6>
                        </div>
                        <form role="form" class="myform">
                            {{csrf_field()}}
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1" name="quantity">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="purchase_manage_id" value="{{$data->getPurchaseMin->get(0)->id}}">
                            @if(Auth::check())
                            
                            <button type="submit" class="btn btn-info btn1" id="btn" >Add To Cart</button>
                            @else
                            <button type="submit" class="btn btn-info btn2" id="btn" onclick="this.disabled=true">Add To Cart</button>
                            @endif
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @section('javascript')
    <script type="text/javascript">
        $('.btn2').on('click',function(){
            Swal.fire({
              title: 'You should login first',
              timer: 1000
          })
        })
    </script>

    <script type="text/javascript">
        $(".myform").on("submit", function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            debugger;
            
            $.ajax({
                type : "POST",
                url  : "{{URL::to('/')}}/cart/store",
                dataType : "JSON",
                data : formData,
                success:function(data)
                {
                    location.reload();
                    // console.log(data); 
                    const Toast = Swal.mixin({
                      toast: true,
                      position: 'bottom-start',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true,
                      onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                    Toast.fire({
                      icon: 'success',
                      title: 'Added successfully'
                  })
                },
                error: function (e) {
                    alert('Sorry! this data is used some where');
                    Pace.start();
                }
            });
        });
    </script>
    @endsection
