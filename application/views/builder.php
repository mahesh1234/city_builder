<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>City Builder Game</title>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

    </head>
      
    <body>
        <style>
        .building{
            width:150px;height:150px;
            margin:10px;
            background-color: yellow;
            float:left;
        }
        #upGradingQue{
            color: red;
        }
        .header{
            font-size:14px; width:800px;
        }   
        .info{
            float: left;
            width:150px;
            margin: 20px;
        }
    </style>  
        <div align="center">
            <h1>CITY : <?php echo $city; ?></h1>
     <span style="float:left"><a href="<?php echo site_url()?>">&Lt; Home </a></span>
            <div class="header">
                
                <div class="info">
                    Building in Que : <h2><span id="upGradingQue"></span></h2>
                </div>
                <div class="info">
                    Points Consumed by this City : <h2>&#36;<span id="consume_points"></span></h2>
                </div>
                <div class="info">
                    Total Points : <h2>&#36;<span id="totalPoints"></span></h2>
                </div>  
                <div class="info">
                    Add new Building
                    <select id="buildig-type">
                        <option value="Supermarket">Supermarket</option>
                        <option value="town-hall">town hall</option>
                        <option value="Restaurant">Restaurant</option>
                        <option value="Expo-center">Expo center</option>
                        <option value="Train-station">Train station</option>

                    </select>
                    <button id="addbuilding">Add Building</button>
                </div>             
            </div>
            <div style="clear:both"></div>
            <div style="width:800px;height:400px;background-color: yellowgreen;" id="city-area"> 
                <p id="notification"></p>
            </div>

        </div>
<!--
Intialize JS Variable.
-->
        <script>
            var upGradingQue = 0;
            var totalblds = 0;
            var cityBlds = [];
            var totalPoints = '<?php echo $totalPoints ?>';
            var consume_points = '<?php echo $consume_points ?>';
            var city_id = '<?php echo $city_id ?>';
            var existingBulding = JSON.parse('<?php echo $building ?>');
            var SITE_URL = '<?php echo site_url(); ?>';
            var userName = '<?php echo $username ?>';
            var loadingImage ='<?php echo base_url('assets/small_loading.gif')?>'

        </script>
        <script src="<?php echo base_url('assets/citybuilder.js') ?>"></script>

    </body>
</html>