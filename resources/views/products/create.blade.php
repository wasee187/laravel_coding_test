@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
        </div>
        <form autocomplete="off" action="/product" method="post" id='products_form'>
            @csrf
            <div class="row">
                <div class="col-lg-10">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title" class="control-label mb-1">Product Name</label>
                                <input id="title" name="title" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Product Name">
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
                                <input id="sku" name="sku" type="text" class="form-control cc-name valid" data-val="true" aria-required="true" aria-invalid="false" placeholder="Product SKU">
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
                                <textarea class="form-control" name="description" id="description" rows="4"></textarea>
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
                    <div class="card shadow mt-5">
                        <div class="card-header" style="color:#2E9DDB; font-weight:bold;">Media</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="mb-3"> 
                                        <label for="product image" class="form-label">Product Image</label>
                                        <input class="form-control" type="file" id="product image" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-3 ml-3"style="color:#2E9DDB; font-weight:bold;">Variants</h3>

                <div class="col-lg-10" id="variant_attr_box">
                        <div class="card shadow" id="variant_option_1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="variant_id" class="control-label mb-1">Option</label> <br>
                                            <select class="form-control" name="variant_id[]" id="variant_id" aria-label="Default select example">
                                                @foreach ($variants as $index => $key)
                                                    <option value={{$key->id}}>{{$key->title}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="variant" class="control-label mb-1">Variant name</label> <br>
                                        <div class="input-group">
                                            <input id="variant" name="variant[]" type="tel" class="form-control cc-cvc" value=""><br>
                                            @if ($errors->has('variant'))
                                                <div class="alert alert-danger" role="alert">
                                                    @error('variant')
                                                        {{$message}}
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="price" class="control-label mb-1">Price</label> <br>
                                        <div class="input-group">
                                            <input id="price" name="price[]" type="tel" class="form-control cc-cvc" value=""> <br>
                                            @if ($errors->has('price'))
                                            <div class="alert alert-danger" role="alert">
                                                @error('price')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                             @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="stock" class="control-label mb-1">Stock</label> <br>
                                        <div class="input-group">
                                            <input id="stock" name="stock[]" type="tel" class="form-control cc-cvc" value=""><br>
                                            @if ($errors->has('stock'))
                                            <div class="alert alert-danger" role="alert">
                                                @error('stock')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn mt-2 btn-lg btn-info" onClick="add_more()">
                                    Add another option
                                </button>
                            </div>                           
                        </div>
                </div>
                <div>
                    <button id="submit" type="submit" class="btn ml-4 mt-5 btn-lg btn-info">
                            Save
                    </button>
                    <button id="cancel" type="submit" class="btn ml-3 mt-5 btn-lg btn-secondary">
                        Cancel
                    </button>
                </div>
            </div>
         
        </form>
    
    </div>
<script >
       let loop_count =1;

    function add_more(){
        loop_count++;
        let html = `<div class="card shadow mt-3" id="variant_option_`+loop_count+`">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="variant_id" class="control-label mb-1">Option</label> <br>
                                            <select class="form-control" name="variant_id[]" id="variant_id" aria-label="Default select example">
                                                @foreach ($variants as $index => $key)
                                                    <option value={{$key->id}}>{{$key->title}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="variant" class="control-label mb-1">Variant name</label> <br>
                                        <div class="input-group">
                                            <input id="variant" name="variant[]" type="tel" class="form-control cc-cvc" value=""><br>
                                            @if ($errors->has('variant'))
                                                <div class="alert alert-danger" role="alert">
                                                    @error('variant')
                                                        {{$message}}
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="price" class="control-label mb-1">Price</label> <br>
                                        <div class="input-group">
                                            <input id="price" name="price[]" type="tel" class="form-control cc-cvc" value=""> <br>
                                            @if ($errors->has('price'))
                                            <div class="alert alert-danger" role="alert">
                                                @error('price')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                             @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="stock" class="control-label mb-1">Stock</label> <br>
                                        <div class="input-group">
                                            <input id="stock" name="stock[]" type="tel" class="form-control cc-cvc" value=""><br>
                                            @if ($errors->has('stock'))
                                            <div class="alert alert-danger" role="alert">
                                                @error('stock')
                                                    {{$message}}
                                                @enderror
                                            </div>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn mt-2 btn-lg btn-danger" onClick=remove_more("`+loop_count+`")>
                                    Remove option
                                </button>
                            </div>       
        `
            jQuery('#variant_attr_box').append(html);
    }

    function remove_more(loop_count){
        jQuery('#variant_option_'+loop_count).remove();
    }
</script>
@endsection