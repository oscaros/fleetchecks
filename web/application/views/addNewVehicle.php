<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-car"></i> Vehicle Management
        <small>Add Vehicle</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Vehicle Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form action="<?php echo base_url(); ?>addNewVehiclePost" method="post">
                    <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="regno">Registration Number</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('regno'); ?>" id="regno" name="regno" placeholder="E.g. UAA 001A" maxlength="128">
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Vehicle Name</label>
                                        <input type="text" class="form-control required" id="name" value="<?php echo set_value('name'); ?>" name="name"  placeholder="E.g. Toyota Landcruiser" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="model">Model</label>
                                        <input type="text" class="form-control required" id="model" name="model"  placeholder="E.g. V8" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dept">Department</label>
                                        <select class="form-control required" id="dept" name="dept">
                                            <option value="unassigned">Select department</option>
                                            <?php
                                            if(!empty($depts))
                                            {
                                                foreach ($depts as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->name ?>" <?php if($rl->name == set_value('name')) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        <select class="form-control required" id="color" name="color">
                                            <option value="uknown">Select Color</option>
                                            <option value="Official Colors">Official Colors</option>
                                            <option value="Silver">Silver</option>
                                            <option value="white">White</option>
                                            <option value="Green">Green</option>
                                         
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
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>