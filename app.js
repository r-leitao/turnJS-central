var test=angular.module('test', []);


test.controller('testCtrl',['$scope','$window','$http','loadPicture','resizeFlipbook','reloadPanier','reloadDevis', function($scope,$window,$http,loadPicture,resizeFlipbook,reloadPanier,reloadDevis) {

      var navGlobal = angular.element('#navGlobal');
      $scope.navGlobalH = navGlobal.height();
      $scope.navGlobalW = navGlobal.width();

      $scope.show_page = function(page){
        // alert('ok');
        // console.info('entrer controllerss');
        $scope.flipping.turn('page', page);
      };

      $scope.cacherTitre = function(){

        var divOverflow = angular.element('.testCache' );
          angular.forEach(divOverflow, function(value, key){
               var a = angular.element(value);
               console.log('cacher',a);
               a.removeClass('cacherNon');
               a.addClass('cacher');
          });

      }

      $scope.voirTitre = function(){

        var divOverflow = angular.element('.testCache' );
          angular.forEach(divOverflow, function(value, key){
               var a = angular.element(value);
               console.log('voir',a);
               a.removeClass('cacher');
               a.addClass('cacherNon');
          });
      } 

      $scope.deletePanier = function(refu){
        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/deletePdtPanier.php",
            method: "POST",
            data: 'refu='+refu,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.rafraichirPanier();
            $scope.eventTargetForm = '';
            // console.info(data);
        })
      }

      $scope.deleteDevis = function(refu){
        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/deletePdtDevis.php",
            method: "POST",
            data: 'refu='+refu,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.rafraichirPanier();
            $scope.eventTargetForm = '';
            // console.info(data);
        })
      }

      $scope.ajoutHTML = function(vari){
        var myElajout = angular.element( '#ajout' );
        myElajout.text(vari);
      };

      // ajouter produit dans le panier
      $scope.addProductPrix = function(){
        form = $scope.eventTargetForm;
        formEnvoie = form.serialize();
        $scope.ajoutOptionPdt();
        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/ajoutProduitPrix.php",
            method: "POST",
            data: formEnvoie,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.rafraichirPanier();
            $scope.eventTargetForm = '';
            // console.info(data);
        })
      };

      // ajouter produit dans le devis
      $scope.addProductDevis = function(){
        form = $scope.eventTargetForm;
        formEnvoie = form.serialize();
        $scope.ajoutOptionPdt();
        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/ajoutProduitDevis.php",
            method: "POST",
            data: formEnvoie,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            $scope.rafraichirPanier();
            $scope.eventTargetForm = '';
        })
      };


      // ajouter produit dans le panier
      $scope.validerCommandePanier = function(){
        form = $scope.eventTargetForm;
        formEnvoie = form.serialize();
        formEnvoie = 'envoi=envoie&'+formEnvoie;
        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/formulaire.html",
            method: "POST",
            data: formEnvoie,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
          alert('Votre panier est bien valider');
          $http({
              url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/viderPanier.php"
          }).success(function(data, status, headers, config) {})
        })
      };


      // fiche produit dans une page
      $scope.infosProduit = function(){
        var idProduit = $scope.eventTarget.attr('data-refPdt');
        console.info(idProduit);
        var numPage = $scope.eventTarget.attr('data-numPage');
        // pageParent = $scope.eventTarget.parent().parent().parent().parent().parent().parent();
        // nbPage = pageParent.attr('page')*1;
        nbPage = numPage*1;
        if(nbPage%2 == 0)nbPage++;
        else nbPage--;

        var pageTarget = angular.element('.p'+nbPage);
        $scope.eventTarget = pageTarget;
        $scope.pageHtml = pageTarget.html();
        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/JSficheProduit.php",
            method: "POST",
            data : "id="+idProduit,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
            pageTarget.html(data);
        })
      };

      $scope.ajoutOptionPdt = function(){
        elts =  angular.element('img.optionImgPdt.choisie');
          angular.forEach(elts,function(value, key){
              var el = angular.element(value);
              var formEnvoie = el.parent().find('form:first').serialize();
              var inputAffichage = el.parent().find('form:first').find('input[name="affichage"]').val();

              var fichier = 'ajoutProduitPrix';
              if(inputAffichage != 'prix')fichier = 'ajoutProduitDevis';

              $http({
                  url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/"+fichier+".php",
                  method: "POST",
                  data: formEnvoie,
                  headers: {'Content-Type': 'application/x-www-form-urlencoded'}
              }).success(function(data, status, headers, config) {
                  $scope.rafraichirPanier();
                  $scope.eventTargetForm = '';
              });
          });
      }

      $scope.validerDevis = function(){

        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/saveDevis.php"
        }).success(function(data, status, headers, config) {
            if(data == ''){
              alert('Votre demande de devis a bien été transmise, vous recevrez par mail les tarifs demandés dans les meilleurs délais');
            }
            $scope.eventTargetForm = '';
        });
      }

      // ajouter produit dans le devis
      $scope.envoieContact = function(){
        form = $scope.eventTargetForm;
        formEnvoie = form.serialize();
        // console.info(formEnvoie);
        alert('ok');
        $http({
            url: window.location.protocol+'//'+window.location.hostname+"/contact-us.html",
            method: "POST",
            data: formEnvoie,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data, status, headers, config) {
          // console.info(data);
            $scope.rafraichirPanier();
            $scope.eventTargetForm = '';
        })
      };

      // reload panier
      $scope.rafraichirPanier = function(){
        reloadPanier.affiche();
        reloadDevis.affiche();
        $scope.fermerInfos();
      };

      // quand redimensionne la fenetre
      angular.element($window).bind('resize', function(){
        resizeFlipbook.resize('#flipbook',$scope);
      });
      $scope.eventTargetForm = '';
      $scope.eventTarget = '';
      $scope.pageHtml = '';
}]);


