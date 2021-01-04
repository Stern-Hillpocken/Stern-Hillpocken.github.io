<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <style type="text/css">
        	body{
        		background-color: white;
        	}
        	h1{
        		color: white;
        		font-size: 4em;
        		text-align: center;
        	}
        	table.card{
        		border: 2px solid black;
        		margin: auto;
        		margin-bottom: 24px;
        		width: 50%;
        	}
        	th{
        		color: white;
        		font-size: 2em;
        	}
        	td{
        		width:50%;
        	}
        </style>
        <title>Liste de jeux de société</title>
    </head>

<?php
function grab($site, $start, $end, $realStart, $length){
	//$length = strpos($site, '</body>') - strpos($site, $start);
	if($length == "longstr"){$length = 800;}
	else if($length == "shortstr"){$length = 100;}
	else if($length == "megastr"){$length = 5000;}
	else{$length = 500;}
	$rste = substr($site, strpos($site, $start), $length); //row start to end
	//$img = substr($rste, strpos($rste, $realStart), strpos($rste, $end)-strlen($realStart));
	$cuthead = substr($rste, strpos($rste, $realStart), $length);
	$img = substr($cuthead, (strpos($cuthead, $realStart)+strlen($realStart)), (strpos($cuthead, $end)-strlen($realStart)));
	return $img;
}

function echoTable($game, $title, $color){

	echo "<h1 style='background-color:".$color."'>".$title."</h1>";
	for($i=0; $i<count($game); $i++){

		$site = file_get_contents('https://www.philibertnet.com/fr/'.$game[$i][1].'.html');
		$name = preg_replace('#^[a-z0-9-]*/[0-9]*-#', '', $game[$i][1]);
		$name = preg_replace('#-[0-9]*$#', '', $name);

		$img = grab($site, '<meta property="og:image"', '" />', ' content="', 'longstr');
		$nbPlayers = grab($site, '<li class="nb_joueurs tooltips" title="Nombre de joueurs">', ' joueur', '<span>', 'shortstr');
		$age = grab($site, '<span>&agrave; partir de ', ' ans', 'de ', 'shortstr');
		if(preg_match("#Mécanisme#", $site)){
		$meca = grab($site, '<td>Mécanisme(s)</td>', ' </td>', '</td>
<td>', 'longstr');//Importance du retour à la ligne
		$meca = preg_replace('/<a[^>]*>/i', '', $meca);
		$meca = preg_replace('#</a>#', '', $meca);
		}else{$meca = "";}
		$price = grab($site, 'var productPriceWithoutReduction =', ';', ' = ', 'shortstr');
		$links = "<a href=https://ludovox.fr/jeu-de-societe/".$name."/>Ludovox</a> - <a href=https://www.philibertnet.com/fr/".$game[$i][1].".html>Philibert</a>";
		$opinion = $game[$i][2];
		$images = grab($site, 'owl-carousel', '</ul>', '">', 'megastr');
		$images = preg_replace('/<li[^>]*>
/i', '', $images);//Petite importance du retour
		$images = preg_replace('#</li>
#', '', $images);//Petite importance du retour

		/*$images = preg_replace('/<img [^>]*>/i', '', $images);
		$images = preg_replace('#</a>
#', '', $images);//Petite importance du retour
		$images = preg_replace('#<a#', '<img class=mini', $images);
		$images = preg_replace('/ data[^>]*>/i', '>', $images);
		$images = preg_replace('#href#', 'src', $images);*/
		$images = preg_replace('#fancybox-group="other-views" class="fancybox shown"#', '', $images);
		$images = preg_replace('#fancybox-group="other-views" class="fancybox"#', '', $images);
		$images = preg_replace('#class="img-responsive owl-lazy"#', 'class=mini', $images);
		$images = preg_replace('#data-#', '', $images);
		$images = preg_replace('# height="120" width="120" itemprop="image" /> </a>#', '/></a>', $images);

		echo "<table class=card><tr><th colspan=3 style='background-color:".$color."'>".ucfirst(preg_replace('#-#', ' ', $name))."</th></tr>";
		echo "<tr><td><a href=".$img."><img src=".$img."></a></td><td";
		if(strlen($game[$i][0]) > 0){
			echo " style=\"background: no-repeat top 0px right 0px / 80px url(";
			if($game[$i][0] == 'h'){echo "https://cdn.pixabay.com/photo/2016/03/31/18/34/bookmark-1294473_960_720.png";}
			else if($game[$i][0] == 't'){echo "https://cdn.pixabay.com/photo/2017/06/13/21/49/medal-2400241_960_720.png";}
			else if($game[$i][0] == 'l'){echo "https://cdn.pixabay.com/photo/2013/07/12/13/22/chain-146909_960_720.png";}
			echo ")\"";
		}
		echo "><table>";
		echo "<tr><td>Age&nbsp;:</td><td>".$age." ans</td></tr>";
		echo "<tr><td>Nb joueurs&nbsp;:</td><td>".$nbPlayers." joueurs</td></tr>";
		echo "<tr><td>Mécanisme&nbsp;:</td><td>".$meca."</td></tr>";
		echo "<tr><td>Prix&nbsp;:</td><td>".$price." €</td></tr>";
		echo "<tr><td>Liens&nbsp;:</td><td>".$links."</td></tr>";
		echo "<tr><td>Avis perso&nbsp;:</td><td>".$opinion."</td></tr>";
		echo "</table></td></tr><tr><td colspan=2>".$images."</td></tr></table>";
	}
}


$ambiance2020 = array(
	array('t', 'libellud/89863-mysterium-park-3558380029441', 'Jeu de déduction en coopération.'),
	array('h', 'paille-editions/84144--kosmopoli-t--3760032261066', 'Jeu de coordination d\'équipe et d\'écoute.'),
	array('', 'ledroitdeperdrecom/90366-i-am-a-banana-3760285110845', 'Fous entre les fous !'),
	array('', 'blue-orange/85222-taco-chat-bouc-cheese-pizza-3664824001000', 'De la rapidité et de l\'observation.')
);

$solo2020 = array(
	array('', 'lumberjacks-studio/89702-trek-12-3760268310293', 'De 1 à beaucoup, c\'est sa grande force.'),
	array('h', 'renegade-game-studios/82239-le-defi-de-la-reine-3760243850691', 'Rapidité et observation.'),
	array('', 'lucky-duck-games/91054-mint-cooperative-752830297289', 'Coopération de super héros minimaliste.')
);

echoTable($ambiance2020, 'Jeux d\'ambiance', '#004040');
echoTable($solo2020, 'Jeux solo', '#d22e1f');

?>

</html>