<?php
$name = $vehicleInfo->name;
$model = $vehicleInfo->model;
$regno = $vehicleInfo->regno;
$color = $vehicleInfo->color;
$dept = $vehicleInfo->department;
$vehicleId = $vehicleInfo->vehicleId;
$userId = $assignmentInfo->user_id;
$assignId =$assignmentInfo->assignId;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-car"></i> Vehicle Management
        <small>Edit Vehicle Assignment</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <div class="form-group">                   
                            <a class="btn btn-primary" href="<?php echo base_url().'viewAssignedCustodians/'.$vehicleId; ?>"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </div>
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Select User to Re-assign to</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editVehicleAssignmentPost" method="post" id="editVehicle" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="regno">Registration Number</label>
                                        <input type="text" class="form-control" id="regno" placeholder="registration number" name="regno" value="<?php echo $regno; ?>" maxlength="128" readonly>
                                        <input type="hidden" value="<?php echo $assignId; ?>" name="assignId" id="assignId" />
                                        <input type="hidden" value="<?php echo $vehicleId; ?>" name="vehicleId" id="vehicleId" />    
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Vehicle Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Vehicle Name" name="name" value="<?php echo $name; ?>" maxlength="128" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        <input type="text" class="form-control" id="color" placeholder="Vehicle color" name="color" value="<?php echo $color; ?>" maxlength="128" readonly>
                                         
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userid">Select User to Assign to</label>
                                        <select class="form-control" id="userid" name="userid">
                                            <option value="0">Select User</option>
                                            <?php
                                            if(!empty($usersinfo))
                                            {
                                                foreach ($usersinfo as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->userid; ?>" <?php if($rl->userid == $userId) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>