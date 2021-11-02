<?php
$regno = $vehiclereg->regno;


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Vehicle Management
        <small>View Custodians</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?= base_url().'assignVehicle/'.$vehicleId; ?>"><i class="fa fa-plus"></i> Add Another Custodian</a>
                    <a class="btn btn-primary" href="<?= base_url().'vehicleListing/'; ?>"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users Assigned to <b> <?php echo $regno;?></b></h3>
                   
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Assigned On</th>
                        <th>Assigned By</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($assignmentinfo))
                    {
                        foreach($assignmentinfo as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->custodian ?></td>
                        <td><?php echo $record->telephone ?></td>
                        <td><?php echo date("d-m-Y", strtotime($record->assignedDtm)) ?></td>
                        <td><?php 
                                foreach($usersinfo as $record2)
                                {
                                    if ($record->assigned_by ==  $record2->userid){
                                        echo $record2->name;
                                    } 
                                }       
                            ?>
                        </td>                        
                        <td class="text-center"> 
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editVehicleAssignment/'.$record->vehicle_id.'/'.$record->assignId; ?>" title="Edit"><i class="fa fa-pencil"></i></a> |
                            <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->vehicle_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php //echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
