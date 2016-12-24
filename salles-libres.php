<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html dir="ltr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="180">
<title>Centre Assas : salles libres</title>

<link rel="stylesheet" type="text/css" href="style.css" media="screen">

<script src="news-ticker/jquery-latest.pack.js" type="text/javascript"></script>
<script src="news-ticker/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	var nbSalles = $('#mesSalles > *').length;
	if (nbSalles > 14) {
		$(".newsticker-jcarousellite").jCarouselLite({
			vertical: true,
			hoverPause:true,
			visible: 14,
			auto:650,
			speed:3000
		});
	}
});
</script>

</head>

<body>
<div id="newsticker-demo">    
    <div class="title">Salles libres</div>
    <div class="newsticker-jcarousellite">
		<ul id="mesSalles">

<!-- ADD YOUR SCROLLER CONTENT INSIDE HERE -->
<?php

include("./universal-reader.php");

//$url="http://www.u-paris2.fr/adminsite/webservices/export_rss.jsp?OBJET=ACTUALITE&CODE_RUBRIQUE=TOTO";

$url= "http://193.49.199.150/up2rss/";

$Universal_FeedArray = Universal_Reader($url);
$page = "";


	if(count($Universal_FeedArray) <=1)
	{
		$page .= "<li>
				<div class=\"info\">&nbsp;</div>
                <div class=\"info2\">Il n'y a actuellement aucune salle libre</div>
                <div class=\"info3\">&nbsp;</div>
				<div class=\"clear\"></div>
				</li>";
	}
	else 
	{
		foreach($Universal_FeedArray as $article)
		{
			$type = $article["type"];
			if($type != 0)
			{
				$title = $article["title"];
				list($salle, $hdeb, $hfin, $reste) = explode("---", $title);
				$salle = trim (substr ($salle, 5));
				$hdeb = trim (substr ($hdeb, 0, 5));
				$hfin = trim (substr ($hfin, 0, 5));
				$description = $article["description"];
				list($tmp, $centre, $etage, $capacite) = explode("---", $description);
				$etage = trim ($etage);
				$capacite = trim ($capacite);
				$capacite = substr ($capacite, 12);
				
				$page .= "<li>
					<div class=\"info\">" . $salle . "</div>
					<div class=\"info2\">" .$hdeb ." - " .$hfin ."</div>
					<div class=\"info3\">" .$etage ."</div>
					<div class=\"clear\"></div>
					</li>\n";
			}
		}
			
	}
echo $page;
?>
		</ul>
    </div>
   
</div> 

</body>
</html>
