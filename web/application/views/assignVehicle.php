<?php
$vehicleid = $vehicleinfo->vehicleId;
$vehicleName = $vehicleinfo->name;
$regno = $vehicleinfo->regno;
$color = $vehicleinfo->color;
//$isAdmin = $userInfo->isAdmin;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-car"></i> Vehicle Management
        <small>Assign Vehicle to a Custodian</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->               
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Select a User to assign <b><?php echo $regno; ?></b> to and submit</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>assignVehiclePost" method="post" id="assignVehiclePost" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Vehicle Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Vehicle Name" name="fname" value="<?php echo $vehicleName; ?>"readonly>
                                        <input type="hidden" value="<?php echo $vehicleid; ?>" name="vehicleId" id="vehicleId" />    
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="regno">Registration No</label>
                                        <input type="regno" class="form-control" id="regno" placeholder="Enter regno" name="regno" value="<?php echo $regno; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color">Vehicle Color</label>
                                        <input type="color" class="form-control" id="color" placeholder="color" name="color" readonly>
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
                                                    <option value="<?php echo $rl->userid; ?>" ><?php echo $rl->name ?></option>
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