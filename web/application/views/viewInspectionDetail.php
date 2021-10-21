<?php
$regno = $answersforvehicle->vehicle_reg; 
$date = $answersforvehicle->response_on; 
$userid =$answersforvehicle->user_id;
$comment= $answersforvehicle->comment;
$answers = json_decode($answersforvehicle->response_ids);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-car"></i> Daily Reports
        <small>Inspection Report</small>
      </h1>
    </section>
    <section class="content">
     
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
                        <h3 class="box-title"><span style="text-transform: capitalize;"><?php echo $detailtype; ?></span> Inspection Report For <b><?php echo $regno; ?></b> done on  <b><?php echo date("d-m-Y", strtotime($date)); ?></b> at <b><?php echo date("H:i a", strtotime($date)); ?></b> by <b><span style="text-transform: capitalize;"><?php 
                            foreach($usersinfo as $x){
                                if($x->userid == $userid){
                                    echo $x->name;
                                }
                            }
                        ?></b></span></h3>                 
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                            <th>Item</th>
                            <th>Status</th>
                            </tr> 
                                <?php
                                if(!empty($answers) && $checksinfo)
                                {
                                    if (is_array($answers) || is_object($answers)){
                                    foreach($answers as $key=>$value){
                                    
                                ?>                  
                                <tr>
                                    <td><?php 
                                        foreach($checksinfo as $r1){
                                            if((int)$r1->checkid == $key){
                                                echo $r1->title;
                                            }
                                        }
                                    ?></td>
                                    <td><span style="text-transform: capitalize;"><?php echo $value ?></span></td>
                                
                                </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                        </table>
                  
                   </div><!-- /.box-body -->
                    <div class="box">
                        <div class="box-header">
                             <h3 class="box-title">General Comment</h3>
                             <!-- <div class="box-title"><?php //echo $comment; ?></div> -->
                        </div>
                        <div>
                        <p class="text-left" style="margin-left:10px;"><?php echo $comment; ?></p>
                        </div>

                    </div>  
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
            jQuery("#searchList").attr("action", baseURL + "vehicleListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
