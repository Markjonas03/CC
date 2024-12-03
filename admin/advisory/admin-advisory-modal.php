<!-- ADMIN ADVISORY DELETE -->
<div class="modal fade" id="advisory_del_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php">
        <div class="modal-body">
          <div class="col-md-12">
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
            <h6>Do you want to delete this Advisory?</h6>
            <br>
            <h5><?php echo $row['lname'],", ",$row['fname']," ",$row['mname']?></h5>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="delete_advisory" class="btn btn-success btn-sm">Yes!</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">No</button>
        </div>
    </div>
      </form>
  </div>
</div>  
  <!-- Modal for Student List -->
  <div class="modal fade" id="studentListModal15" tabindex="-1" aria-labelledby="studentListModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Modal for ID 15</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Modal content here.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- ADMIN ADVISORY UPDATE -->
<div class="modal fade" id="advisory_up_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php">
        <div class="modal-header">
          <h3 class="modal-title">Edit Advisory..</h3>
        </div>

        <div class="modal-body">
          <div class="col-md-12">
    
            <div class="form-group">
              <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
              <label>Faculty</label>
              <select name="prof" class="form-select" required>
                <option value="" selected disabled>Choose..</option>
                <?php
                  $sql = "SELECT * FROM tbl_users WHERE role = 'professor'";
                  $query = mysqli_query($conn,$sql);
                  if($query){
                    if(mysqli_num_rows($query) > 0){
                      while($row = mysqli_fetch_array($query)){
                ?>
                <option value="<?php echo $row['id']?>"><?php echo $row['lname'],", ",$row['fname']," ",$row['mname']?></option>
                <?php
                    }
                  }
                }
                ?>
              </select>
            </div>

            <div class="form-group mt-3">
              <label>Class</label>
              <select name="class" class="form-select" required>
                <option value="" selected disabled>Choose..</option>
                <?php
                  $sql = "SELECT * FROM tbl_class";
                  $query = mysqli_query($conn,$sql);
                  if($query){
                    if(mysqli_num_rows($query) > 0){
                      while($row = mysqli_fetch_array($query)){
                ?>
                <option value="<?php echo $row['id']?>"><?php echo $row['course'],"-",$row['year'],$row['section']?></option>
                <?php
                    }
                  }
                }
                ?>
              </select>
                <div class="valid-feedback"> Looks good!</div>
                <div class="invalid-feedback"> Please choose Class!</div>
            </div>

            <div class="form-group mt-3">
              <label>Subject</label>
              <select name="subject" class="form-select" required>
                <option value="" selected disabled>Choose..</option>
                <?php
                  $sql = "SELECT * FROM tbl_subjects";
                  $query = mysqli_query($conn,$sql);
                  if($query){
                    if(mysqli_num_rows($query) > 0){
                      while($row = mysqli_fetch_array($query)){
                ?>
                <option value="<?php echo $row['id']?>"><?php echo $row['subject_code']," - ",$row['subject_name']?></option>
                <?php
                    }
                  }
                }
                ?>
              </select>
                <div class="valid-feedback"> Looks good!</div>
                <div class="invalid-feedback"> Please choose Subject!</div>
            </div>
            
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" name="update_advisory" class="btn btn-success btn-sm">Save Changes</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
      </form>
    </div>
  </div>
</div>