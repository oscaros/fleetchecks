<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" />
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-bar-chart"></i> Weekly Reports
        <small>track weekly inspection</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
          <form action="<?php echo base_url() ?>weeklyReports" method="POST" id="searchList">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
              <div class="input-group">
                <input id="fromDate" type="text" name="fromDate" value="<?php echo $fromDate; ?>" class="form-control datepicker" placeholder="From Date" autocomplete="off" />
                <span class="input-group-addon"><label for="fromDate"><i class="fa fa-calendar"></i></label></span>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
              <div class="input-group">
                <input id="toDate" type="text" name="toDate" value="<?php echo $toDate; ?>" class="form-control datepicker" placeholder="To Date" autocomplete="off" />
                <span class="input-group-addon"><label for="toDate"><i class="fa fa-calendar"></i></label></span>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
              <input id="searchText" type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control" placeholder="Search Text"/>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-6 form-group">
              <button type="submit" class="btn btn-md btn-primary btn-block searchList pull-right"><i class="fa fa-search" aria-hidden="true"></i></button> 
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-6 form-group">
              <button class="btn btn-md btn-default btn-block pull-right resetFilters"><i class="fa fa-refresh" aria-hidden="true"></i></button>
            </div>
          </form>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= !empty($userInfo) ? $userInfo->name." : ".$userInfo->email : "All History" ?></h3>
                    <div class="box-tools">
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                      <th>Reg No.</th>
                      <th>Custodian</th>
                      <th>Done on</th>
                      <th>Pass Or Fail</th>
                    </tr>
                    <?php
                    if(!empty($weeklyrecords))
                    {
                        foreach($weeklyrecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->vehicle_reg ?></td>
                      <td><span style="text-transform: capitalize;"><?php echo $record->custodian ?></span></td>
                      <td><?php echo $record->response_on ?></td>
                      <td><?php 
                      $obj = json_decode($record->response_ids, TRUE);
                      
                        // Loop through the object
                        if (is_array($obj) || is_object($obj)){
                          foreach($obj as $key=>$value){
                              // if($value == "not ok"){
                              //     $val = TRUE;
                              // }

                              if( in_array( "fail", $obj ) ){
                                $val = TRUE;
                              }else{
                                $val = FALSE;
                              }
                          }
                      }

                        if($val == TRUE){
                            echo "<div style='background:#d73925; width: 40px; color:#d73925; border-radius: 50px;'>|</div>";
                        }else{
                            echo "<div style='background:#00a65a; width: 40px; color:#00a65a;border-radius: 50px;'>|</div>";
                        }
                      
                      
                      ?></td>
                       <td class="text-center">
                          <a class="btn btn-sm btn-primary" href="<?= base_url().'viewInspectionDetail/'.$record->answerid.'/'.'weekly'; ?>" title="view detail"><i class="fa fa-eye"></i></a> 
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;
            jQuery("#searchList").attr("action", link);
            jQuery("#searchList").submit();
        });

        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy"
        });
        jQuery('.resetFilters').click(function(){
          $(this).closest('form').find("input[type=text]").val("");
        })
    });
</script>
