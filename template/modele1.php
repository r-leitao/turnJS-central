<section class="header">
    <div class="bgCol bg<?= ucfirst($couleur); ?>">
      <p class="title"><?= $tabPDT[0]['categorie']; ?></p>
    </div>

</section>
<section class="corps model1">

  <div class="cadre">
    <figure>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[0]['image']; ?>" alt="" />
      <figcaption><?= $tabPDT[0]['designation']; ?></figcaption>
    </figure>
    <div class="infoPdt">
      <?= $tabPDT[0]['textecourt']; ?>
      <br>
    </div>
    <div class="prixBtn">
        <?php if(rand(0,1)):  ?>
         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/nouveau.jpg" alt="" class="newIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[0]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>
       <?php endif; ?>

         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[0]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>

        <div class="infoPrix tour<?= ucfirst($couleur); ?>">
          Réf : <?= $tabPDT[0]['referenceU']; ?> <br>
          <span class="prixBarre"><?= $tabPDT[0]['prixbarre']*(1+$tabPDT[0]['tva']); ?> &euro; TTC</span>  <span class="price"><?= $tabPDT[0]['prixht']*(1+$tabPDT[0]['tva']); ?> &euro; <sup>TTC</sup></span>
        </div>
    </div>
    <div class="clearBoth"></div>
  </div>

  
</section>


<section class="footer">
    <div class="imgFond">
      <p class="number"><?= $numeroPage; ?></p>
    </div>
    <div class="imgColor bg<?= ucfirst($couleur); ?>"></div>
</section>