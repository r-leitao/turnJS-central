<?php 
session_start();

$urlBase='http://www.canmk.fr/turnJS-central/';
$urlBaseImg='http://www.canmk.fr/turnJS-central/img/';

function typePage($page)
{
	if($page%2 == 1) $type='gauche';
	else $type='droite';
	return $type;
}

function cutTexte($txt,$long=125){
	$txtBis = substr($txt,0,$long);
	return $txtBis.'...';
}

require_once $_SERVER['DOCUMENT_ROOT'].'/ERP/include/variable.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ERP/include/fonction.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/extension/PHPobjet/Db.class.php';
$DB = new DB();



/* TABLEAU CAT / IMG / COUL + save css couleur */
$tabCatBase=array();
$tabCoulCss='.coulBase{color:#E18400;}
.borderCoulBase{border-left : 3px solid #E18400;}
.bgCoulBase{background-color : #E18400;}'."\n";
$reqCat = $DB->selectBoucle("SELECT * FROM `catFlipBook` ");
while($resCat = $reqCat->fetch(PDO::FETCH_ASSOC))
{
	$tabCatBase[$resCat['nom_url']]=array($resCat['image'],$resCat['couleur'],$resCat['texte']);
	$tabCoulCss.='.coul'.$resCat['couleur'].'{color:#'.$resCat['couleur'].';}
.borderdroiteCoul'.$resCat['couleur'].'{border-left : 3px solid #'.$resCat['couleur'].';}
.bordergaucheCoul'.$resCat['couleur'].'{border-right : 3px solid #'.$resCat['couleur'].';}
.borderBasCoul'.$resCat['couleur'].' h3 {border-bottom : 3px solid #'.$resCat['couleur'].';}
.border2BasCoul'.$resCat['couleur'].' h3 {border-bottom : 3px solid #'.$resCat['couleur'].';}
.bgCoul'.$resCat['couleur'].'{background-color : #'.$resCat['couleur'].';}
.tourCoul'.$resCat['couleur'].'{border : 1px solid #'.$resCat['couleur'].';}
.borderTitreCoul'.$resCat['couleur'].'{border-bottom: 3px solid #'.$resCat['couleur'].';}'."\n";
}
// echo $tabCoulCss;
file_put_contents($_SERVER["DOCUMENT_ROOT"].'/turnJS-central/css/color.css',$tabCoulCss);
/*********** FIN CAT ***********/



$numeroPage  = 0;
$numeroPageSommaire  = 3;
$pagePanier  = 0;
$pageDevis   = 0;
$pageCGV     = 0;
$pageContact = 0;
$sommaire    = array();
$index       = array();
$tourCat     = 0;
$couleur	 = 'coulBase';
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


/************ boucle modele***********/
$tabModele = array();
$reqModele = $DB->selectBoucle("SELECT * FROM `modele` ORDER BY `nom` ASC ");
while($resModele = $reqModele->fetch(PDO::FETCH_ASSOC))
{
	$tabModele[$resModele['nom']] = $resModele['nbProduit'];
}
/*************** end boucle modele**********/


$tabProduitFlipping = array();
$tabRefP=array();
$page               = 0;
$modele             = '';
$nbProduit          = 0;

// requete catégorie
//-raf
$reqCat = $DB->selectBoucle("SELECT DISTINCT `categorie`,`categorieUrl` FROM `produit` WHERE `ordreCategorie` != '' ORDER BY `ordreCategorie` ASC",array());
while($listeCat = $reqCat->fetch(PDO::FETCH_ASSOC))
{

	//création sommaire catégorie
	if(!array_key_exists($listeCat['categorie'],$sommaire))
	{
		$sommaire[$listeCat['categorie']][$tourCat]=array('',$numeroPageSommaire);
	}

	//req produit
	//-raf
	$reqPDT = $DB->selectBoucle("SELECT * FROM `produit` WHERE `categorie` LIKE '".$listeCat['categorie']."' AND `valider` = 'oui' AND `modele` != '0' ORDER BY `ordreSousCategorie` ASC ,`ordreProduit` ASC ",array());

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
				$numeroPageSommaire++;
				$nbPDT=1;
			}
			else
			{
				$nbPDT++;
			}

			// echo 'mod::page::numP::nbPDT:::::::::'.$modele.'::'.$page.'::'.$numeroPageSommaire.'::'.$nbPDT.':::::'.$listePDT['designation'];

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

		if($sommaire[$listeCat['categorie']][$tourCat][0]!=$listePDT['souscategorie'])
		{
			$tourCat++;
			$sommaire[$listeCat['categorie']][$tourCat]=array($listePDT['souscategorie'],$numeroPageSommaire);
			print_r(array($listePDT['souscategorie'],$numeroPageSommaire));
		}
	}
}


//page sommaire
$Book.='<div>
			<div class="pageSommaireIndex">
				<div class="sommaireHeaderIndex"><p class="'.$couleur.'">SOMMAIRE</p></div>
				<div class="contentSommaireIndex">
					<div class="listeIndex">
						<div class="col">';

// pour le sous sommaire sur paege catégorie
$sommaireSousCat=array();
$increCol = 0;

// echo '<pre>';
// print_r($sommaire);
// echo '</pre>';

foreach ($sommaire as $cat => $stack) {

	foreach ($stack as $key => $value) {
		$increCol++;
		if($increCol == 33){
			$increCol = 0;
			$Book.='</div><div class="col">';
		}
	//si impaire, page devient impaire+1 pour aller à la bonne page
	if($value[1]%2==1) $page=$value[1]+1;
	else $page=$value[1];

		// coupure si texte trop long
		if(strlen($value[0]) > 30)
		{
			$pp=explode(' ',$value[0]);
			$pp[1].='<br>';
			$nomcat=implode(' ',$pp);
			echo 'oui';
		}
		else $nomcat=$value[0];


			echo $nomcat;


		if($value[0]=='')
		{
			$Book.='<br>
					<a class="sommaire">
						<span class="sommaireNomIndex"><nobr class="nobr"><b flp-click="show_page('.$page.')">'.strtoupper($cat).'</b></nobr></span><span class="sommaireNbPage">'.$value[1].'</span>
					</a>
					<br>'."\n";
			//sous sommaire
			$sommaireSousCat['SOUSSOMMAIRE '.strtoupper($cat)]='';
		}
		else
		{
			$Book.='<a class="sommaire">
					<span class="sommaireNomIndex"><nobr class="nobr" flp-click="show_page('.$page.')">'.ucfirst($nomcat).'</nobr></span><span class="sommaireNbPage">'.$value[1].'</span></a><br>'."\n";
			
			//sous sommaire
			$sommaireSousCat['SOUSSOMMAIRE '.strtoupper($cat)].='<a class="sommaire">
				<span class="sommaireNom"><nobr class="nobr" flp-click="show_page('.$page.')">'.ucfirst($value[0]).'</nobr></span><span class="sommaireNbPage">'.$value[1].'</span></a><br>'."\n";
		}


	}

}
$Book.=' 			</div>
					</div>
				</div>
			</div>	
		</div>'."\n";
$numeroPage++;

$tabUniqueIndex = array();

foreach ($tabProduitFlipping as $tabGlobal) {

	$modeleLive = $tabGlobal[0][0];
	$nbPdtLive  = $tabGlobal[0][1]; // a voir si utile
	$tabPDT     = $tabGlobal['produit'];

	// $modeleLive = 'modeleTest';


	foreach ($tabPDT as $tabIndex) {

		
		// ajout dans la page index
		if(!in_array($tabIndex['categorie'], $tabUniqueIndex))
		{
			$index[] = $tabIndex['categorie'].' '.$numeroPage.' page ';
			$tabUniqueIndex[] = $tabIndex['categorie'];
			// echo '<br>coul::'.$tabIndex['categorieUrl'].'::'.
			$img=$tabCatBase[$tabIndex['categorieUrl']][0];
			$couleur='coul'.$tabCatBase[$tabIndex['categorieUrl']][1];
			$texte=$tabCatBase[$tabIndex['categorieUrl']][2];

			$numeroPage++;
			$Book.='
			<div>
				<div class="pageSommaire'.typePage($numeroPage).'">
					<div class="sommaireHeader"><p class="'.$couleur.'">'.$tabIndex['categorie'].'</p></div>
					<div class="contentSommaire">
						<img src="'.$urlBaseImg.$img.'" class="illustration">
						<div class="liste border'.typePage($numeroPage).ucfirst($couleur).'">
							<div class="text">'.$texte.'</div>
							<br>
							<br>
							SOUSSOMMAIRE '.strtoupper($tabIndex['categorie']).'
						</div>
					</div>
				</div>
			</div>'."\n";
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
	include './template/'.$modeleLive.'-co.php';
	echo '</div>';
	$Book .= ob_get_clean();
	$numeroPage++;
}


// pour forcer page de droite sur index
if(typePage($numeroPage)=='gauche')
{
// PAGE BLACHE
ob_start();
$classes = typePage($numeroPage);
echo '	<div class="'.$classes.'">';
echo '</div>';
$Book .= ob_get_clean();
$numeroPage++;
$pageContact = $numeroPage;
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
$Book.='<div class="'.typePage($numeroPage).'">
			<section class="header">
			    <div class="bgCol bg'.ucfirst($couleur).'">
			      <p class="title">PANIER</p>
			    </div>
			</section>
			<section class="corps model1">
				<div id="panierCmd">
					PANIER
				</div>
			</section>
			<section class="footer">
			    <div class="imgFond">
			      <p class="number">'.$numeroPage.'</p>
			    </div>
			    <div class="imgColor bg'.ucfirst($couleur).'"></div>
			</section>
		</div>
	'."\n".'
		<div class="'.typePage(++$numeroPage).'">
			<section class="header">
			    <div class="bgCol bg'.ucfirst($couleur).'">
			      <p class="title">PANIER</p>
			    </div>
			</section>
			<section class="corps model1">
				<div id="panierCmd2">
					PANIER
				</div>
			</section>
			<section class="footer">
			    <div class="imgFond">
			      <p class="number">'.$numeroPage.'</p>
			    </div>
			    <div class="imgColor bg'.ucfirst($couleur).'"></div>
			</section>
		</div>
	'."\n";

	$pagePanier = $numeroPage;
	// $numeroPage++;
	
//Devis
$Book.='<div class="'.typePage(++$numeroPage).'">
			<section class="header">
			    <div class="bgCol bg'.ucfirst($couleur).'">
			      <p class="title">Devis</p>
			    </div>
			</section>
			<section class="corps model1">
				<div id="devisCmd">
					DEVIS
				</div>
			</section>
			<section class="footer">
			    <div class="imgFond">
			      <p class="number">'.$numeroPage.'</p>
			    </div>
			    <div class="imgColor bg'.ucfirst($couleur).'"></div>
			</section>
		</div>
	'."\n".'
		<div class="'.typePage(++$numeroPage).'">
			<section class="header">
			    <div class="bgCol bg'.ucfirst($couleur).'">
			      <p class="title">Devis</p>
			    </div>
			</section>
			<section class="corps model1">
				<div id="devisCmd2">
					DEVIS
				</div>
			</section>
			<section class="footer">
			    <div class="imgFond">
			      <p class="number">'.$numeroPage.'</p>
			    </div>
			    <div class="imgColor bg'.ucfirst($couleur).'"></div>
			</section>
		</div>
	'."\n";

	$pageDevis = $numeroPage;
	// $numeroPage++;

// //DEVIS
// $Book.='	<div>
// 	<div id="devisCmd">
// 	DEVIS
// 	</div>
// 	</div>'."\n".'	<div>

// 	<div id="devisCmd2">
// 	DEVIS
// 	</div>
// 	</div>'."\n";
// 	$numeroPage++;
// 	$pageDevis = $numeroPage;
// 	$numeroPage++;


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
file_put_contents('flipbook-co.html',$Book);



// creation index.html
$contentHtml = '';

$tabModeleHTML = array('cssContent','indexation','cgv','premCouv','dernCouv','contact','page2','model1','model2','model3','model4','model5','model8','ficheProduct'); 
ob_start();
?>
<?php 
echo'<?php 
session_start();
if(empty($_SESSION[\'adherent\'][\'cle\'])){
	header(\'Location : http://www.canmk.fr/turnJS-central/\');
}
?>
';
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
    	echo '<link rel="stylesheet" href="css/color.css">';
    ?>

    <link rel="stylesheet" href="http://www.canmk.fr/css/autoload/uniform.default.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="http://www.canmk.fr/css/product.css" type="text/css" media="all" />
    
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
<!--             <li><a href="#" ng-click="cacherTitre()">Cacher</a></li>
            <li><a href="#" ng-click="voirTitre()">Voir</a></li> -->
            <!-- <li><a href="#" ng-click="addProduct()">Ajouter produit</a></li> -->
            <li>Panier : {{nbProduct}}</li>
          </ul>
        </nav>
        <flipbook  user-role="flipbook-co.html"></flipbook>

  </body>
</html>
<?php 
$contentHtml = ob_get_clean();
file_put_contents('index2.php',$contentHtml);

?>