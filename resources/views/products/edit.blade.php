@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Product</h1>
        </div>
        <form autocomplete="off" action="/product/update/{{$id}}" method="post" id='products_form'>
            @csrf
            <div class="row">
                <div class="col-lg-10">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title" class="control-label mb-1">Product Name</label>
                                <input id="title" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false"  value="{{$title}}">
                                    @if ($errors->has('title'))
                                        <div class="alert alert-danger" role="alert">
                                            @error('title')
                                                {{$message}}
                                            @enderror
                                        </div>
                                    @endif
                            </div>
                            <div class="form-group has-success">
                                <label for="sku" class="control-label mb-1">Product SKU</label>
                                <input id="sku" name="sku" type="text" class="form-control cc-name valid" data-val="true" aria-required="true" aria-invalid="false"  value="{{$sku}}">
                                @if ($errors->has('sku'))
                                    <div class="alert alert-danger" role="alert">
                                        @error('sku')
                                            {{$message}}
                                        @enderror
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label mb-1">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="4">{{$description}}</textarea>
                                @if ($errors->has('description'))
                                <div class="alert alert-danger" role="alert">
                                    @error('description')
                                        {{$message}}
                                    @enderror
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
       
                </div>
            </div>
            <div>
                <button id="submit" type="submit" class="btn ml-2 mt-5 btn-lg btn-info">
                        Save
                </button>
                <button id="cancel" type="submit" class="btn ml-3 mt-5 btn-lg btn-secondary">
                    Cancel
                </button>
            </div>
        </form>
    
    </div>
@endsection