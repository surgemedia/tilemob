<?php
   $priceR  =  ($_GET['pr']!="")? $_GET['pr'] : 0;
?>
<script type="text/javascript" src="./scripts/jquery-1.8.2.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="scripts/simple-slider.js"></script>
<link href="styles/simple-slider.css" rel="stylesheet" type="text/css" />
<link href="styles/simple-slider-volume.css" rel="stylesheet" type="text/css" />  
<script type="text/javascript">
  $(document).ready(function(){
          if($("#category").val()!="" || $("#size").val()!="" || $("#colour").val()!="" || $("#surface").val()!="" || $("#sliprating").val() !="" || $("#peirating").val() !="" || $("#type").val()!="" || $("#pattern").val() != "" || $("#material").val() != "" || $("#thickness").val() != "" || $("#edge").val() != "")
          {
                  var str = $("#searchform").serialize(); 
                  ajxcall(str);
          }
      	  $("#category,#size,#colour,#surface,#sliprating,#peirating,#type,#pattern,#material,#thickness,#edge").change(function(){
             // $("#places").html('<option>Select</option>');
             var changed = $(this).attr('id');
           
             var str = $("#searchform").serialize();
	     var category = $(this).val();
             ajxcall(str,changed);
         
         
          
	 })
          function ajxcall(str,changed)
          {
             $.ajax
	     ({
		   type: "POST",
		   url : "includes/ajax/sizes.php",
		   data: str,
                   dataType:"json",
		   cache :false,
		   success: function(res)
		   {
                       //alert(res);
                       //if($("#category").val() === ""){
                           if(changed != "category"){
                               $("#category").html(res.category);
                           }
                      // }
                     //  if ( $("#size").val() === "" ){
                       if(changed !="size"){
                       $("#size").html(res.size);
                       }
                      // }
                      // if ( $("#colour").val() === "" ){
                       if(changed !="colour"){
                       $("#colour").html(res.color);
                       }
                      // }
                      // if ( $("#surface").val() === "" ){
                       if(changed !="surface"){
                       $("#surface").html(res.surface);
                       }
                      // }
                      // if ( $("#sliprating").val() === "" ){
                       if(changed !="sliprating"){
                       $("#sliprating").html(res.sliprating);
                       }
                       //}
                       if(changed !="peirating"){
                       $("#peirating").html(res.peirating);
                       }
                       if(changed !="type"){
                       $("#type").html(res.type);
                       }
                       if(changed !="pattern"){
                       $("#pattern").html(res.pattern);
                       }
                       if(changed !="material"){
                       $("#material").html(res.material);
                       }
                       if(changed !="thickness"){
                       $("#thickness").html(res.thickness);
                       }
                       if(changed !="edge"){
                       $("#edge").html(res.edge);
                       }
                      
		   }
	      })
          }
	  
  })

