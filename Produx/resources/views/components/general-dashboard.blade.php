
<div>
    <div class="content-wrapper" id="content-wrapper" style="min-height: 728px;">





        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <i class="fa fa-dashboard"></i> DASHBOARD
            <!-- Optional description -->
            <small></small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">





          <div class="modal fade" id="please-wait-dialog" role="dialog" data-backdrop="static" data-keyboard="false" style="padding-top:15%; padding-left: 15px; overflow-y:visible;">

            <div class="modal-dialog modal-m" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h1>Please wait...</h1>
                </div>
                <div class="modal-body">
                  <div class="progress progress-striped active" style="margin-bottom:0;">
                    <div class="progress-bar" style="width: 100%"></div>                   
                  </div>
                </div>

                <div class="modal-footer" id="please-wait-dialog-footer">
                  <div class="pull-right">
                    <button class="btn btn-direct pull-right" id="please-wait-dialog-cancel-btn">Cancel</button>
                  </div>  
                </div>            

              </div>
            </div>
          </div>

          <!-- success modal -->
          <div class="modal fade" id="modal-success">


            <div class="modal-dialog modal-lg modal-success" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                  </button>
                  <h4 class="modal-title">Add device</h4>
                </div>
                <div class="modal-body">
                  <p class="alert" style="text-align:center;">Device is registered. Please go to Devices and make necessary settings.</p>
                </div><!-- /.modal-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div>


          <!-- <div class="info-box">
            <span class="info-box-icon bg-green" style="background-color: #00a65a !important;"><i class="ion ion-social-usd"></i></span>
            <div class="info-box-content" style="padding-top:15px;">
              <span class="info-box-text">Balance</span>
              <span class="info-box-number inline">
                996.01&nbsp;USD
              </span>

              <hr style="margin:0; margin-top:10px;">
            </div>
          </div> -->


          <div class="info-box">
            <span class="info-box-icon bg-yellow" style="background-color: #f39c12 !important;">
              <i class="fa fa-desktop" style="margin-top:30%; color: white;"></i>
            </span>
            <div class="info-box-content" style="padding-top:15px;">
              <span class="info-box-text">Numero de dispositivos</span>
              <span class="info-box-number">
               0 
             </span>
             <hr style="margin:0; margin-top:10px;">
           </div>
         </div>



         <!-- first-row -->
         <div class="row">
           <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="sm-dashboard-info-box">
             <div class="sm-dashboard-info-box-content">
              <span class="sm-dashboard-info-box-text">Todas las acciones</span>
              <span class="sm-dashboard-info-box-number">N/A</span>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="sm-dashboard-info-box">
           <div class="sm-dashboard-info-box-content">
            <span class="sm-dashboard-info-box-text">Acciones durante esta hora</span>
            <span class="sm-dashboard-info-box-number">N/A</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="sm-dashboard-info-box">
         <div class="sm-dashboard-info-box-content">
          <span class="sm-dashboard-info-box-text">Acciones durante el dia</span>
          <span class="sm-dashboard-info-box-number">N/A</span>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="sm-dashboard-info-box">
       <div class="sm-dashboard-info-box-content">
        <span class="sm-dashboard-info-box-text">Acciones durante el mes</span>
        <span class="sm-dashboard-info-box-number">N/A</span>
      </div>
    </div>
  </div>
</div>

<!-- second-row -->
<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="sm-dashboard-info-box">
			<div class="sm-dashboard-info-box-content">
        <span class="sm-dashboard-info-box-text">Dispositivos conectados</span>
        <span class="sm-dashboard-info-box-number" id="sm-devices-count-online">N/A</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="sm-dashboard-info-box">
     <div class="sm-dashboard-info-box-content">
      <span class="sm-dashboard-info-box-text">Todos los dispositivos</span>
      <span class="sm-dashboard-info-box-number" id="sm-devices-count">N/A</span>
    </div>
  </div>
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="sm-dashboard-info-box">
   <div class="sm-dashboard-info-box-content">
    <span class="sm-dashboard-info-box-text">All media</span>
    <span class="sm-dashboard-info-box-number">28</span>
  </div>
</div>
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="sm-dashboard-info-box">
   <div class="sm-dashboard-info-box-content">
    <span class="sm-dashboard-info-box-text">Promedio de tiempo en acciones concluidas</span>
    <span class="sm-dashboard-info-box-number">N/A</span>
  </div>
</div>
</div>
</div>
<div class="row sm-btn-add-device-row">
  <div class="col-lg-3 col-md-6 col-xs-12">
    <button type="button" class="btn btn-block btn-primary" id="btn-add-device">Agregar dispositivo</button>
  </div>
</div>

</section><!-- /.content -->

</div><!-- /.content-wrapper -->
</div>