<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>City Builder Game</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body><div align="center">
    <h1>City Builder Game</h1>
    <table border="1" width="100%">
        <tr>
            
            <td colspan="3">Create New City : <form method="post" action="<?php echo site_url('welcome')?>">
                    <input type="text" name="city_name" >
                    <input type="submit" name="create" value="create">
                </form>
            </td >
            <td colspan="1">Total Earned Points : <h2>&#36;<?php echo $totalPoints?></h2>Start building city for earning more points</td>
        </tr>
        <tr style="font-weight: bold">
            <td>City Name</td>
            <td>Consume Points</td>
            <td>Building Status</td>
            <td>Build City</td>            
        </tr>
        <?php
           foreach ($cities as $value) {
              // print_r($buildings[$value['id']]);
               if(array_key_exists($value['id'], $buildings) && !is_null($buildings[$value['id']] && array_key_exists('done', $buildings[$value['id']]))){
                   $builtCount =  @count($buildings[$value['id']]['done']);
               }else{
                   $builtCount = 0;                   
               }
               
               if(array_key_exists($value['id'], $buildings) && !is_null($buildings[$value['id']] && array_key_exists('Upgrading', $buildings[$value['id']]))){
                   $UpgradingCount =  @count($buildings[$value['id']]['Upgrading']);
               }else{
                   $UpgradingCount = 0;                   
               }
               
                if(array_key_exists($value['id'], $buildings) && !is_null($buildings[$value['id']] && array_key_exists('building', $buildings[$value['id']]))){
                    $buildingCount =  @count($buildings[$value['id']]['building']);
                }else{
                    $buildingCount = 0;                   
                }
                  echo '<tr>';
                  echo '<td>'.$value['name'].'</td>';
                  echo '<td>&#36;'.$value['consume_points'].'</td>';
                  echo '<td>Build :'.$builtCount.'<br>Upgrading :'.$UpgradingCount.'<br>Building :'.$buildingCount.'</td>';
                  echo '<td><a href="'.site_url('welcome/builder?city_id='.$value['id']).'">Start Building</a></td>';                  
                  echo '</tr>';
           }
        ?>
        
        
    </table>
</div></body>
</html>