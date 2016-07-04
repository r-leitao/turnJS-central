<section class="header">
    <div class="bgCol bg<?= ucfirst($couleur); ?>">
      <p class="title"><?= $tabPDT[$i]['categorie']; ?></p>
    </div>

</section>
<section class="corps model4">

  <?php for ($i=0; $i < 4 ; $i++) {
    $posImg = 'imgD';
    if($i%2==0) $posImg = 'imgG';

    if(!empty($tabPDT[$i]['cle'])):
  ?>
  <div class="cadre <?= $posImg; ?>">
    <figure>
      <figcaption><?= $tabPDT[$i]['designation'].$tabPDT[$i]['referenceU']; ?></figcaption>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[$i]['image']; ?>" alt="" />
    </figure>
    <div class="infoPdt">
     <?= $tabPDT[$i]['textecourt']; ?>
     <div class="prixBtn">
        <?php if(rand(0,1)):  ?>
         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/nouveau.jpg" alt="" class="newIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>
       <?php endif; ?>

         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>

        <div class="infoPrix tour<?= ucfirst($couleur); ?>">
          Réf : <?= $tabPDT[$i]['referenceU']; ?> <br>
          <span class="prixBarre"><?= $tabPDT[$i]['prixbarre']*(1+$tabPDT[$i]['tva']); ?></span>  <span class="price"><?= $tabPDT[$i]['prixht']*(1+$tabPDT[$i]['tva']); ?> &euro; <sup>TTC</sup></span>
        </div>
    </div>
    </div>
    <div class="clearBoth"></div>
  </div>
  <?php 
    endif;
  }
  ?>

</section>


<section class="footer">
    <div class="imgFond">
      <p class="number"><?= $numeroPage; ?></p>
    </div>
    <div class="imgColor bg<?= ucfirst($couleur); ?>"></div>
</section>