<?php 
session_start();
if(empty($_SESSION['adherent']['cle'])){
	header('Location : http://www.canmk.fr/turnJS-central/');
}
?>
<!DOCTYPE html>
<html ng-app="test" ng-controller="testCtrl">

  <head>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="css/cssContent.css"><link rel="stylesheet" href="css/indexation.css"><link rel="stylesheet" href="css/cgv.css"><link rel="stylesheet" href="css/premCouv.css"><link rel="stylesheet" href="css/dernCouv.css"><link rel="stylesheet" href="css/contact.css"><link rel="stylesheet" href="css/page2.css"><link rel="stylesheet" href="css/model1.css"><link rel="stylesheet" href="css/model2.css"><link rel="stylesheet" href="css/model3.css"><link rel="stylesheet" href="css/model4.css"><link rel="stylesheet" href="css/model5.css"><link rel="stylesheet" href="css/model8.css"><link rel="stylesheet" href="css/ficheProduct.css"><link rel="stylesheet" href="css/color.css">
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
            <li><a href="#" ng-click="show_page(270)">Panier</a></li>
            <li><a href="#" ng-click="show_page(272)">Devis</a></li>
            <li><a href="#" ng-click="show_page(274)">CGV</a></li>
            <li><a href="#" ng-click="show_page(273)">Contact</a></li>
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
