 
 
        
        <!--main content end-->
        <!--footer start-->
        <footer class="site-footer">
          <div class="text-center">
            2015 - Team Informatika Universitas Diponegoro
            <a href="" class="go-top">
              <i class="fa fa-angle-up"></i>
            </a>
          </div>
        </footer>
        <!--footer end-->
        </section>    <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?=base_url('assets/js/jquery.js')?>"></script>
        <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
        <script class="include" type="text/javascript" src="<?=base_url('assets/js/jquery.dcjqaccordion.2.7.js')?>"></script>
        <script src="<?=base_url('assets/js/jquery.scrollTo.min.js')?>"></script>
        <script src="<?=base_url('assets/js/jquery.nicescroll.js')?>" type="text/javascript"></script>


        <!--common script for all pages-->
        <script src="<?=base_url('assets/js/common-scripts.js')?>"></script>

        <!--script for this page-->
        <script src="<?=base_url('assets/js/chart-master/Chart.js')?>"></script>
        <!-- <script type="text/javascript"> -->
        <script type="text/javascript">
        

          var Script = function () {
            <?php
            if (!isset($jumlah_kelas)){
              $jumlah_kelas = 3;
            }
            for ($i=1; $i <= $jumlah_kelas; $i++) { 
              // print_r($higher);
              // echo "<br/><br/>";
              // print_r($lower);
              // die();
              $barChartData= [];
              $barChartData['labels'] = $labels[$i];
              $barChartData['datasets'] = array(
                array(  'fillColor' => "#46BFBD",
                  'strokeColor' => "#46BFBD",
                  'data'=>$higher[$i]
                  ),
                array(  'fillColor' => "#F7464A",
                  'strokeColor' => "#F7464A",
                  'data'=>$lower[$i]
                  )
                );
              // print_r($barChartData);
              $step = floor(max(max($higher[$i]),max($lower[$i]))/count($higher[$i]))+1;
              $step = 5;
              // $step = round(count($higher[$i])/10,0,PHP_ROUND_HALF_UP);
              
              echo "var barChartData".$i." = ".json_encode($barChartData,JSON_NUMERIC_CHECK).";\n";
              // echo 'new Chart(document.getElementById("bar'.$i.'").getContext("2d")).Bar(barChartData'.$i.',{scaleOverride: true, scaleStartValue: 0, scaleStepWidth: '.$step.', scaleSteps: '.count($higher[$i]).'})'."\n\n";
              echo 'new Chart(document.getElementById("bar'.$i.'").getContext("2d")).Bar(barChartData'.$i.',{scaleOverride: true, scaleStartValue: 0, scaleStepWidth: '.$step.', scaleSteps: 6})'."\n\n";
            }
           
            ?>

          }();
          </script>
        </script> 
        <script>
          $(function(){
            $('select.styled').customSelect();
          });

        </script>

        </body>
</html>
