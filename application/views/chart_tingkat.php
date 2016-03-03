        <!-- height="240" width="300" -->
        <h3><i class="fa fa-angle-right"></i> Diagram Nilai Tingkat</h3>
        <!-- page start-->
        <?php
        for ($i=1; $i < 4; $i++) { 
          if (!(isset($label[$i]) or isset($higher[$i]) or isset($lower[$i]))){
            $kosong[$i] = true;
          } else {
            $kosong[$i] = false;
          }
        }
        
        // print_r($kosong);
        // die();
        ?>
        <div class="tab-pane" id="chartjs">
          <div class="row mt">
            <div class="col-lg-12">
              <div class="showback">
                <h4><i class="fa fa-angle-right"></i> Keterangan </h4>
                <button type="button" class="btn btn-info">&nbsp;&nbsp;&nbsp;&nbsp;</button> : Di atas Rerata <br/><br/>
                <button type="button" class="btn btn-danger">&nbsp;&nbsp;&nbsp;&nbsp;</button> : Di bawah Rerata
              </div>
            </div>                
          </div>


          <div class="row mt">
            <div class="col-lg-12">
              <div class="content-panel"> 
                <a href = "<?=base_url('charts/chart_tingkat_mapel_kelas/1/'.$tahun_ajaran.'')?>">
                  <h4><i class="fa fa-angle-right"></i> Tingkat Satu <?php if($kosong[1]) echo '- Belum Ada Data';?></h4>
                  <div class="panel-body text-center">
                    <canvas id="bar1" height="400" width="800"></canvas>
                  </div>
                </a>
              </div>
            </div>                
          </div>
          <div class="row mt">
            <div class="col-lg-12">
              <div class="content-panel">
                <a href ="<?=base_url('charts/chart_tingkat_mapel_kelas/2/'.$tahun_ajaran.'')?>">
                  <h4><i class="fa fa-angle-right"></i> Tingkat Dua <?php if($kosong[2]) echo '- Belum Ada Data';?></h4>
                  <div class="panel-body text-center">
                    <canvas id="bar2" height="400" width="800"></canvas>
                  </div>
                </a>
              </div>
            </div>                
          </div>
          <div class="row mt">
            <div class="col-lg-12">
              <div class="content-panel">
                <a href = "<?=base_url('charts/chart_tingkat_mapel_kelas/3/'.$tahun_ajaran.'')?>">
                  <h4><i class="fa fa-angle-right"></i> Tingkat Tiga <?php if($kosong[3]) echo '- Belum Ada Data';?></h4>
                  <div class="panel-body text-center">
                    <canvas id="bar3" height="400" width="800"></canvas>
                  </div>
                </a>
              </div>
            </div>                
          </div>
        </div>
        <!-- page end-->
        </section>          
        </section><!-- /MAIN CONTENT -->

                          <!--main content end-->