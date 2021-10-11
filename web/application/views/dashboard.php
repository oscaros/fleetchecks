<?php
$totalvehicles = $totalvehicles;
$totaltodayschecks = $totalcheckstoday;
$totalweeklychecks=$totalchecksweekly;

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $totaltodayschecks; ?>/<?php echo $totalvehicles; ?></h3>
                  <p>Today's Checks</p>
                </div>
                <div class="icon">
                  <i class="ion ion-checkmark"></i>
                </div>
                <a href="<?php echo base_url(); ?>dailyReports" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $totalweeklychecks; ?>/<?php echo $totalvehicles; ?></h3>
                  <p>Weekly Checks (this week)</p>
                </div>
                <div class="icon">
                  <i class="ion ion-checkmark"></i>
                </div>
                <a href="<?php echo base_url(); ?>weeklyReports" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $totalvehicles; ?></h3>
                  <p>Total Vehicles</p>
                </div>
                <div class="icon">
                  <i class="ion ion-android-car"></i>
                  <ion-icon name="car"></ion-icon>
                </div>
                <a href="<?php echo base_url(); ?>vehicleListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>
                  <?php 
                     
                          $count = 0; 
                      foreach($totalfailstoday as $record)
                      {
                          $obj = json_decode($record->response_ids, TRUE);
                          foreach ($obj as $key => $value) 
                          { 
                              if ($value == "fail") 
                              { 
                                  $count++; 
                              } 
                          } 
                      }
                          echo $count; 
                      

                  ?>
                  
                  </h3>
                  <p>Today's Total Fails</p>
                </div>
                <div class="icon">
                  <i class="ion ion-wrench"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>
    </section>
</div>