// DIRECTIVE FLIPBOOK
test.directive('flipbook', function($window,$rootScope,resizeFlipbook,loadPicture,reloadPanier,reloadDevis){
  return{
    restrict: 'EA',
    scope : false,
    link: function(scope, element, attrs){

      scope.taille = 'totot';
      scope.nbProduct = 0;
      scope.ratio = 1.5;
      scope.W = $window.innerWidth;
      scope.H = $window.innerHeight - scope.navGlobalH;
      scope.hauteurBook = scope.H ;

      scope.flipping = angular.element('#flipbook' );
      // console.info(scope);
      scope.flipping.turn({
        'width' : scope.W,
        'height' : scope.H,
        'acceleration' : false
      });
      
      resizeFlipbook.resize('#flipbook',scope);
      scope.flipping.turn('peel', 'br');

      // console.info('entrer directive');

    },
    controller: function($scope,$element){


      // fermeture fiche informations produit
      $scope.fermerInfos = function(){
        if($scope.eventTarget != ''){
          $scope.eventTarget.html($scope.pageHtml);
          $scope.eventTarget = '';
          $scope.pageHtml = '';
        }
      }

      // active à la fin de changement de page
      angular.element('#flipbook' ).bind("turned", function(event, page, pageObject) {
        var pageGaucheVisible = pageObject[0];
        var pageDroiteVisible = pageObject[1];

        reloadPanier.affiche();
        reloadDevis.affiche();

        loadPicture.loadImg($scope,pageGaucheVisible);
        loadPicture.loadImg($scope,pageDroiteVisible);
        for (var i = 1; i < 3; i++) {
          loadPicture.loadImg($scope,--pageGaucheVisible);
          loadPicture.loadImg($scope,++pageDroiteVisible);
        };

        if(!$scope.$$phase) {
          $scope.fermerInfos();
          $scope.$apply(function(){});
        }
      });


      angular.element('body').on('click','[flp-click]',function(evt){

        if($scope.eventTarget != '')$scope.fermerInfos();
        elt = angular.element(evt.target);
        var fction = elt.attr('flp-click');
        // console.info(fction);
        var explode = fction.split('(');
        var nameFunctionscope = explode[0];
        var argumentFunction = explode[1].replace(')','');
        if(argumentFunction == "this"){
          $scope.eventTarget = elt;
          argumentFunction = 0;
        }
        if(argumentFunction == '')argumentFunction=0;
        if(angular.isFunction($scope[nameFunctionscope])){
          $scope[nameFunctionscope](argumentFunction);
        }
        evt.preventDefault();
      });

        // case à cocher option
        angular.element('body').on('click','img.optionImgPdt',function(evt){
            elt = angular.element(evt.target);
            elt.toggleClass('choisie');
        });

      angular.element('body').on('submit','[flp-submit]',function(evt){
        
        evt.preventDefault();
        elt = angular.element(evt.target);
        var fction = elt.attr('flp-submit');
        var explode = fction.split('(');
        var nameFunctionscope = explode[0];
        var argumentFunction = explode[1].replace(')','');

        if(argumentFunction == "this"){
          $scope.eventTargetForm = elt;
          argumentFunction = 0;
        }

        if(argumentFunction == '')argumentFunction=0;
        if(angular.isFunction($scope[nameFunctionscope])){
          $scope[nameFunctionscope](argumentFunction);
        }
      });

    },
    // templateUrl: "flipbook.html"
    templateUrl: function(element, attrs) {
      return attrs.userRole;
    }
  };
});


