      </section>

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
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?=base_url('assets/js/jquery.js')?>"></script>
    <script src="<?=base_url('assets/js/jjquery-1.8.3.min.js')?>"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script class="include" type="text/javascript" src="<?=base_url('assets/js/jquery.dcjqaccordion.2.7.js')?>"></script>
    <script src="<?=base_url('assets/js/jquery.scrollTo.min.js')?>"></script>
    <script src="<?=base_url('assets/js/jquery.nicescroll.js')?>" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="<?=base_url('assets/js/common-scripts.js')?>"></script>

    <!--script for this page-->
    <script type="text/javascript" src="<?=base_url('assets/js/gritter/js/jquery.gritter.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/gritter-conf.js')?>"></script>
    
  <script>
      //custom select box
      $( ".changer" ).change(function() {
            // alert( "Handler for .change() called." );

              var field = document.getElementById("field").value;
              var semester = document.getElementById("semester").value;


              if (field != '' && semester != ''){
                document.getElementById("link").href = "<?=base_url()?>"+"pengampu/getKelasDanMapelAmpu/"+"<?=$this->session->userdata('kd_transaksi')?>"+"/"+"<?=$this->tahun_ajaran->getCurrentTA()?>"+"/"+field+"/"+semester;
                document.getElementById("linkButton").disabled = false;
              } else{
                document.getElementById("linkButton").disabled = true;
              }       
          }); 
      // $(function(){
      //     alert( "Handler for .change() called." );
      //     $('select.styled').customSelect();
      // });


  </script>
  <script type="text/javascript">

          

  </script> 
  </body>
</html>