<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            
              
              <div>
                  <ul id="err">
                      
                  </ul>
              </div>
      

            
            <form action="./uploadimage" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <input type="text"  autocomplete="false" name="title"id="title"  placeholder="image title"/>
                <hr>
                <input type="file" name="image" id="image"/>
                <input class="btn btn-success" type="submit" value="Upload">
            </form>
            <hr>
            <p>Uploaded: <span id="progress">0</span> %</p>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>