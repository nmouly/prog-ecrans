<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- 2012-11-20 : réduit le nombre de caractères du champ matières à 65 -->
<!-- 25-02-2013 : ajoute un test pour ne pas scroller quand le nombre de ligne a afficher est inférieur à 6 -->
<!-- 01-10-2013 : problème uneseul enregistrement -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Centre Assas : Absences - Rattrapages</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="6000">
<script src="news-ticker/jquery-latest.pack.js" type="text/javascript"></script>
<script src="news-ticker/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$(".newsticker-jcarousellite").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 10,
		auto:500,
		speed:5000
	});
});
</script>

<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="newsticker-demo">    
 
<?php
$page ="";

$url = "http://193.49.199.150/commun/planning/arj";

$xmlDoc = new DOMDocument();
$xmlDoc->load($url);


// recherche les noeuds AbsRatJour 
$listeElt =  $xmlDoc->getElementsByTagName("AbsRatJour"); 

/* à partir de php 5.2 -- $date = new DateTime("now");
$page .= "<div class=\"title\">". $nb  ." Absences - Rattrapages au " .$date->format("d/m/y")  ."</div>\n";*/

$datj =  strtotime("now");

$page .= "<div class=\"title\"> Absences - Rattrapages au " .date ("d/m/y", $datj)  ."</div>\n" ;

	if( $listeElt->length <1) // rien a afficher
	{
		$page .=  "<div class=\"pas-de-scroll\">";
		$page .= "<li>
				<div class=\"info\">&nbsp;</div>
                <div class=\"info2\">Il n'y a aucune abscence ou rattrapage</div>
                <div class=\"info3\">&nbsp;</div>
				<div class=\"clear\"></div>
				</li>";
	}
	else 
	{
		if ($listeElt->length <=10) // moins de lignes que l'espace réservé, pas besoin de scroller
		{
			$page .=  "<div class=\"pas-de-scroll\">";
		}
		else 
		{
			$page .=  "<div class=\"newsticker-jcarousellite\">";
		}	
		// dans les 2 cas on affiche chaque ligne
		$page .= "<ul id=\"mesSalles\">";

		foreach ($listeElt as $elt) 
		{
			
			$civ =  $elt->getElementsByTagName('Civilite')->item(0)->nodeValue;
			$nom =  $elt->getElementsByTagName('Nom')->item(0)->nodeValue;
			$prenom = $elt->getElementsByTagName('Prenom')->item(0)->nodeValue;
			$nomComplet = $civ ." " .$prenom . " " .$nom;
			$nomComplet = substr ($nomComplet, 0, 40);
			
			$mat =  $elt->getElementsByTagName('Matiere')->item(0)->nodeValue;
			if (strlen ($mat) > 85)  {
				$mat = substr ($mat, 0, 82) ."&#8230;";
			}
			$type = $elt->getElementsByTagName('Type')->item(0)->nodeValue;
			$type = substr ($type, 0, 21);
		
			$planning = $elt->getElementsByTagName('Planning')->item(0)->nodeValue;
			list($heure, $salle) = explode(" - ", $planning);
				
			/* si besoin de faire un test sur l'heure de fin
			$fin = $elt->getElementsByTagName('Fin')->item(0)->nodeValue;
			$hfin = strtotime($fin);
			echo "maintenant : " .date ("d/m/y  H:i", $datj) ." xml "   .date ("d/m/y  H:i", $hfin) ."<br><br>		";*/
	
			
			$page .= "<li>
			<div class=\"type\">" . $type . "</div>
			<div class=\"nom\">" .$nomComplet ."</div>
			<div class=\"salle\">" .$salle ."</div>
			<div class=\"clear\"></div>\n
			<div class=\"matiere\">" .$mat ."</div>
			<div class=\"dateheure\">" .$heure ."</div>			
			<div class=\"clear\"></div>\n
			</li>\n";
	
	
		}//fin foreach
	}//fin else qqchose a aficher

$page .= "</ul>\n </div></div>\n"; 

echo $page; 

?>
</body>
</html>