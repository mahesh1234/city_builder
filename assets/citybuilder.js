/*
 * 
 * City Builder JS
 */

/*
 * Polotting existing building
 * existingBulding : Existing building in JSON format
 */
$.each(existingBulding, function(i, val) {
    totalblds++;
    var statusTxt = "";
    if(val.status == "building"){
        statusTxt = "<img src='"+ loadingImage +"'>building process ..30";
        building(totalblds,val.building_type,val.level,'building');
        upGradingQue++;
    }else if(val.status == "Upgrading"){
        statusTxt = "<img src='"+ loadingImage +"'>Upgrading Bulding...30";
        upgradingBulding("building-" + totalblds,val.level,val.building_type);
        upGradingQue++;
    }else{
        statusTxt = 'Build : '+ val.building_type + '<br>Level : '+val.level + '<br><br><br><button class="btn-upgrade">Upgrade</button>';
    }
    cityBlds.push(val.building_type);
   $("#city-area").append('<div class="building" id="building-'+totalblds+'" bldingtype='+val.building_type+' level='+ val.level +' status="'+ val.status +'" counter="30">'+ statusTxt +'</div>');
  
});

$("#totalPoints").html(totalPoints); /*Update total Points on UI*/
$("#consume_points").html(consume_points); /*Update total Points cosume by selected city on UI*/
$("#upGradingQue").html(upGradingQue);

/*
 * updatePointsAjax for updating user points in DB.
 * This is the monitoring function.Will run in background after evert 1 Mins(60000 mili seconds)
 * 
 */

function updatePointsAjax(){
	$.ajax({
	  method: "POST",
	  url: SITE_URL + '/welcome/updatUserPoints',
	  data: { username: userName,totalPoints:totalPoints }
	})
}


function updatePoints()
{
	totalPoints++;
	$("#totalPoints").html(totalPoints);
	updatePointsAjax(totalPoints);
    setTimeout(updatePoints,  60000);
}

setTimeout(updatePoints,  60000);

/*==========================================*/

/*
 * This is the monitoring function for mainting City Building/Upgrading countdown of 30 secs
 * This runs on every seconds
 */



function updateBldCounter()
{
	$( ".building" ).each(function( index ) {
	  if($(this).attr("status") != "done"){
		var currCount = $(this).attr("counter");

		currCount = currCount -1;
		if($(this).attr("status") == "building"){
			$(this).html("<img src='"+ loadingImage +"'>building process .."+ currCount);
		}else if($(this).attr("status") == "Upgrading"){
			$(this).html("<img src='"+ loadingImage +"'>Upgrading Bulding..."+ currCount);			
		}
		$(this).attr("counter",currCount);

		//$(this).attr("counter",currCount++);
	  }	  
	});
	
    setTimeout(updateBldCounter,  1000);
}

setTimeout(updateBldCounter,  1000);

/*==========================================*/



/*
 * This is gets triggred when user add new building to the city
 * This checks if city has selected building and give error accordingly
 * 
 */

$("button#addbuilding").on("click", function(){

  
  var bldType = $("#buildig-type").val();  
  
  if($.inArray(bldType,cityBlds) != -1){ /*Check if building exists*/
	  alert('Bulding exists');
	  return false;  
  }
  cityBlds.push(bldType);
  
  if(totalblds > 4){  /*Check max number number of bulding*/
	  alert('limit 5 is reached');
	  return false;
  }
  if(totalPoints < 1){   /*Check if user has required points to add building*/
	  alert('No Points');
	  return false;
  }  
  if(upGradingQue < 2 ){  /*Check que*/
  
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
	  $("#city-area").append('<div class="building" id="building-'+totalblds+'" bldingtype='+bldType+' level='+ level +' status="building" counter="30"><img src="'+ loadingImage +'">building process ..30</div>');
	  //$(this).prop("disabled", true);
	  $("#upGradingQue").html(upGradingQue);
  }else{
	  alert('que is full');
  }
});

/*
 * 
 * This function get automaticaly called after 30 secs when bulding is ready
 */
function building(totalblds,bldType,level,status){
	setTimeout(function() {addbuilding(totalblds,bldType,level,status);}, 30000);
}

function addbuilding(totalblds1,bldType,level,status){
  $("#notification").html('');
   $("#building-"+totalblds1).html('Build : '+bldType + '<br>Level : '+level);
   $("#building-"+totalblds1).attr("status","done");
   upGradingQue--;
    $("#upGradingQue").html(upGradingQue);
   updateCityBuildingsAjax(bldType,level,"done","upgrade");
  //$("button").prop("disabled", false);
}


/*This functions are for city upgradation.*/

$( document ).ready(function() {

	$('body').on('click', '.btn-upgrade', function() {
	  if($(this).parent().attr('status') != "done"){
		alert('Wait ....');
		return false;
	  }
	  if(totalPoints < 1){
		  alert('No Points');
		  return false;
	  } 		
	  if(upGradingQue < 2){
		var level = $(this).parent().attr("level");
		var bldType = $(this).parent().attr("bldingtype");		
		upGradingQue++;
		totalPoints--;
                consume_points++;                
                $("#consume_points").html(consume_points);
		updatePointsAjax(totalPoints,'add');
		updateCityBuildingsAjax(bldType,level,"Upgrading","upgrade");
                updateCityConsumePoints(city_id,1);
		$("#totalPoints").html(totalPoints);
		$("#upGradingQue").html(upGradingQue);
		$("#"+ $(this).parent().attr("id")).html("<img src='"+ loadingImage +"'>Upgrading Bulding..." + 30);
		$("#"+ $(this).parent().attr("id")).attr("status","Upgrading")
		$("#"+ $(this).parent().attr("id")).attr("counter",30)
		upgradingBulding($(this).parent().attr("id"),level,bldType);
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
   $("#"+bldID).html('Build : '+bldType + '<br>Level : '+level);
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





/*This is the Ajax function for updating building status*/

function updateCityBuildingsAjax(bldType,level,status,operation){
	$.ajax({
	  method: "POST",
	  url: SITE_URL + '/welcome/updateCityBuildingsAjax',
	  data: { username: userName,bldType:bldType ,level:level,status:status,city_id:city_id,operation:operation}
	})
}


/*This is the Ajax function for updating points cosume by the city*/

function updateCityConsumePoints(city_id,points){
    	$.ajax({
	  method: "POST",
	  url: SITE_URL + '/welcome/updateCityConsumePoints',
	  data: { city_id: city_id,points:points }
	})
    
}
