var test=angular.module('test', []);


test.controller('testCtrl',['$scope', function($scope) {
      // $scope.taille = 'totot';
      // $scope.nbProduct = 0;
      // $scope.ratio = 1.5;
      // $scope.W = 500;
      // $scope.H = 500;
      // $scope.hauteurBook = $scope.H;

      $scope.flipping = angular.element('#flipbook' );
      // // console.info(scope);
      $scope.flipping.turn({
        'width'        : 500,
        'height'       : 500,
        'acceleration' : false
      });
      
      // // resizeFlipbook.resize('#flipbook',scope);
      // $scope.flipping.turn('peel', 'br');

      // console.info('entrer directive');

      // $scope.show_page = function(page){
      //   $scope.flipping.turn('page', page);
      // };
}]);

