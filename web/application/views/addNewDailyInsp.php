<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-check-square-o"></i> Vehicle Inspection
        <small>Add Daily Inspection</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
             <div class="row">
                <div class="col-xs-12 text-right">
                    <div class="form-group">                   
                        <a class="btn btn-primary" href="<?php echo base_url().'dailyInsp/'; ?>"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div>
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                              
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter responses to the daily checks below </h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form onsubmit="jsfunction();" name="form" method="post">
                    <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="vehicle">Select the Vehicle you would like to inspect *</label>
                                        <select class="form-control required" id="vehicle" name="vehicle">
                                            <option value="">Select vehicle</option>
                                            <?php
                                            if(!empty($assignedvehicles))
                                            {
                                                foreach ($assignedvehicles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->regno ?>"><?php echo $rl->regno ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>                                    
                                </div>
                              <?php 
                                 foreach($dailychecks as $r1){
                                 ?>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="regno"><?php echo $r1->title; ?> *</label>
                                        <select class="form-control required" id="answer" name="<?php echo $r1->id; ?>">
                                            <option value="pass">Pass</option>
                                            <option value="fail">Fail</option>
                                            <option value="NA">Not Applicable</option>
                                        </select>
                                        <!-- <div class="form-group">
                                            <input type="radio" id="contactChoice1" name="contact" value="email" required><span>Pass</span>
                                            <input type="radio" id="contactChoice1" name="contact" value="email"><span>Fail</span>
                                            <input type="radio" id="contactChoice1" name="contact" value="email"><span>Not Applicable</span>
                                        </div> -->
                                </div>

                                
                                    
                                </div>
                                <?php } ?>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="comment">Add a comment to explain the fails if any</label>
                                        <textarea class="form-control required"  id="comment" name="comment"></textarea>
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
<script type="text/javascript">
function jsfunction(){
    
    //var formData = new FormData();

    var formElement = document.querySelector("form");
    var formData = new FormData(formElement);
 
    var http = new XMLHttpRequest();
    var url = '<?php echo base_url(); ?>addNewDailyInspPost';
    //var params = 'orem=ipsum&name=binny';

    //do some client side validation
    var textarea = document.getElementById('comment').value;
    var vehicle = document.getElementById('vehicle').value;
    // for(var pair of formData.entries()){
    //     alert(pair)
    // }
    var failFlag = false;
    for(var pair of formData.values()){
        if(pair == "fail"){
            failFlag = true;
        }
    }

    //alert(failFlag);

    if(vehicle == ""){
        alert("Please select vehicle first");
        //break;
    }else{

        if(failFlag == true && textarea == ""){
            alert("Please add comment to elaborate the reason for the fail(s)");
            
        }else{
                http.open('POST', url, true);
                //Send the proper header information along with the request
                //http.setRequestHeader('Content-Type', 'multipart/form-data');
                http.onreadystatechange = function() {//Call a function when the state changes.
                    if(http.readyState == 4 && http.status == 200) {
                        alert(http.responseText);
                        window.location.href = "<?php echo base_url(); ?>dailyInsp";
                    }
                }
                http.send(formData);
            } 
    }

        


   
}
</script>