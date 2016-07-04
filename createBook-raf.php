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

require_once $_SERVER['DOCUMENT_ROOT'].'/extension/PHPobjet/Db.class.php';
$DB = new DB();
$numeroPage=0;

$Book='<div id="flipbook" ng-controller="testCtrl">'."\n";
$Book1='';
$sommaire=array();
$tourCat=0;

$numeroPage = 0;
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


// boucle modele
$tabModele = array();
$reqModele = $DB->selectBoucle("SELECT * FROM `modele` ORDER BY `nom` ASC ");
while($resModele = $reqModele->fetch(PDO::FETCH_ASSOC)){
	$tabModele[$resModele['nom']] = $resModele['nbProduit'];
}
// end boucle modele


$tabProduitFlipping = array();
$page               = 0;
$modele             = '';
$nbProduit          = 0;
// requete catégorie
$reqCat = $DB->selectBoucle("SELECT DISTINCT `categorie` FROM `produit-raf` WHERE `ordreCategorie` != '' ORDER BY `ordreCategorie` ASC",array());
while($listeCat = $reqCat->fetch(PDO::FETCH_ASSOC))
{
	//req produit
	$reqPDT = $DB->selectBoucle("SELECT * FROM `produit-raf` WHERE `categorie` LIKE '".$listeCat['categorie']."' AND `valider` = 'oui' AND `modele` != '0' ORDER BY `ordreSousCategorie` ASC ,`ordreProduit` ASC ",array());

	// -------------------------------------------------------
	while($listePDT = $reqPDT->fetch(PDO::FETCH_ASSOC))
	{
		// echo'<br> modele : '.$listePDT['modele'];
		if($modele != $listePDT['modele'] || $nbPDT == $tabModele[$listePDT['modele']] )
		{
			$modele = $listePDT['modele'];
			$page++;
			$nbPDT=1;
		}
		else
		{
			$nbPDT++;
		}

		// if(!is_array($tabProduitFlipping[$page]))
		if(empty($tabProduitFlipping[$page][0]))
		{
			$tabProduitFlipping[$page][] = array($modele,$nbPDT);
			// echo 'ok<br>';
		}

		$tabProduitFlipping[$page][0][1] = $nbPDT;
		$tabProduitFlipping[$page]['produit'][] = $listePDT;
	}
	//---------------------------------------------------------
	// print_r($tabProduitFlipping);
}

foreach ($tabProduitFlipping as $tabGlobal) {

	$modeleLive = $tabGlobal[0][0];
	$nbPdtLive  = $tabGlobal[0][1]; // a voir si utile
	$tabPDT     = $tabGlobal['produit'];

	// $modeleLive = 'modeleTest';

	$classes = 'droite';
	if($numeroPage%2!=0){
		$classes = 'gauche';
	}
	ob_start();
		echo '<div class="'.$classes.'">';
		include './template/'.$modeleLive.'.php';
		echo '
</div>';
	$Book .= ob_get_clean();
	$numeroPage++;
}



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
$Book .='</div>';

//save flipbook.html
file_put_contents('flipbook.html',$Book);
?>