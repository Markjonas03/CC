<!-- ADMIN USERS STUDENT UPDATE -->
<div class="modal fade" id="stud_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="admin-act-stud.php">
        <div class="modal-header">
          <h3 class="modal-title">Edit Data..</h3>
        </div>

        <div class="modal-body">
          <div class="col-md-12">
    
            <div class="form-group">
              <label>Student ID</label>
              <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
              <input type="text" name="id_no" value="<?php echo $row['id_no']?>" class="form-control" required/>
            </div>

            <div class="form-group mt-3">
              <label>First Name</label>
              <input type="text" name="fname" value="<?php echo $row['fname']?>" class="form-control" required/>
            </div>

            <div class="form-group mt-3">
              <label>Middle Name</label>
              <input type="text" name="mname" value="<?php echo $row['mname']?>" class="form-control" required/>
            </div>

            <div class="form-group mt-3">
              <label>Last Name</label>
              <input type="text" name="lname" value="<?php echo $row['lname']?>" class="form-control" required/>
            </div>

            <div class="form-group mt-3">
              <label>Email Address</label>
              <input type="email" name="email" value="<?php echo $row['email']?>" class="form-control" required/>
            </div>

            <div class="form-group mt-3">
              <label>Contact</label>
              <input type="number" name="contact" value="<?php echo $row['contact']?>" class="form-control" required/>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="admin-update-stud" class="btn btn-success btn-sm">Save Changes</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
      </form>
  </div>
</div>


<!-- ADMIN USERS STUDENT DELETE -->
<div class="modal fade" id="studs_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="admin-act-stud.php">
        <div class="modal-body">
          <div class="col-md-12">
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
            <h6>Do you want to delete this data?</h6>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="admin-delete-stud" class="btn btn-success btn-sm">Yes</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">No</button>
        </div>
    </div>
      </form>
  </div>
</div>