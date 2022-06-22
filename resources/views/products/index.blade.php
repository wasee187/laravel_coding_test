@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{session('message')}}
        </div>
    @elseif(Session::has('message'))
        <div class="alert alert-danger" role="alert">
            {{session('message')}}
        </div>
    @endif

    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        @foreach($variants as $index=>$key)
                            <option value="" disabled selected>{{$key->title}}</option>
                                @foreach($variants_attr as $index_attr=>$key_attr)
                                    @if($key_attr->variant_title == $key->title)
                                        <option class="ml-2" value={{$key_attr->variant_name}}>{{$key_attr->variant_name}}</option>
                                    @endif
                                @endforeach
                           
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    
                    @foreach ($all_products_data as $index=>$key)
        
                    <tr>
                        <td>{{$key->id}}</td>
                        <td>{{$key->title}}<br> Created at : {{$key->created_at}}</td>
                        <td class="col-lg-3 pb-0">{{$key->description}}</td>
                        <td>
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">
                                
                                @foreach($all_product_id as $id_index=>$key_id)
                                    @if($key->product_id ==$key_id->id )
                                    <dt class="col-sm-3 pb-0">
                                        {{$key->variant}}
                                    </dt>
                                    <dd class="col-sm-9">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4 pb-0">Price : {{ $key->price }}</dt>
                                            <dd class="col-sm-8 pb-0">InStock : {{ $key->stock }}</dd>
                                        </dl>
                                    </dd>
                                    @endif
                                @endforeach

                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{url('product/edit/')}}/{{$key->id}}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    @if( $data_count >0)
                    <p>Showing 1 to 
                        
                        {{$data_count}} 
                        out of {{$count}}</p>
                    @else
                    <p>Showing 1 to 
                        @if ($count<10)
                            {{$count}}
                        @else
                            10 
                        @endif
                        out of {{$count}}</p>
                    @endif

                </div>
                <div class="col-md-2">
                    {{$all_products_data->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection
