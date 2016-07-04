<?php 
session_start();

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

$numeroPage  = 0;
$pagePanier  = 0;
$pageDevis   = 0;
$pageCGV     = 0;
$pageContact = 0;
$sommaire    = array();
$index       = array();
$tourCat     = 0;
$Book        = '<div id="flipbook" ng-controller="testCtrl">'."\n";
//page de couv
$Book.='	<div>';
	ob_start();
	include './template/premCouverture.php';
	$Book.=ob_get_clean();
$Book.='</div>';
$numeroPage++;

//2eme page de couv
$Book.='	<div>';
	ob_start();
	include './template/page2.php';
	$Book.=ob_get_clean();
$Book.='</div>';
$numeroPage++;


// boucle modele
$tabModele = array();
$reqModele = $DB->selectBoucle("SELECT * FROM `modele` ORDER BY `nom` ASC ");
while($resModele = $reqModele->fetch(PDO::FETCH_ASSOC)){
	$tabModele[$resModele['nom']] = $resModele['nbProduit'];
}
// end boucle modele


$tabProduitFlipping = array();
$tabRefP=array();
$page               = 0;
$modele             = '';
$nbProduit          = 0;

// requete catégorie
$reqCat = $DB->selectBoucle("SELECT DISTINCT `categorie` FROM `produit-raf` WHERE `ordreCategorie` != '' ORDER BY `ordreCategorie` ASC",array());
while($listeCat = $reqCat->fetch(PDO::FETCH_ASSOC))
{

	$numeroPage++;
	//création sommaire catégorie
	if(!array_key_exists($listeCat['categorie'],$sommaire))
	{
		$sommaire[$listeCat['categorie']][$tourCat]=array('',$numeroPage);
	}

	//req produit
	$reqPDT = $DB->selectBoucle("SELECT * FROM `produit-raf` WHERE `categorie` LIKE '".$listeCat['categorie']."' AND `valider` = 'oui' AND `modele` != '0' ORDER BY `ordreSousCategorie` ASC ,`ordreProduit` ASC ",array());

	// -------------------------------------------------------
	while($listePDT = $reqPDT->fetch(PDO::FETCH_ASSOC))
	{
		if(!in_array($listePDT['referenceP'], $tabRefP))
		{
			// entrée de $tabRefP[] =$valeurs['referenceP']; dans la tableau pour pas revenir sur cette RefP
			$tabRefP[] = $listePDT['referenceP'];
			// echo'<br> modele : '.$listePDT['modele'];
			if($modele != $listePDT['modele'] || $nbPDT == $tabModele[$listePDT['modele']] )
			{
				$modele = $listePDT['modele'];
				$page++;
				$numeroPage++;
				$nbPDT=1;
			}
			else
			{
				$nbPDT++;
			}

			if(empty($tabProduitFlipping[$page][0]))
			{
				$tabProduitFlipping[$page][] = $modele;
			}

			$tabProduitFlipping[$page]['produit'][] = $listePDT;

		}
		//---------------------------------------------------------
		// print_r($tabProduitFlipping);

		if($sommaire[$listeCat['categorie']][$tourCat][0]!=$listePDT['souscategorie'])
		{
			$tourCat++;
			$sommaire[$listeCat['categorie']][$tourCat]=array($listePDT['souscategorie'],$numeroPage);
		}
	}
}


//page sommaire
$Book.='	<div>
	SOMMAIRE<br><br><br>';

// pour le sous sommaire sur paege catégorie
$sommaireSousCat=array();

