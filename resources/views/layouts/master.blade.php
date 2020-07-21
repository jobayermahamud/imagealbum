<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <title>{{$title}}</title>
    <style>
        .col-md-2
        {
            margin-bottom: 10px;
        }

        /* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.previewModal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.previewmodal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.previewmodal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .previewmodal-content {
    width: 100%;
  }
}

    </style>
</head>
<body>
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        let images=[];
        
        function loadjson(){
            $.get( "loadjson", function( data ) {
            
            images=JSON.parse(data);
            var imageContent='';

            for(var i=(images.length-1);i>=0;i--){
                 imageContent+=`<div id="${images[i].id}" class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                                 <img class="img-fluid img-thumbnail" style="width:100%;height:200px" src="{{env('IMG_URL').'/'}}${images[i].img_url}"  alt="${images[i].title}" >
                                 <h5>${images[i].title}</h5>
                                 <i ref="${images[i].id}" style="margin-top:3px;margin-bottom:3px" type="delete_knws" ref="105" class="btn btn-danger btn-sm fas fa-trash-alt">&nbsp;Remove</i> 
             
                             </div>`;
            }

            document.getElementById('app').innerHTML=imageContent;
         });
        
        }
        addEventListener('load',(e)=>{
            loadjson();
        })
        addEventListener('submit',(e)=>{
            e.preventDefault();
            var formData = new FormData();
            formData.append('image', $('#image')[0].files[0]);
            formData.append('title', document.getElementById("title").value);
            formData.append('_token','{{ csrf_token() }}');
            console.log("{{ csrf_token() }}")
            $.ajax({
                url : 'uploadimage',
                type : 'POST',
                data : formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    document.getElementById("progress").textContent='0';
                    document.getElementById('image').value='';
                    document.getElementById('title').value='';
                    document.getElementById('err').innerHTML='<li style="color:green">File uploaded</li>';
                    loadjson();
                },
                error:function(xhr,text,err){
                   var errors=JSON.parse(xhr.responseText).errors;
                   var errHtml='';
                   for(var err in errors){
                        errHtml+=`<li style='color:red'>${errors[err][0]}</li>`;
                   }

                   document.getElementById('err').innerHTML=errHtml;
                   document.getElementById("progress").textContent='0';
                   
                },
                xhr: function(){
                    // get the native XmlHttpRequest object
                    var xhr = $.ajaxSettings.xhr() ;
                    // set the onprogress event handler
                    xhr.upload.onprogress = function(evt){document.getElementById("progress").textContent=Math.floor((evt.loaded/evt.total)*100) } ;
                    return xhr ;
                }
            });
            })
        
        document.getElementById('searchBox').addEventListener('keyup',(e)=>{
            //e.preventDefault();
            let filteredData=[];
            
            for(var i=0;i<images.length;i++){
                images[i].title.includes(e.target.value)==true ? filteredData.push(images[i]) :''
            }
            var imageContent='';
            
                for(var i=(filteredData.length-1);i>=0;i--){
                 imageContent+=`<div id="${filteredData[i].id}" class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                                 <img class="img-fluid img-thumbnail" style="width:100%;height:200px" src="{{env('IMG_URL').'/'}}${filteredData[i].img_url}"  alt="${filteredData[i].title}" >
                                 <h5>${filteredData[i].title}</h5>
                                 <i ref="${filteredData[i].id}" style="margin-top:3px;margin-bottom:3px" type="delete_knws" ref="105" class="btn btn-danger btn-sm fas fa-trash-alt">&nbsp;Remove</i> 
             
                             </div>`;
                }
                document.getElementById('app').innerHTML=imageContent; 
            
            

            

        })
    </script>
    <script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.19/lodash.min.js"></script>
    <script>
        var modal = document.getElementById("previewModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
//var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
addEventListener('click',(e)=>{
    console.log(e.target.tagName)
    if(e.target.tagName=='IMG'){
        modal.style.display = "block";
        modalImg.src = e.target.src;
       captionText.innerHTML = e.target.alt;
    }

    if(e.target.tagName=='I'){
        e.target.textContent="Removing.."
        $.get({
            url:`removeimage/${e.target.getAttribute('ref')}`,
            success:function(data){
                console.log(data);
                loadjson();
            }
        })
    }
})


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[1];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
    </script>
</body>
</html>