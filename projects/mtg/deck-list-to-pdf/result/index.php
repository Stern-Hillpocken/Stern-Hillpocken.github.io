<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>deck-list-result</title>
        <style type="text/css">
          table{
            background-color: black;
            border-collapse: collapse;
          }
          img{
            min-height: 370px;
            min-width: 265px;
          }
        </style>

        <?php
        //VARIABLES
        $cardNumber = array();
        $cardName = array();
        $imgLink = array();

        //GREP NAME AND VALUE
        if($_POST['text'] != ""){
          $text = preg_split('/
/', $_POST['text']);
          for($i = 0; $i < count($text); $i++){
            if($text[$i] != ""){
              preg_match('/\d+/', $text[$i], $nu);
              if($nu){
                $number = $nu[0];
                preg_match('/\d+\s(.+)/', $text[$i], $na);
              }else{
                $number = 1;
                preg_match('/^(.+)/', $text[$i], $na);
              }
              
              if(strlen($na[1]) != 1){//avoid empty lines
                array_push($cardNumber, $number);
                $name = $na[1];
                if($i < count($text)-1){
                  $name = substr($na[1], 0, strlen($na[1])-1);
                }
                for($j = 0; $j < $number; $j ++){
                  array_push($cardName, $name);
                }
              }

            }
          }
        }

        //SEARCH IMG LINK
        for($i = 0; $i < count($cardName); $i ++){
          if($_POST['lang'] == "en"){
            $strJSON = file_get_contents('https://api.scryfall.com/cards/search?q=name:%22'.strtolower($cardName[$i]).'%22');
            $arrayJSON = json_decode($strJSON, true);
            for($j = 0; $j < $arrayJSON['total_cards']; $j ++){
              if($arrayJSON['data'][$j]['name'] == $cardName[$i]){
                array_push($imgLink, $arrayJSON['data'][$j]['image_uris']['normal']);
              }else if(preg_match('/^'.$cardName[$i].' \\/\\/ /', $arrayJSON['data'][$j]['name'])){
                if(isset($arrayJSON['data'][$j]['image_uris'])){//flip
                  array_push($imgLink, $arrayJSON['data'][$j]['image_uris']['normal']);
                }else{//double sided
                  array_push($imgLink, $arrayJSON['data'][$j]['card_faces'][0]['image_uris']['normal']);
                  array_push($imgLink, $arrayJSON['data'][$j]['card_faces'][1]['image_uris']['normal']);
                }
              }
            }
          }else{
            $strJSON = file_get_contents('https://api.magicthegathering.io/v1/cards?name='.preg_replace('/ /', '%20', $cardName[$i]));
            $arrayJSON = json_decode($strJSON, true);

if($_POST['lang-age'] == "fr-old"){
            for($cN = 0; $cN < count($arrayJSON['cards']); $cN ++){//CHANGE
              if(($arrayJSON['cards'][$cN]['name'] == $cardName[$i] || preg_match('/^'.$cardName[$i].' \\/\\/ /', $arrayJSON['cards'][$cN]['name'])) && isset($arrayJSON['cards'][$cN]['foreignNames'])){
                $cCnFn = count($arrayJSON['cards'][$cN]['foreignNames']);
                for($fN = 0; $fN < $cCnFn; $fN ++){
                  if(isset($arrayJSON['cards'][$cN]['foreignNames'][$fN]['language']) && $arrayJSON['cards'][$cN]['foreignNames'][$fN]['language'] == "French" && isset($arrayJSON['cards'][$cN]['foreignNames'][$fN]['multiverseid'])){
                    array_push($imgLink, 'https://gatherer.wizards.com/Handlers/Image.ashx?multiverseid='.$arrayJSON['cards'][$cN]['foreignNames'][$fN]['multiverseid'].'&type=card');
                    if($arrayJSON['cards'][$cN]['layout'] == "modal_dfc"){
                      array_push($imgLink, 'https://gatherer.wizards.com/Handlers/Image.ashx?multiverseid='.($arrayJSON['cards'][$cN]['foreignNames'][$fN]['multiverseid']+1).'&type=card');
                    }
                    $fN = count($arrayJSON['cards'][$cN]['foreignNames']);//end
                    $cN = count($arrayJSON['cards']);//end //CHANGE
                  }
                }
              }
            }
}else{
            for($cN = count($arrayJSON['cards'])-1; $cN >= 0; $cN --){//CHANGE
              if(($arrayJSON['cards'][$cN]['name'] == $cardName[$i] || preg_match('/^'.$cardName[$i].' \\/\\/ /', $arrayJSON['cards'][$cN]['name'])) && isset($arrayJSON['cards'][$cN]['foreignNames'])){
                $cCnFn = count($arrayJSON['cards'][$cN]['foreignNames']);
                for($fN = 0; $fN < $cCnFn; $fN ++){
                  if(isset($arrayJSON['cards'][$cN]['foreignNames'][$fN]['language']) && $arrayJSON['cards'][$cN]['foreignNames'][$fN]['language'] == "French" && isset($arrayJSON['cards'][$cN]['foreignNames'][$fN]['multiverseid'])){
                    array_push($imgLink, 'https://gatherer.wizards.com/Handlers/Image.ashx?multiverseid='.$arrayJSON['cards'][$cN]['foreignNames'][$fN]['multiverseid'].'&type=card');
                    if($arrayJSON['cards'][$cN]['layout'] == "modal_dfc"){
                      array_push($imgLink, 'https://gatherer.wizards.com/Handlers/Image.ashx?multiverseid='.($arrayJSON['cards'][$cN]['foreignNames'][$fN]['multiverseid']+1).'&type=card');
                    }
                    $fN = count($arrayJSON['cards'][$cN]['foreignNames']);//end
                    $cN = -1;//end //CHANGE
                  }
                }
              }
            }
}

          }
        }

        //DISPLAY
        echo "<table><tr>";
        for($i = 0; $i < count($imgLink); $i ++){
          if($i != 0 && $i%3 === 0){
            echo "</tr><tr>";
          }
          echo '<td><img src="'.$imgLink[$i].'"/></td>';
        }
        echo "</tr></table>";

        ?>
    </head>

    <body>
    </body>
</html>