foreach ($sommaire as $cat => $stack) {

	foreach ($stack as $key => $value) {

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

$tabUniqueIndex = array();
foreach ($tabProduitFlipping as $tabGlobal) {

	$modeleLive = $tabGlobal[0];
	$tabPDT     = $tabGlobal['produit'];

	// $modeleLive = 'modeleTest';

	foreach ($tabPDT as $tabIndex) {
		
		// ajout dans la page index
		if(!in_array($tabIndex['categorie'], $tabUniqueIndex))
		{
			$index[] = $tabIndex['categorie'].' '.$numeroPage.' page ';
			$tabUniqueIndex[] = $tabIndex['categorie'];

			$numeroPage++;
			$Book.='	<div>
			'.$tabIndex['categorie'].'
			<br>
			<br>
			<br>
			<br>SOUSSOMMAIRE '.strtoupper($tabIndex['categorie']).'
			<br>
			<br>
			<br>
			<br>
			<br>
			page '.$numeroPage.' '.typePage($numeroPage).'
			</div>'."\n";

			echo'<hr>'.$tabIndex['categorie'];
			// print_r($tabPDT);
		}
		if(!in_array($tabIndex['souscategorie'], $tabUniqueIndex))
		{
			$index[] = $tabIndex['souscategorie'].' '.$numeroPage.' page ';
			$tabUniqueIndex[] = $tabIndex['souscategorie'];
		}
	}

	$classes = typePage($numeroPage);
	ob_start();
	echo '<div class="'.$classes.'">';
	include './template/'.$modeleLive.'.php';
	echo '</div>';
	$Book .= ob_get_clean();
	$numeroPage++;
}

$index = array_unique($index);
sort($index);

//INDEX
ob_start();
$classes = typePage($numeroPage);
echo '<div class="'.$classes.'">';
include './template/indexation.php';
echo '</div>';
$Book .= ob_get_clean();
$numeroPage++;


//PANIER
$Book.='	<div>
	PANIER
	</div>'."\n".'	<div>
	PANIER
	</div>'."\n";
	$numeroPage++;

	$pagePanier = $numeroPage;
	$numeroPage++;

//DEVIS
$Book.='	<div>
	DEVIS
	</div>'."\n".'	<div>
	DEVIS
	</div>'."\n";
	$numeroPage++;
	$pageDevis = $numeroPage;
	$numeroPage++;


// CONTACT
ob_start();
$classes = typePage($numeroPage);
echo '	<div class="'.$classes.'">';
include './template/contact.php';
echo '</div>';
$Book .= ob_get_clean();
$numeroPage++;
$pageContact = $numeroPage;

//CGV
ob_start();
$classes = typePage($numeroPage);
echo '	<div class="'.$classes.'">';
include './template/cgv.php';
echo '</div>';
$Book .= ob_get_clean();
$numeroPage++;
$pageCGV = $numeroPage;

//page 4eme de couv
ob_start();
$classes = typePage($numeroPage);
echo '	<div class="'.$classes.'">';
include './template/dernCouverture.php';
echo '</div>';
$Book .= ob_get_clean();
$numeroPage++;

//fermeture du book
$Book .='</div>';

// Ecriture des sous sommaires
foreach ($sommaireSousCat as $key => $value) {
	$Book=str_replace($key, $value,$Book);
}

//save flipbook.html
file_put_contents('flipbook.html',$Book);



// creation index.html
$contentHtml = '';

$tabModeleHTML = array('cssContent','indexation','cgv','premCouv','dernCouv','contact','page2','model1','model2','model3','model4','model5','model6'); 
ob_start();
?>
<!DOCTYPE html>
<html ng-app="test" ng-controller="testCtrl">

  <head>
    <link rel="stylesheet" href="css.css">
    <?php 
	foreach ($tabModeleHTML as $css) 
	{
    	echo '<link rel="stylesheet" href="css/'.$css.'.css">';
    } 
    ?>
    <script src="jquery.2.1.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
    <script src="turn.min.js"></script>
    <script src="app.js"></script>
  </head>

  <body style="background-color:#e7e7e7;">
        <nav id="navGlobal">
          
          <ul>
            <li><a href="#" ng-click="show_page(3)">Sommaire</a></li>
            <li><a href="#" ng-click="show_page(<?= $pagePanier; ?>)">Panier</a></li>
            <li><a href="#" ng-click="show_page(<?= $pageDevis; ?>)">Devis</a></li>
            <li><a href="#" ng-click="show_page(<?= $pageCGV; ?>)">CGV</a></li>
            <li><a href="#" ng-click="show_page(<?= $pageContact; ?>)">Contact</a></li>
            <li><a href="#" ng-click="show_page(10)">test</a></li>
            <!-- <li><a href="#" ng-click="addProduct()">Ajouter produit</a></li> -->
            <li>Panier : {{nbProduct}}</li>
          </ul>
        </nav>
        <flipbook></flipbook>

  </body>
</html>
<?php 
$contentHtml = ob_get_clean();
file_put_contents('index.html',$contentHtml);

// print_r($tabProduitFlipping);
?>