
<h2>Posts</h2>
  <!-- Button to Open the Modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postModal">
    Add Post
  </button>

  <div id="posts"></div>

  <!-- The Modal -->
  <div class="modal" id="postModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Post Here</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form id="postForm" enctype="multipart/form-data">
          	<input type="hidden" name="user.id" value="<?=$id;?>">
          <div class="form-group">
            <input type="file" class="form-control-file border" name="image" id="image">
          </div>
          <div class="mb-3 mt-3">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" placeholder="Enter title" name="title">
          </div>
          <div class="mb-3">
            <label for="comment">Body:</label>
  			<textarea class="form-control" rows="5" id="body" placeholder="Leave a comment...." name="body"></textarea>
          </div>
          <button class="btn btn-primary" id="btnAdd" name="btnAdd">Add</button>
        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

   <!-- <div class="col-sm-9 mt-3">
      <h2>I Love Food</h2>
      <p>Food is my passion. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <br><br>
  </div> -->