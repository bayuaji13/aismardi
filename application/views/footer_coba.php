

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
        <script>
          var Script = function () {


            var barChart = <?php echo $chart1, $chart2;?>;
            new Chart(document.getElementById("doughnut").getContext("2d")).Bar(barChart);
            new Chart(document.getElementById("doughnut1").getContext("2d")).Doughnut(doughnutData);
            new Chart(document.getElementById("doughnut2").getContext("2d")).Doughnut(doughnutData);
          }();
          
        </script>
        //custom select box
        <script>
          $(function(){
            $('select.styled').customSelect();
          });

        </script>

        </body>
        </html>
