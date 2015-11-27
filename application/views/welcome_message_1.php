<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>hide demo</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
<style>
.building{
width:100px;height:100px;
margin:10px;
background-color: yellow;
float:left;
}
#upGradingQue{
 color: red;
}
}
</style>
<h1>CITY : <?php echo $city;?></h1>
<div style="float:left;font-size:20px; width:300px">upGradingQue : <span id="upGradingQue"></span></div>
<div style="float:left;font-size:20px; width:300px">Total Points : <span id="totalPoints"></span></div>
<div style="float:left;font-size:20px; width:300px">Points Consume by City : <span id="consume_points"></span></div>
<div id="total-building">

</div>
 <div style="width:600px;height:400px;background-color: yellowgreen;" id="city-area"> 
 <p id="notification"></p>
 </div>
 <select id="buildig-type">
 <option value="Supermarket">Supermarket</option>
  <option value="town-hall">town hall</option>
   <option value="Restaurant">Restaurant</option>
    <option value="Expo-center">Expo center</option>
	<option value="Train-station">Train station</option>
   
 </select>
 <button>Add Building</button>
<script>
var upGradingQue=0;
var totalblds=0;
var cityBlds =[];
var totalPoints='<?php echo $totalPoints?>';
var consume_points = '<?php echo $consume_points ?>';
var city_id='<?php echo $city_id?>';
var existingBulding =JSON.parse('<?php echo $building?>');
        
$.each(existingBulding, function(i, val) {
    totalblds++;
    var statusTxt = "";
    if(val.status == "building"){
        statusTxt = "building process ..30";
        building(totalblds,val.building_type,val.level,'building');
        upGradingQue++;
    }else if(val.status == "Upgrading"){
        statusTxt = "Upgrading Bulding...30";
        upgradingBulding("building-" + totalblds,val.level,val.building_type);
        upGradingQue++;
    }else{
        statusTxt = 'Build :'+ val.building_type + '<br>Level :'+val.level;
    }
    cityBlds.push(val.building_type);
   $("#city-area").append('<div class="building" id="building-'+totalblds+'" bldingtype='+val.building_type+' level='+ val.level +' status="'+ val.status +'" counter="30">'+ statusTxt +'</div>');
  
});

$("#totalPoints").html(totalPoints);
$("#consume_points").html(consume_points);



function updateCityBuildingsAjax(bldType,level,status,operation){
	$.ajax({
	  method: "POST",
	  url: "<?php echo site_url('welcome/updateCityBuildingsAjax');?>",
	  data: { username: '<?php echo $username?>',bldType:bldType ,level:level,status:status,city_id:<?php echo $city_id?>,operation:operation}
	})
	  .done(function( msg ) {
		alert( "Data Saved: " + msg );
	  });
}


function updatePointsAjax(){
	$.ajax({
	  method: "POST",
	  url: "<?php echo site_url('welcome/updatUserPoints');?>",
	  data: { username: '<?php echo $username?>',totalPoints:totalPoints }
	})
	  .done(function( msg ) {
		alert( "Data Saved: " + msg );
	  });
}


function updatePoints()
{
	totalPoints++;
	$("#totalPoints").html(totalPoints);
	updatePointsAjax(totalPoints);
    setTimeout(updatePoints,  60000);
}

setTimeout(updatePoints,  60000);

function updateBldCounter()
{
	$( ".building" ).each(function( index ) {
	  if($(this).attr("status") != "done"){
		var currCount = $(this).attr("counter");

		currCount = currCount -1;
		if($(this).attr("status") == "building"){
			$(this).html("building process .."+ currCount);
		}else if($(this).attr("status") == "Upgrading"){
			$(this).html("Upgrading Bulding..."+ currCount);			
		}
		$(this).attr("counter",currCount);

		//$(this).attr("counter",currCount++);
	  }	  
	});
	
    setTimeout(updateBldCounter,  1000);
}

setTimeout(updateBldCounter,  1000);


$("#upGradingQue").html(upGradingQue);

