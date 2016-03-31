</div><!--//wrapper-->
    
    <!-- ******FOOTER****** --> 
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
                <div class="row">
                <div class="footer-col col-md-3 col-sm-4 about">
                    <div class="footer-col-inner">
                        <h3>Tautan</h3>
                        <ul>
                        <?php 
							foreach ($daftarTautan as $tautan){
								echo "<li><a href='".$tautan['linkUrl']."'><i class='fa fa-caret-right'></i>".$tautan['linkName']."</a></li>";
							}
						?>
                        </ul>
                    </div><!--//footer-col-inner-->
                </div><!--//foooter-col-->
                <div class="footer-col col-md-6 col-sm-8 newsletter">
                    <div class="footer-col-inner">
                        <h3>Lokasi</h3>
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.4912871827637!2d110.4115813143288!3d-7.068894671244509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7089456430d6ab%3A0xee8a0b66bbafc430!2sSMA+Mardisiswa!5e0!3m2!1sid!2sid!4v1454392654059" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div><!--//footer-col-inner-->
                </div><!--//foooter-col--> 
                <div class="footer-col col-md-3 col-sm-12 contact">
                    <div class="footer-col-inner">
                        <h3>Kontak</h3>
                        <div class="row">
                            <p class="adr clearfix col-md-12 col-sm-4">
                                <i class="fa fa-map-marker pull-left"></i>        
                                <span class="adr-group pull-left">       
                                    <span class="street-address">Jl. Mardisiswa</span><br>
                                    <span class="region">Semarang, Jawa Tengah</span><br>
                                    <span class="postal-code">15561</span><br>
                                    <span class="country-name">Indonesia</span>
                                </span>
                            </p>
                            <p class="tel col-md-12 col-sm-4"><i class="fa fa-phone"></i>0800 123 4567</p>
                            <p class="email col-md-12 col-sm-4"><i class="fa fa-envelope"></i><a href="#">info@smamardisiswa.sch.id</a></p>  
                        </div> 
                    </div><!--//footer-col-inner-->            
                </div><!--//foooter-col-->   
                </div>   
            </div>        
        </div><!--//footer-content-->
        <div class="bottom-bar">
            <div class="container">
                <div class="row">
                    <small class="copyright col-md-6 col-sm-12 col-xs-12">Copyright @ 2016 SMA Mardisiswa Semarang | Website powered by <a href="#">Ketampanan</a></small>
                </div><!--//row-->
            </div><!--//container-->
        </div><!--//bottom-bar-->
    </footer><!--//footer-->
    
    <!-- *****CONFIGURE STYLE****** -->  
    <div class="config-wrapper hidden-xs">
        <div class="config-wrapper-inner">
            <a id="config-trigger" class="config-trigger" href="#"><i class="fa fa-cog"></i></a>
            <div id="config-panel" class="config-panel">
                <p>Choose Colour</p>
                <ul id="color-options" class="list-unstyled list-inline">
                    <li class="default active" ><a data-style="assets/css/frontpage/styles.css" data-logo="assets/images/logo.png" href="#"></a></li>
                    <li class="green"><a data-style="assets/css/frontpage/styles-green.css" data-logo="assets/images/logo-green.png" href="#"></a></li>
                    <li class="purple"><a data-style="assets/css/frontpage/styles-purple.css" data-logo="assets/images/logo-purple.png" href="#"></a></li>
                    <li class="red"><a data-style="assets/css/frontpage/styles-red.css" data-logo="assets/images/logo-red.png" href="#"></a></li>
                </ul><!--//color-options-->
                <a id="config-close" class="close" href="#"><i class="fa fa-times-circle"></i></a>
            </div><!--//configure-panel-->
        </div><!--//config-wrapper-inner-->
    </div><!--//config-wrapper-->
 
    <!-- Javascript -->          
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.11.2.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-hover-dropdown.min.js');?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/back-to-top.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-placeholder/jquery.placeholder.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/pretty-photo/js/jquery.prettyPhoto.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/flexslider/jquery.flexslider-min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/jflickrfeed/jflickrfeed.min.js')?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/main.js')?>"></script>            
</body>
</html> 