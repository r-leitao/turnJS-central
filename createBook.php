<?php 
session_start();

echo 'oui';

function typePage($page)
{
	if($page%2 == 1) $type='gauche';
	else $type='droite';
	return $type;
}

require_once $_SERVER['DOCUMENT_ROOT'].'/ERP/include/variable.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ERP/include/fonction.php';

require $_SERVER['DOCUMENT_ROOT'].'/extension/PHPobjet/Db.class.php';
$DB = new DB();

$numeroPage=0;

$Book='<div id="flipbook" ng-controller="testCtrl">'."\n";
$Book1='';
$sommaire=array();
$tourCat=0;

//page de couv
$Book.='	<div>
	COUVERTURESSS
	</div>'."\n";
$numeroPage++;

//2eme page de couv
$Book.='	<div>
	2eme de COUV
	</div>'."\n";
$numeroPage++;



// requete catégorie
$reqCat = $DB->selectBoucle("SELECT DISTINCT `categorie` FROM `produit` ORDER BY `ordreCategorie` ASC",array());
while($listeCat = $reqCat->fetch(PDO::FETCH_ASSOC))
{

//incrémentation numero page
$numeroPage++;

//page de cat
$Book1.='	<div>
	'.$listeCat['categorie'].'
	<br>
	<br>
	<br>
	<br>SOUSSOMMAIRE '.strtoupper($listeCat['categorie']).'
	<br>
	<br>
	<br>
	<br>
	<br>
	page '.$numeroPage.' '.typePage($numeroPage).'
	</div>'."\n";

	//création sommaire catégorie
	if(!array_key_exists($listeCat['categorie'],$sommaire))
	{
		$sommaire[$listeCat['categorie']][$tourCat]=array('',$numeroPage);
	}



	//req produit
	$reqPDT = $DB->selectBoucle("SELECT * FROM `produit` WHERE `categorie` = '".$listeCat['categorie']."' AND `valider` = 'oui' ORDER BY `ordreSousCategorie` ASC ,`ordreProduit` ASC",array());
	$nbPDT=4;
	$tabRefP=array();
	while($listePDT = $reqPDT->fetch(PDO::FETCH_ASSOC))
	{
		if(!in_array($listePDT['referenceP'], $tabRefP))
		{
			// entrée de $tabRefP[] =$valeurs['referenceP']; dans la tableau pour pas revenir sur cette RefP
			$tabRefP[] = $listePDT['referenceP'];

			//ouverture page si début (nbPDT=4)
			if($nbPDT==4)
			{
				//incrémentation numero page
				$numeroPage++;

				//page de cat
				$Book1.='	<div class="'.typePage($numeroPage).'">

	<section class="header">
	<p class="title">'.$listeCat['categorie'].'</p>
	</section>
	<section class="corps">';
			// 	$Book1.='	<div>
			// '.$listeCat['categorie'].'<br>';
			}



			// ajout produit
			// $Book1.='<div class="cadre">'.$listePDT['designation'].'</div>';

			// affichage droite gauche pour l'image produit en fonction de la position dans la page. DEBUT HAUT à GAUCHE
			if($nbPDT%2==1) $typeAffiche='imgD fond';
			else $typeAffiche='imgG';

			//Test image
			$urlimgOK='http://www.canmk.fr/images/produit/'.$listePDT['image'].'-min.jpg';


			$Book1.='            <div class="cadre '.$typeAffiche.'">
              <figure>
                <figcaption>'.$listePDT['designation'].'</figcaption>
                <img src="" data-img="'.$urlimgOK.'" alt="" />
              </figure>
              <div class="infoPdt">'.$listePDT['textecourt'].'<br><a href="" flp-click="infosProduit(this)" data-refPdt="'.$listePDT['cle'].'">En savoir plus</a></div>
              <div class="clearBoth"></div>
            </div>';

			// $Book1.='<br>'.$listePDT['categorie'].' ET '.$listePDT['souscategorie'].'('.$listePDT['ordreCategorie'].'-'.$listePDT['ordreSousCategorie'].'-'.$listePDT['ordreProduit'].') PDT => '.$nbPDT.'::>>>'.$listePDT['designation'];
			$nbPDT--;
			// $Book1.='<<<::'.$nbPDT;


			// fermeture page si nbPDT=0
			if($nbPDT==0)
			{
				//page de cat
				$Book1.='	</section>
	<section class="footer">
	<p class="number">'.$numeroPage.'</p>
	</section>

	</div>'."\n";
		// 		$Book1.='
		// <br>
		// <br>
		// <br>
		// page '.$numeroPage.' '.typePage($numeroPage).'
		// </div>'."\n";
			$nbPDT=4;
			}
		}

		//création sommaire Sous Catégorie
		// if(!array_key_exists($listePDT['souscategorie'],$sommaireSousCat)) array_push($sommaireSousCat[$listeCat['categorie']], array($listePDT['souscategorie'],$numeroPage));

		if($sommaire[$listeCat['categorie']][$tourCat][0]!=$listePDT['souscategorie'])
		{
			$tourCat++;
			$sommaire[$listeCat['categorie']][$tourCat]=array($listePDT['souscategorie'],$numeroPage);
		}

	}

	// fermeture page si fin produit cat (si que 3 pdt en fin par exemple)
	if($nbPDT!=4)
	{
		//page de cat
		$Book1.='	</section>
	<section class="footer">
	<p class="number">'.$numeroPage.'</p>
	</section>

	</div>'."\n";
	// 	$Book1.='
	// <br>
	// <br>
	// <br>
	// page '.$numeroPage.' '.typePage($numeroPage).'
	// </div>'."\n";
	$nbPDT=4;
	}

}