</script>
<div id="finder" class="finder">	
	<div id="finder_form" class="finder_form">
		<h1>I'm looking for tiles</h1>
		<form id="searchform" name="searchform" method="post" onsubmit="">
		<div class="field_title">Keywords</div>
		<input type="text" id="keywords" name="keywords" value="<?php echo trim(urldecode($_GET['ke'])); ?>" class="textfield1">		
		<div id="finder_more_options" class="moreoptions">
			<!-- More search options #1 -->
			<div class="field_title">Category/Use</div>
			<select id="category" name="category" class="select1" onchange="updateFinderSelect()">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				//$result_use = mysql_query("SELECT * FROM shop_use WHERE is_active='1'");
                                $result_use = mysql_query("SELECT sw.Use,sus.* FROM shop_webitems as sw INNER JOIN  shop_use as sus ON sw.Use = sus.Code WHERE sus.is_active='1' GROUP BY sw.Use");
				while($row_use = mysql_fetch_array($result_use)) {
					$use_code = $row_use['Code'];
					$selected_use = trim(urldecode($_GET['ca']));
					if($use_code==$selected_use){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$use_code.'"'.$option_selected.'>'.$row_use['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
            <div>
            <div class="field_title">Set max price ( in m<sup>2</sup> or pcs )</div>
            <div class="slider" style="margin-left:0px;"></div>
            <input type="text" data-slider="true" id="txtPriceRange" data-slider-range="0,500" data-slider-step="10">
            <input type="hidden" name="pricerange" id="pricerange" class="output" />
             <input type="hidden" name="priceR" id="priceR" value=<?=$priceR?> />
            <span class="sign" style="float:left;">$</span><span class="output"></span>
            </div>
            
            
			<div class="field_title">Size</div>
			<select id="size" name="size" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_size = mysql_query("SELECT * FROM shop_size WHERE is_active='1'");
				while($row_size = mysql_fetch_array($result_size)) {
					$size_code = $row_size['Code'];
					$selected_size = trim(urldecode($_GET['si']));
					if($size_code==$selected_size){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$size_code.'"'.$option_selected.'>'.$row_size['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">Surface Finish</div>
			<select id="surface" name="surface" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_surface = mysql_query("SELECT * FROM shop_surface WHERE is_active='1'");
				while($row_surface = mysql_fetch_array($result_surface)) {
					$surface_code = $row_surface['Code'];
					$selected_surface = trim(urldecode($_GET['su']));
					if($surface_code==$selected_surface){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$surface_code.'"'.$option_selected.'>'.$row_surface['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">Colour Group</div>
			<select id="colour" name="colour" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_colour = mysql_query("SELECT * FROM shop_colour WHERE is_active='1'");
				while($row_colour = mysql_fetch_array($result_colour)) {
					$colour_code = $row_colour['Code'];
					$selected_colour = trim(urldecode($_GET['co']));
					if($colour_code==$selected_colour){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$colour_code.'"'.$option_selected.'>'.$row_colour['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			
			<div class="field_title">Slip Rating</div>
			<select id="sliprating" name="sliprating" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_sliprating = mysql_query("SELECT * FROM shop_sliprating WHERE is_active='1'");
				while($row_sliprating = mysql_fetch_array($result_sliprating)) {
					$sliprating_code = $row_sliprating['Code'];
					$selected_sliprating = trim(urldecode($_GET['sl']));
					if($sliprating_code==$selected_sliprating){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$sliprating_code.'"'.$option_selected.'>'.$row_sliprating['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">PEI Rating</div>
			<select id="peirating" name="peirating" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_peirating = mysql_query("SELECT * FROM shop_peirating WHERE is_active='1'");
				while($row_peirating = mysql_fetch_array($result_peirating)) {
					$peirating_code = $row_peirating['Code'];
					$selected_peirating = trim(urldecode($_GET['pe']));
					if($peirating_code==$selected_peirating){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$peirating_code.'"'.$option_selected.'>'.$row_peirating['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">Type</div>
			<select id="type" name="type" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_type = mysql_query("SELECT * FROM shop_type WHERE is_active='1'");
				while($row_type = mysql_fetch_array($result_type)) {
					$type_code = $row_type['Code'];
					$selected_type = trim(urldecode($_GET['ty']));
					if($type_code==$selected_type){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$type_code.'"'.$option_selected.'>'.$row_type['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">Pattern</div>
			<select id="pattern" name="pattern" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_pattern = mysql_query("SELECT * FROM shop_pattern WHERE is_active='1'");
				while($row_pattern = mysql_fetch_array($result_pattern)) {
					$pattern_code = $row_pattern['Code'];
					$selected_pattern = trim(urldecode($_GET['pa']));
					if($pattern_code==$selected_pattern){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$pattern_code.'"'.$option_selected.'>'.$row_pattern['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">Material</div>
			<select id="material" name="material" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_material = mysql_query("SELECT * FROM shop_material WHERE is_active='1'");
				while($row_material = mysql_fetch_array($result_material)) {
					$material_code = $row_material['Code'];
					$selected_material = trim(urldecode($_GET['ma']));
					if($material_code==$selected_material){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$material_code.'"'.$option_selected.'>'.$row_material['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">Thickness</div>
			<select id="thickness" name="thickness" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_thickness = mysql_query("SELECT * FROM shop_thickness WHERE is_active='1'");
				while($row_thickness = mysql_fetch_array($result_thickness)) {
					$thickness_code = $row_thickness['Code'];
					$selected_thickness = trim(urldecode($_GET['th']));
					if($thickness_code==$selected_thickness){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$thickness_code.'"'.$option_selected.'>'.$row_thickness['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>
			<div class="field_title">Edge</div>
			<select id="edge" name="edge" class="select1">
				<option value="">No preference</option>
				<?php
				$options_string = '';
				$result_edge = mysql_query("SELECT * FROM shop_edge WHERE is_active='1'");
				while($row_edge = mysql_fetch_array($result_edge)) {
					$edge_code = $row_edge['Code'];
					$selected_edge = trim(urldecode($_GET['ed']));
					if($edge_code==$selected_edge){$option_selected=' SELECTED';}else{$option_selected='';}
					$options_string .= '<option value="'.$edge_code.'"'.$option_selected.'>'.$row_edge['Description'].'</option>';
				}
				echo $options_string;
				?>
			</select>			
			<div class="clear"></div>
		</div>
		<input type="button" id="restfields" name="restfields" value="Reset form" onclick="resetTileFinderForm();" class="button1-left">
		<input type="submit" id="findtiles" name="findtiles" value="Find tiles" class="button1-right">
		</form>
		<div class="clear"></div>
		<div id="morelink" class="morelink"><a href="javascript:void(0);" title="More search options" onclick="moreTileFinderOptions();"><span id="finder_more_link_text">› More search options</span></a></div>		
	</div>
	<div class="clear"></div>
</div>

<script>
  $("[data-slider]")
    .each(function () {
      var input = $(this);
	  $("<span>")
        .addClass("output")
        .insertAfter($(this));
		
    })
    .bind("slider:ready slider:changed", function (event, data) {
      $(this)
        .nextAll(".output:first")
          .html(data.value.toFixed(2));
    });
  </script>
 <script type="text/javascript">
 $(document).ready(function(){
	 
	 var pr = $("#priceR").val();
	 
	/* var pr = GetQueryStringParams('pr');
	 if(pr = "undefined")
	 {		 
		 pr = 10;
	 }
	 else if(pr != "undefined")
	 {		 
		 var pr = GetQueryStringParams('pr');
	 }*/
	 $('#txtPriceRange').simpleSlider('setValue',pr);
	 var priceBeforeSearch = $('#txtPriceRange').val();
	 $("#pricerange").val(priceBeforeSearch);
	 $(".dragger").click(function(){
		var price = $("span.output").text();
		$("#pricerange").val(price);
	 })
         var sPath=window.location.pathname;
         var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);   
         
	 //alert(document.location.search.length);
	  if(document.location.search.length) {
	     if(sPage == "tile-finder.php")
                 {
             moreTileFinderOptions('show');
                 }
      } else {
        // no query string exists
      }
	  function GetQueryStringParams(sParam)
      {
          var sPageURL = window.location.search.substring(1);
          var sURLVariables = sPageURL.split('&');
          for (var i = 0; i < sURLVariables.length; i++) 
          {
        	 var sParameterName = sURLVariables[i].split('=');
        	 if (sParameterName[0] == sParam) 
        	 {
           		 return sParameterName[1];
        	 }
          }
      }
	  
   })
 </script>
  