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
  	  function getMenu(hasil){
  		$.ajax({
			url:"<?php echo base_url("menuajax/getMenuAjax/");?>",
			method: "post",
			dataType: 'json',
			beforeSend: function( xhr ) {
				$("#div_loader").show();
			},
			success: function(response){
				$("#div_loader").hide();
				hasil(response);
			}
		}).always(function(){
			$("#div_loader").hide();
		});
  	  }
  	  
	  $(document).ready(function() {
		getMenu(function(respons){
			var $domenu            = $('#domenu-1'),
	        domenu             = $('#domenu-1').domenu(),
	        $simpan   = $('#simpan');
	        //$outputContainer   = $('#domenu-1-output'),
	        //$jsonOutput        = $outputContainer.find('.jsonOutput'),
	        //$keepChanges       = $outputContainer.find('.keepChanges'),
	        //$clearLocalStorage = $outputContainer.find('.clearLocalStorage');
		
		    $domenu.domenu({
		        slideAnimationDuration: 0,
		        select2:                {
		          support: true,
		          params:  {
		            tags: true
		          }
		        },
		        data: JSON.stringify(respons)
			        
		      })
		      // Example: initializing functionality of a custom button #21
		      .onCreateItem(function(blueprint) {
		        // We look with jQuery for our custom button we denoted with class "custom-button-example"
		        // Note 1: blueprint holds a reference of the element which is about to be added the list
		        var customButton = $(blueprint).find('.custom-button-example');
		
		        // Here we define our custom functionality for the button,
		        // we will forward the click to .dd3-content span and let
		        // doMenu handle the rest
		        customButton.click(function() {
		          blueprint.find('.dd3-content span').first().click();
		        });
		      })
		      // Now every element which will be parsed will go through our onCreateItem event listener, and therefore
		      // initialize the functionality our custom button
		      .parseJson()
		      .on(['onItemCollapsed', 'onItemExpanded', 'onItemAdded', 'onSaveEditBoxInput', 'onItemDrop', 'onItemDrag', 'onItemRemoved', 'onItemEndEdit'], function(a, b, c) {
		        //$jsonOutput.val(domenu.toJson());
		        //if($keepChanges.is(':checked')) window.localStorage.setItem('domenu-1Json', domenu.toJson());
		      })
		      .onToJson(function() {
		        //if(window.localStorage.length) $clearLocalStorage.show();
		      });

		      $simpan.click(function(){
		    	  var data = JSON.parse(domenu.toJson());
		    	  $.ajax({
		  			url:"<?php echo base_url("menuajax/saveMenuAjax/");?>",
		  			data: {data: data},
		  			type: "post",
		  			dataType: 'json',
		  			beforeSend: function( xhr ) {
		  				$("#div_loader").show();
		  			},
		  			success: function(response){
		  				$("#div_loader").hide();
		  				
		  			}
		  		}).always(function(){
		  			$("#div_loader").hide();
		  		});
			  });
		
		    //if(window.localStorage.length) $clearLocalStorage.show();
		});
	  });
	</script>
	
	
	<script src="<?=base_url('assets/js/jquery.domenu-0.95.77.js')?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
	
	<script async defer id="github-bjs" src="https://buttons.github.io/buttons.js"></script> 
  </body>
</html>