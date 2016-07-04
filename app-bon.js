var test=angular.module('test', []);

// fonction de redimensionnement flipping book
test.factory('resizeFlipbook',function($window){
  return {
      resize: function(id,scope){


          var myEl = angular.element( document.querySelector(id) );
          scope.W = $window.innerWidth;
          scope.H = $window.innerHeight;
          var wwidth = scope.W;
          var hheight = Math.round(wwidth / scope.ratio);
          var padded = Math.round(scope.H * 0.9);
          // if the height is too big for the window, constrain it
          if (hheight > padded) {
              hheight = padded;
              wwidth = Math.round(hheight * scope.ratio);
          }
          scope.W = wwidth;
          scope.H = hheight;
          scope.taille=wwidth+'-'+hheight;
          // console.log('nouvelle taille',wwidth+'-'+hheight);
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
        // console.info('entrer => '+numberPage);
          var pagination = angular.element('.p'+numberPage+' img' );
          angular.forEach(pagination, function(value, key){
               var a = angular.element(value);
               a.attr('src',a.attr('data-img'));
          });
      }
  }
});

test.directive('flipbook', function($window,resizeFlipbook,loadPicture){
  return{
    restrict: 'EA',
    link: function(scope, element, attrs){

      // console.info(scope);
      scope.taille = 'totot';
      scope.nbProduct = 0;
      scope.ratio = 1.5;
      scope.W = $window.innerWidth;
      scope.H = $window.innerHeight;
      scope.hauteurBook = scope.H;

      scope.flipping = angular.element('#flipbook' );
      // console.info(scope);
      scope.flipping.turn({
        'width' : scope.W,
        'height' : scope.H,
        'acceleration' : false
      });
      
      resizeFlipbook.resize('#flipbook',scope);
      scope.flipping.turn('peel', 'br');

      console.info('entrer directive');

    },
    controller: function($scope,$element){


      this.affichee = function(){
        console.info('afficher');
      }
      // quand redimensionne la fenetre
      angular.element($window).bind('resize', function(){
        resizeFlipbook.resize('#flipbook',$scope);
      });

      // changement de page
      angular.element('body').on('click','.sommaire',function(evt){

        sscope = angular.element(document.body).scope();
        elt = angular.element(evt.target);
        console.log('element',elt.attr('ng-click'));
        // console.log('this',$this);
        page = elt.attr('ng-click');
        page = page.replace('show_page','');
        page = page.replace('(','');
        page = page.replace(')','');
        sscope.flipping.turn('page', page);
      });

      // active à la fin de changement de page
      angular.element('#flipbook' ).bind("turned", function(event, page, pageObject) {
        var pageGaucheVisible = pageObject[0];
        var pageDroiteVisible = pageObject[1];
        loadPicture.loadImg($scope,pageGaucheVisible);
        loadPicture.loadImg($scope,pageDroiteVisible);
        for (var i = 1; i < 3; i++) {
          loadPicture.loadImg($scope,--pageGaucheVisible);
          loadPicture.loadImg($scope,++pageDroiteVisible);
        };     
      });

      // $scope.$apply(function(){
        this.show_page = function(page){
          // alert('ok');
          $scope.flipping.turn('page', page);
        };
      // })

      $scope.ajoutHTML = function(vari){
        var myElajout = angular.element( '#ajout' );
        myElajout.text(vari);
      };

      $scope.addProduct = function(){
        $scope.nbProduct++;
      }

    },
    templateUrl: "flipbook.html"
  };
});

test.directive('refreshScope',function(){
  return {
    restrict: 'EA',
    link: function(scope, element, controller){
      console.info('ttt');
      angular.element('body').on('click','.sommaire',function(){
        controller.affichee();
        console.info('ttt');
      });
    }
  }
})


