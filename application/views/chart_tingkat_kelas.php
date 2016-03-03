        <!-- height="240" width="300" -->
        <h3><i class="fa fa-angle-right"></i> Diagram Nilai Tingkat</h3>
        <div class="tab-pane" id="chartjs">
          <div class="row mt">
            <div class="col-lg-12">
              <div class="showback">
                <h4><i class="fa fa-angle-right"></i> Keterangan</h4>
                <button type="button" class="btn btn-info">&nbsp;&nbsp;&nbsp;&nbsp;</button> : Di atas Rerata <br/><br/>
                <button type="button" class="btn btn-danger">&nbsp;&nbsp;&nbsp;&nbsp;</button> : Di bawah Rerata
              </div>
            </div>                
          </div>
          <?php
          if (isset($kelas)){
            $i=0;
            foreach ($kelas as $i_kelas) {
              $i++;

              echo '<div class="row mt">';
              echo    '<div class="col-lg-12">';
              echo '<div class="content-panel">';
              echo '<h4><i class="fa fa-angle-right"></i> Kelas '. $i_kelas. '</h4>';
              echo ' <div class="panel-body text-center">';
              echo '<canvas id="bar'.$i.'" height="400" width="800"></canvas>';
              echo '</div>';
              echo '</div>';
              echo '</div>';             
              echo '</div>';

            }
            
          } else {
            echo '<div class="row mt">';
              echo    '<div class="col-lg-12">';
              echo '<div class="content-panel">';
              echo '<h4><i class="fa fa-angle-right">Belum Ada Data</i></h4>';
              echo ' <div class="panel-body text-center">';
              // echo '<p> </p>';
              echo '</div>';
              echo '</div>';
              echo '</div>';             
              echo '</div>';
          }

          echo '</div>';  
          ?>

        </section>          
      </section><!-- /MAIN CONTENT -->

                          <!--main content end-->