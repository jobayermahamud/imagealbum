@extends('layouts.master')
@include('layouts.modal')
@section('content')
  <div class="container-fluid">
    <div id="previewModal" class="previewModal">

      <!-- The Close Button -->
      <span class="close">&times;</span>
    
      <!-- Modal Content (The Image) -->
      <img class="previewmodal-content" id="img01">
    
      <!-- Modal Caption (Image Text) -->
      <div id="caption"></div>
    </div>
      <hr>
      <div class="row">
        
          <div class="col-md-12">
              <h3>Your images</h3>
              <div class="row">
                  <div class="col-md-2">
                       <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" href="#">Upload image</a>
                       
                  </div>
                  <div class="col-md-10">
                    <form>
                        <div class="form-group">
                          {{-- <label for="exampleInputEmail1">Email address</label> --}}
                          <input id="searchBox" type="text" class="form-control" placeholder="search" id="exampleInputEmail1" aria-describedby="emailHelp">
                          
                        </div>
                        </form>
                  </div>
              </div>
              <hr>
          </div>
          
      </div>
      <div class="row" id="app">
        {{-- @foreach ($images as $image)
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <img class="img-fluid img-thumbnail" style="width:100%;height:200px" src="{{env('IMG_URL').'/'.$image->img_url}}"  alt="..." >
                <h5>{{$image->title}}</h5>
                <i style="margin-top:3px;margin-bottom:3px" type="delete_knws" ref="105" class="btn btn-danger btn-sm fas fa-trash-alt">&nbsp;Remove</i> 
                
            </div>
        @endforeach --}}
          
          
      </div>
  </div>
    
@endsection