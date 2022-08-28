<h1>Test</h1>
<div id="users"></div>
<!-- Edit User Modal -->
<div class="modal" id="editUserModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="editUserForm">
          <input type="hidden" name="userid" id="userid">
          <div class="mb-3 mt-3">
            <label for="fname">First Name:</label>
            <input type="text" class="form-control" id="fname" placeholder="Enter first name" name="fname">
          </div>
          <div class="mb-3">
            <label for="lname">Last Name:</label>
            <input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lname">
          </div>
          <div class="mb-3">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" placeholder="Enter address" name="address">
          </div>
           <div class="mb-3">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
          </div>
          <div class="mb-3">
            <label for="email">Phone:</label>
            <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone">
          </div>
          <button class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>