function addbuilding(totalblds1,bldType,level,status){
  $("#notification").html('');
   $("#building-"+totalblds1).html('Build :'+bldType + '<br>Level :'+level);
   $("#building-"+totalblds1).attr("status","done");
   upGradingQue--;
    $("#upGradingQue").html(upGradingQue);
   updateCityBuildingsAjax(bldType,level,"done","upgrade");
  //$("button").prop("disabled", false);
}

$( document ).ready(function() {

	$('body').on('click', '.building', function() {
	  if($(this).attr('status') != "done"){
		alert('Wait ....');
		return false;
	  }
	  if(totalPoints < 1){
		  alert('No Points');
		  return false;
	  } 		
	  if(upGradingQue < 2){
		var level = $(this).attr("level");
		var bldType = $(this).attr("bldingtype");		
		upGradingQue++;
		totalPoints--;
                consume_points++;                
                $("#consume_points").html(consume_points);
		updatePointsAjax(totalPoints,'add');
		updateCityBuildingsAjax(bldType,level,"Upgrading","upgrade");
                updateCityConsumePoints(city_id,1);
		$("#totalPoints").html(totalPoints);
		$("#upGradingQue").html(upGradingQue);
		$("#"+ $(this).attr("id")).html("Upgrading Bulding..." + 30);
		$("#"+ $(this).attr("id")).attr("status","Upgrading")
		$("#"+ $(this).attr("id")).attr("counter",30)
		upgradingBulding($(this).attr("id"),level,bldType);
	  }else{
	   alert('que is full');
	  }
	});
});

function upgradeBulding(bldID,level,bldType){
  //alert(totalblds1);
 // alert(bldType);

  level++;
  $("#notification").html('');
   $("#"+bldID).html('Build :'+bldType + '<br>Level :'+level);
   $("#"+bldID).attr("level",level);
   $("#"+bldID).attr("status","done")
   upGradingQue--;
    $("#upGradingQue").html(upGradingQue);
	updateCityBuildingsAjax(bldType,level,"done","upgrade");
  //$("button").prop("disabled", false);
}

function upgradingBulding(bldID,level,bldType){
	setTimeout(function() {upgradeBulding(bldID,level,bldType);}, 30000);
}




$("button").on("click", function(){
  //var totalblds = $( "div.building" ).length;
  //alert(totalblds);
  
  var bldType = $("#buildig-type").val();  
  $("#total-building").html(cityBlds);
  if($.inArray(bldType,cityBlds) != -1){
	  alert('Bulding exists');
	  return false;  
  }
  cityBlds.push(bldType);
  
  if(totalblds > 4){
	  alert('limit 5 is reached');
	  return false;
  }
  if(totalPoints < 1){
	  alert('No Points');
	  return false;
  }  
  if(upGradingQue < 2 ){
  
	  upGradingQue++;
	  totalblds++;
	  totalPoints--;
          consume_points++;
	  var level = 0;
	  $("#consume_points").html(consume_points);
	  $("#totalPoints").html(totalPoints);
	  $("#notification").html("Adding building..");
	  updatePointsAjax(totalPoints);
	  updateCityBuildingsAjax(bldType,level,"building","add");
	  building(totalblds,bldType,level,'building');
          updateCityConsumePoints(city_id,1);
	  $("#city-area").append('<div class="building" id="building-'+totalblds+'" bldingtype='+bldType+' level='+ level +' status="building" counter="30">building process ..30</div>');
	  //$(this).prop("disabled", true);
	  $("#upGradingQue").html(upGradingQue);
  }else{
	  alert('que is full');
  }
});

function building(totalblds,bldType,level,status){
	setTimeout(function() {addbuilding(totalblds,bldType,level,status);}, 30000);
}

function updateCityConsumePoints(city_id,points){
    	$.ajax({
	  method: "POST",
	  url: "<?php echo site_url('welcome/updateCityConsumePoints');?>",
	  data: { city_id: city_id,points:points }
	})
	  .done(function( msg ) {
		alert( "Data Saved: " + msg );
	  });
    
}
</script>
 
</body>
</html>