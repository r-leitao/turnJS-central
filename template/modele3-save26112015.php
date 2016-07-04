
  <section class="header">
    <div class="bgCol">
      <p class="title"><?= $tabPDT[0]['categorie']; ?></p>
    </div>
  </section>
<section class="corps model3">

  <div class="cadre imgG">
    <figure>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[0]['image']; ?>" alt="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[0]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>" />
    </figure>
    <div class="border">
      <h3><?= $tabPDT[0]['designation']; ?></h3>
      <div class="infoPdt">
        <?= $tabPDT[0]['textecourt']; ?> <br>

      <div class="infoPrix">
        Réf : <?= $tabPDT[0]['referenceU']; ?> <br>
        A partir de : <span class="price"><?= $tabPDT[0]['prixht']*(1+$tabPDT[0]['tva']); ?> &euro; <sup>TTC</sup></span>
      </div>
        <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[0]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>

        <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/enSavoirPlus.jpg" alt="" class="plusIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[0]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>"></a>
      </div>
    </div>
    <div class="clearBoth"></div>
  </div>

  <div class="cadre imgD">
    <div class="border">
      <h3><?= $tabPDT[1]['designation']; ?></h3>
      <div class="infoPdt">
        <?= $tabPDT[1]['textecourt']; ?> <br>

      <div class="infoPrix">
        Réf : <?= $tabPDT[1]['referenceU']; ?> <br>
        A partir de : <span class="price"><?= $tabPDT[1]['prixht']*(1+$tabPDT[1]['tva']); ?> &euro; <sup>TTC</sup></span>
      </div>
        <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[1]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>

        <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/enSavoirPlus.jpg" alt="" class="plusIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[1]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>"></a>
      </div>
    </div>
    <figure>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[1]['image']; ?>" alt="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[1]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>" />
    </figure>
    <div class="clearBoth"></div>
  </div>

  <div class="cadre imgG">
    <div class="border">
      <h3><?= $tabPDT[2]['designation']; ?></h3>
      <div class="infoPdt">
        <?= $tabPDT[2]['textecourt']; ?> <br>

      <div class="infoPrix">
        Réf : <?= $tabPDT[2]['referenceU']; ?> <br>
        A partir de : <span class="price"><?= $tabPDT[2]['prixht']*(1+$tabPDT[2]['tva']); ?> &euro; <sup>TTC</sup></span>
      </div>
        <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[2]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>

        <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/enSavoirPlus.jpg" alt="" class="plusIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[2]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>"></a>
      </div>
    </div>
    <figure>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[2]['image']; ?>" alt="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[2]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>" />
    </figure>
    <div class="clearBoth"></div>
  </div>
  </section>


  <section class="footer">
    <p class="number"><?= $numeroPage; ?></p>
  </section>