// DEBUT FACTORY

// fonction reload html panier
test.factory('reloadPanier',function($http){
  return {
      affiche: function(){
          $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/panierJS.php"
        }).success(function(data, status, headers, config) {
            var eltPanier = angular.element( document.querySelector('#panierCmd') );
            var eltPanier2 = angular.element( document.querySelector('#panierCmd2') );

            console.log('div',eltPanier);

            eltPanier.empty();
            eltPanier2.empty();
            var tabPanier = angular.element(data);
            
            eltPanier.html(tabPanier);
            var tabPanier2 = angular.element( document.querySelector('#tabPanier2') );
            var toto = tabPanier2.remove();

            formulaire = angular.element( document.querySelector('#formInfoPanier') );
            var formm = formulaire.remove();

            eltPanier2.html(toto);
            angular.element( document.querySelector('#tabPanier2') ).after(formm);
            // eltPanier2.

        }).error(function(data, status, headers, config) {
            // console.log('error',data);
        });
      }
  }
});

// fonction reload html panier
test.factory('reloadDevis',function($http){
  return {
      affiche: function(){
          $http({
            url: window.location.protocol+'//'+window.location.hostname+"/ajax/ERPreq/turnJS/devisJS.php"
        }).success(function(data, status, headers, config) {
            var eltDevis = angular.element( document.querySelector('#devisCmd') );
            var eltDevis2 = angular.element( document.querySelector('#devisCmd2') );
            eltDevis.empty();
            eltDevis2.empty();
            var tabPanier = angular.element(data);
            // console.info(data);
            eltDevis.html(tabPanier);
            var tabDevis2 = angular.element( document.querySelector('#tabDevis2') );
            var toto = tabDevis2.remove();
            console.info(toto);
            eltDevis2.html(toto);

        }).error(function(data, status, headers, config) {
            // console.log('error',data);
        });
      }
  }
});
// fonction de redimensionnement flipping book
test.factory('resizeFlipbook',function($window){
  return {
      resize: function(id,scope){

          var navGlobal = angular.element('#navGlobal');
          scope.navGlobalH = navGlobal.height();
          scope.navGlobalW = navGlobal.width();

          // console.info(scope.navGlobalH);
          var myEl = angular.element( document.querySelector(id) );
          scope.W = $window.innerWidth;
          scope.H = $window.innerHeight - scope.navGlobalH;
          var wwidth = scope.W;
          var hheight = (wwidth / scope.ratio);
          var padded = (scope.H * 0.90);
          // if the height is too big for the window, constrain it
          if (hheight > padded) {
              hheight = padded;
              wwidth = Math.round(hheight * scope.ratio);
          }
          scope.W = wwidth;
          scope.H = hheight;
          scope.taille=wwidth+'-'+hheight;

          scope.flipping.turn('size', wwidth, hheight);

          var divOverflow = angular.element('.resizeHauteur' );
          angular.forEach(divOverflow, function(value, key){
               var a = angular.element(value);
               var heightInit = a.data('init');
               var ratioH = scope.hauteurBook / heightInit;
               var newHeight = scope.H / ratioH;
               a.css('height',newHeight+'px');
          });
      }
  }
});

// affiche Image à la volé
test.factory('loadPicture',function($window){
  return {
      loadImg: function($scope,numberPage){

          var pagination = angular.element('.p'+numberPage+' img' );
          angular.forEach(pagination, function(value, key){
               var a = angular.element(value);
               a.attr('src',a.attr('data-img'));
          });
      }
  }
});




