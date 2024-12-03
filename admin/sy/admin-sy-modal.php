<!-- ADMIN SCHOOL YEAR UPDATE -->
<div class="modal fade" id="sy_up_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php">
        <div class="modal-header">
          <h3 class="modal-title">Edit School Year..</h3>
        </div>

        <div class="modal-body">
          <div class="col-md-12">
   
            <div class="form-group">
              <label>School Year</label>
              <input type="hidden" name="sy_id" value="<?php echo $row['id']?>"/>
              <input type="text" name="school_year" value="<?php echo $row['school_year']?>" class="form-control" required/>
            </div>

            <div class="form-group mt-3">
              <label>Current</label>
              <select class="form-select" name="status">
                <option>Yes</option>
                <option>No</option>
              </select>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_sy" class="btn btn-success btn-sm">Save Changes</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
      </form>
  </div>
</div>


<!-- ADMIN SCHOOL YEAR DELETE -->
<div class="modal fade" id="sy_del_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php">
        <div class="modal-body">
          <div class="col-md-12">
            <input type="hidden" name="sy_id" value="<?php echo $row['id']?>"/>
            <h6>Do you want to delete this School Year?</h6>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="delete_sy" class="btn btn-success btn-sm">Yes</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">No</button>
        </div>
    </div>
      </form>
  </div>
</div>