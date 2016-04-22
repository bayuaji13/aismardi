      </section>

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 - Tulup Co.
              <a href="index.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?=base_url('assets/js/jquery.js')?>"></script>
    <script src="<?=base_url('assets/js/jjquery-1.8.3.min.js')?>"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script class="include" type="text/javascript" src="<?=base_url('assets/js/jquery.dcjqaccordion.2.7.js')?>"></script>
    <script src="<?=base_url('assets/js/jquery.scrollTo.min.js')?>"></script>
    <script src="<?=base_url('assets/js/jquery.nicescroll.js')?>" type="text/javascript"></script>

    <script type="text/javascript" src="<?=base_url('assets/js/jquery-1.8.3.min.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/fullcalendar/fullcalendar.min.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/moment.js')?>"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/js/fullcalendar/bootstrap-fullcalendar.css')?>" />
    <script type="text/javascript">
      $(document).ready(function() {
        $('#calendar').fullCalendar(<?=json_encode($data)?>)
      }
      )
    </script>
    <!--common script for all pages-->
    <script src="<?=base_url('assets/js/common-scripts.js')?>"></script>

    <!--script for this page-->
    <script type="text/javascript" src="<?=base_url('assets/js/gritter/js/jquery.gritter.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/gritter-conf.js')?>"></script>
    

  </body>
</html>