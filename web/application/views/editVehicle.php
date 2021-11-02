<?php
$name = $vehicleInfo->name;
$model = $vehicleInfo->model;
$regno = $vehicleInfo->regno;
$color = $vehicleInfo->color;
$dept = $vehicleInfo->department;
$sect = $vehicleInfo->section;
$vehicleId = $vehicleInfo->vehicleId;
$type = $vehicleInfo->type;
$power= $vehicleInfo->power;
$region= $vehicleInfo->region;
$year_of_purchase= $vehicleInfo->year_of_purchase;
$ownership= $vehicleInfo->ownership;
$responsible= $vehicleInfo->responsible;
$supervisor= $vehicleInfo->supervisor;
$fuel_supplier= $vehicleInfo->fuel_supplier;
$monthly_allocation= $vehicleInfo->monthly_allocation;
$tank_capacity= $vehicleInfo->tank_capacity;
$card_no= $vehicleInfo->card_no;
$status= $vehicleInfo->status;
//$isAdmin = $userInfo->isAdmin;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-car"></i> Vehicle Management
        <small>Edit Vehicle</small>
      </h1>
    </section>
    
    <section class="content">
    <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">                   
                    <a class="btn btn-primary" href="<?= base_url().'vehicleListing/'; ?>"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Vehicle Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editVehiclePost" method="post" id="editVehicle" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="regno">Registration Number *</label>
                                        <input type="text" class="form-control required" value="<?php echo $regno; ?>" id="regno" name="regno" maxlength="128">
                                        <input type="hidden" value="<?php echo $vehicleId; ?>" id="vehicleId" name="vehicleId">
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Vehicle Name *</label>
                                        <input type="text" class="form-control required" id="name" value="<?php echo $name; ?>" name="name" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Vehicle Type *</label>
                                        <select class="form-control required" id="type" name="type">
                                            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>                                            
                                            <option value="Double Cab">Double Cab</option>
                                            <option value="Single Cab">Single Cab</option>
                                            <option value="Van">Van</option>
                                            <option value="SUV">SUV</option>
                                            <option value="Minibus">Minibus</option> 
                                            <option value="Motorcycle">Motorcycle</option>
                                            <option value="Fork lift">Fork lift</option>                                            
                                            <option value="Pole Handler">Pole Handler</option>
                                            <option value="Truck Ordinary">Truck Ordinary</option>
                                            <option value="Truck Selfloader">Truck Selfloader</option>
                                            <option value="Truck Bucket">Truck Bucket</option>                                                                                       
                                            <option value="Generator">Generator</option>

                                         
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="model">Model *</label>
                                        <input type="text" value="<?php echo $model; ?>" class="form-control required" id="model" name="model" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dept">Department *</label>
                                        <select class="form-control required" id="dept" name="dept">
                                            <option value="">Select department</option>
                                            <?php
                                            if(!empty($depts))
                                            {
                                                foreach ($depts as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->name ?>" <?php if($rl->name == $dept) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dept">Section</label>
                                        <select class="form-control" id="sect" name="sect">
                                            <option value="">Select section</option>
                                            <?php
                                            if(!empty($sects))
                                            {
                                                foreach ($sects as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->name ?>" <?php if($rl->name == $sect) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">                              
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        <select class="form-control" id="color" name="color">
                                            <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                                            <option value="Official Colors">Official Colors</option>
                                            <option value="Silver">Silver</option>
                                            <option value="white">White</option>
                                            <option value="Green">Green</option>
                                         
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="region">Region</label>
                                        <select class="form-control" id="region" name="region">
                                            <option value="<?php echo $region; ?>"><?php echo $region; ?></option>
                                            <option value="Central">Central</option>
                                            <option value="Eastern">Eastern</option>
                                            <option value="Western">Western</option>
                                            <option value="Northern">Northern</option>
                                            <option value="Lugogo">Lugogo</option>
                                         
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="yop">Year of purchase</label>
                                        <select class="form-control" id="yop" name="yop">
                                            <option value="<?php echo $year_of_purchase ?>"><?php echo $year_of_purchase ?></option>
                                            <option value="1999">1999</option>
                                            <option value="2000">2000</option>
                                            <option value="2001">2001</option>
                                            <option value="2002">2002</option>
                                            <option value="2003">2003</option>
                                            <option value="2004">2004</option>
                                            <option value="2005">2005</option>
                                            <option value="2006">2006</option>
                                            <option value="2007">2007</option>
                                            <option value="2008">2008</option>
                                            <option value="2009">2009</option>
                                            <option value="2010">2010</option>
                                            <option value="2011">2011</option>
                                            <option value="2012">2012</option>
                                            <option value="2013">2013</option>
                                            <option value="2014">2014</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                         
                                        </select>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ownership">Ownership *</label>
                                        <input type="text" class="form-control required" value="<?php echo $ownership; ?>" id="ownership" name="ownership" placeholder="E.g. Umeme" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="resp">Responsible person</label>
                                        <select class="form-control" id="resp" name="resp">
                                            <option value="">Select responsible person</option>
                                            <?php
                                            if(!empty($users))
                                            {
                                                foreach ($users as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->name ?>" <?php if($rl->name == $responsible) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supervisor">Supervisor</label>
                                        <select class="form-control" id="supervisor" name="supervisor">
                                            <option value="">Select Supervisor</option>
                                            <?php
                                            if(!empty($users))
                                            {
                                                foreach ($users as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->name ?>" <?php if($rl->name == $supervisor) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supplier">Fuel Supplier</label>
                                        <select class="form-control" id="supplier" name="supplier">
                                            <option value="<?php echo $fuel_supplier; ?>"><?php echo $fuel_supplier; ?></option>
                                            <option value="Vivo">Vivo</option>
                                            <option value="Total">Total</option>
                                         
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="capacity">Tank Capacity (in Litres)</label>
                                        <input type="number" value="<?php echo $tank_capacity; ?>" class="form-control" id="capacity" name="capacity" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="allocation">Monthly Allocation (in Litres)</label>
                                        <input type="number" value="<?php echo $monthly_allocation; ?>" class="form-control" id="allocation" name="allocation" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="cardno">Card Number</label>
                                        <input type="number" value="<?php echo $card_no; ?>" class="form-control" id="card" name="card" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status *</label>
                                        <select class="form-control required" id="status" name="status">
                                            <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                            <option value="Owned">Owned</option>
                                            <option value="Leased">Leased</option>  
                                            <option value="Scrapped Not Sold">Scrapped Not Sold</option>    
                                            <option value="Scrapped and Sold Off">Scrapped and Sold Off</option>    
                                            <option value="Hired">Hired</option> 
                                            <option value="Leased and Hired Recalls">Leased and Hired Recalls</option>  
                                            <option value="Stolen and Salvaged">Stolen and Salvaged</option>                                                
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="power">Vehicle Power</label>
                                        <select class="form-control" id="power" name="power">
                                            <option value="<?php echo $power; ?>"><?php echo $power; ?></option>
                                            <option value="4WD">4WD</option>
                                            <option value="2WD">2WD</option>  
                                            <option value="4 X 2">4 X 2</option>      
                                            <option value="6 X 4">6 X 4</option>                                          
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