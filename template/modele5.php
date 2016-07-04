
  <section class="header">
    <div class="bgCol bg<?= ucfirst($couleur); ?>">
      <p class="title"><?= $tabPDT[0]['categorie']; ?></p>
    </div>

  </section>
<section class="corps model5">

  <div class="viewTop">
  <?php for ($i=0; $i < 3 ; $i++) { 

      if(!empty($tabPDT[$i]['cle'])):

    ?>
    <!-- box -->
    <div class="box">
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[$i]['image']; ?>" alt="" />
      <figcaption><?= $tabPDT[$i]['designation']; ?></figcaption>
      <?= $tabPDT[$i]['textecourt']; ?>
      <div class="prixBtn">

        <div class="infoPrix">
          Réf : <?= $tabPDT[$i]['referenceU']; ?> <br>
          <span class="prixBarre"><?= $tabPDT[$i]['prixbarre']*(1+$tabPDT[$i]['tva']); ?></span>  <span class="price"><?= $tabPDT[$i]['prixht']*(1+$tabPDT[$i]['tva']); ?> &euro; <sup>TTC</sup></span>
        </div>

        <?php if(rand(0,1)):  ?>
         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/nouveau.jpg" alt="" class="newIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>
       <?php endif; ?>

         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>
      </div>
    </div>
  <?php
    endif;
  }
  ?>
  </div>
  <div class="viewBottom">
      <?php if(!empty($tabPDT[4]['cle'])): ?>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[4]['image']; ?>" alt="" />
      <div class="texte">
        <h3><?= $tabPDT[4]['designation']; ?></h3>
        <?= $tabPDT[4]['textecourt']; ?>
      <br>
      <div class="prixBtn">

        <div class="infoPrix">
          Réf : <?= $tabPDT[4]['referenceU']; ?> <br>
          <span class="prixBarre"><?= $tabPDT[4]['prixbarre']*(1+$tabPDT[4]['tva']); ?></span>  <span class="price"><?= $tabPDT[4]['prixht']*(1+$tabPDT[4]['tva']); ?> &euro; <sup>TTC</sup></span>
        </div>

        <?php if(rand(0,1)):  ?>
         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/nouveau.jpg" alt="" class="newIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[4]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>
       <?php endif; ?>

         <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[4]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>
      </div>
      </div>
    <?php endif; ?>
  </div>
  </section>


  <section class="footer">
    <div class="imgFond">
      <p class="number"><?= $numeroPage; ?></p>
    </div>
    <div class="imgColor bg<?= ucfirst($couleur); ?>"></div>
  </section>