<!-- ADMIN CLASS DELETE -->
<div class="modal fade" id="class_del_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php">
        <div class="modal-body">
          <div class="col-md-12">
            <input type="hidden" name="class_id" value="<?php echo $row['id']?>"/>
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
            <h6>Do you want to delete this Class?</h6>
            <br>
            <h5><?php echo $row['course'],"-",$row['year'],$row['section']?></h5>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="delete_class" class="btn btn-success btn-sm">Yes!</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">No</button>
        </div>
    </div>
      </form>
  </div>
</div>

<!-- ADMIN CLASS UPDATE -->
<div class="modal fade" id="class_up_modal<?php echo $row['id']?>" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="../../include/server.php" class="form needs-validation" novalidate>
        <div class="modal-header">
          <h3 class="modal-title">Edit Class..</h3>
        </div>

        <div class="modal-body">
          <div class="col-md-12">
    
            <div class="form-group">
              <label>Course</label>
              <input type="hidden" name="class_id" value="<?php echo $row['id']?>"/>
              <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
              <input type="text" name="course" value="<?php echo $row['course']?>" class="form-control" required/>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label>Year</label>
                        <input class="form-control" type="text" name="year" value="<?php echo $row['year']?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label>Section</label>
                        <input class="form-control" type="text" name="section" value="<?php echo $row['section']?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Select Semester</label>
                <select name="sem" class="form-select" required>
                    <option selected disabled>Choose..</option>
                    <option value="First Semester" <?php if($sem == 'First Semester'){ echo "selected";}?>>First Semester</option>
                    <option value="Second Semester" <?php if($sem == 'Second Semester'){ echo "selected";}?>>Second Semester</option>
                    <option value="Summer" <?php if($sem == 'Summer'){ echo "selected";}?>>Summer</option>
                </select>
            </div>

            <div class="form-group mt-3">
                <label>School Year</label>
                <select name="sy" class="form-select" required>
                    <option value="" selected disabled>Choose..</option>
                  <?php
                      $sql = "SELECT * FROM tbl_sy";
                      $query = mysqli_query($conn,$sql);
                      if($query){
                        if(mysqli_num_rows($query) > 0){
                          while($row = mysqli_fetch_array($query)){
                  ?>
                    <option value="<?php echo $row['id']?>"><?php echo $row['school_year']?></option>
                  <?php
                        }
                      }
                    }
                  ?>
                </select>
                  <div class="valid-feedback"> Looks good!</div>
                  <div class="invalid-feedback"> Please choose School Year!</div>
            </div>

          </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" name="update_class" class="btn btn-success btn-sm">Save Changes</button>
          <button class="btn btn-danger btn-sm" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
      </form>
  </div>
</div>

