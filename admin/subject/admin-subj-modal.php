<!-- ADMIN SUBJECT UPDATE -->
<div class="modal fade" id="subj_up_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php">
        <div class="modal-header">
          <h3 class="modal-title">Edit Subject..</h3>
        </div>

        <div class="modal-body">
          <div class="col-md-12">
    
            <div class="form-group">
              <label>Subject Code</label>
              <input type="hidden" name="subj_id" value="<?php echo $row['id']?>"/>
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
              <input type="text" name="subject_code" value="<?php echo $row['subject_code']?>" class="form-control" required/>
            </div>

            <div class="form-group mt-3">
                <label>Subject Name</label>
                <input class="form-control" type="text" name="subject_name" value="<?php echo $row['subject_name']?>" required>
            </div>

            <div class="form-group mt-3">
                <label>Units</label>
                <input class="form-control" type="number" name="unit" value="<?php echo $row['units']?>" required>
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_subject" class="btn btn-success btn-sm">Save Changes</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
      </form>
  </div>
</div>


<!-- ADMIN SUBJECT DELETE -->
<div class="modal fade" id="subj_del_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php">
        <div class="modal-body">
          <div class="col-md-12">
            <input type="hidden" name="subj_id" value="<?php echo $row['id']?>"/>
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
            <h6>Do you want to delete this Subject?</h6>
            <br>
            <h5><?php echo $row['subject_code'], " - ",$row['subject_name']?></h5>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" name="delete_subject" class="btn btn-success btn-sm">Yes!</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">No</button>
        </div>
    </div>
      </form>
  </div>
</div>