//page sommaire
$Book.='	<div>
	SOMMAIRE<br><br><br>';

// pour le sous sommaire sur paege catégorie
$sommaireSousCat=array();

foreach ($sommaire as $cat => $stack) {


// echo '<br><br><br>';
// print_r($stack);




	foreach ($stack as $key => $value) {
		// echo '<br>'.$key.':::'.$value[0].':::'.$value[1];
	//key
	// $Book.='<br><a class="sommaire" flp-click="show_page('.$value[0][1].')">'.strtoupper($key).' ...... PAGE '.$value[0][1].'</a><br>'."\n";

	// echo '<br><br><br>';

	// print_r($value);

	//si impaire, page devient impaire+1 pour aller à la bonne page
	if($value[1]%2==1) $page=$value[1]+1;
	else $page=$value[1];

		if($value[0]=='')
		{
			$Book.='<br><a class="sommaire" flp-click="show_page('.$page.')">'.strtoupper($cat).' ...... PAGE '.$value[1].'</a><br>'."\n";
			//sous sommaire
			$sommaireSousCat['SOUSSOMMAIRE '.strtoupper($cat)]='';
		}
		else
		{
			$Book.='<a class="sommaire" flp-click="show_page('.$page.')">'.ucfirst($value[0]).' ...... PAGE '.$value[1].'</a><br>'."\n";
			
			//sous sommaire
			$sommaireSousCat['SOUSSOMMAIRE '.strtoupper($cat)].='<a class="sommaire" flp-click="show_page('.$page.')">'.ucfirst($value[0]).' ...... PAGE '.$value[1].'</a><br>'."\n";
		}


	}

}


$Book.='	</div>'."\n";
$numeroPage++;



// association couv et intérieur
$Book.=$Book1;

//PANIER
$Book.='	<div>
	PANIER
	</div>'."\n".'	<div>
	PANIER
	</div>'."\n";

//DEVIS
$Book.='	<div>
	DEVIS
	</div>'."\n".'	<div>
	DEVIS
	</div>'."\n";

//CGV
$Book.='	<div>
	CGV
	</div>'."\n".'	<div>
	CGV
	</div>'."\n";

//page 4eme de couv
$Book.='	<div>
	DERNIERE DE COUV
	</div>'."\n";

//fermeture du book
$Book.='</div>';


// Ecriture des sous sommaires
foreach ($sommaireSousCat as $key => $value) {
	$Book=str_replace($key, $value,$Book);
}


//save flipbook.html
file_put_contents('flipbook.html',$Book);


// echo '<pre>';
// print_r($sommaire);
// echo '</pre>';

?>