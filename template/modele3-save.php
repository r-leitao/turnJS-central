
  <section class="header">
    <p class="title">totot otkvfo</p>
  </section>
<section class="corps model3">

  <div class="cadre imgG">
    <figure>
      <figcaption><?= $tabPDT[0]['designation']; ?></figcaption>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[0]['image']; ?>" alt="" />
    </figure>
    <div class="infoPdt">
      <?= $tabPDT[0]['textecourt']; ?>
      <a href="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[0]['cle']; ?>">En savoir plus</a>
    </div>
    <div class="clearBoth"></div>
  </div>
    <div class="cadre imgD">
      <figure>
        <figcaption><?= $tabPDT[1]['designation']; ?></figcaption>
        <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[1]['image']; ?>" alt="" />
      </figure>
      <div class="infoPdt">
      <?= $tabPDT[1]['textecourt']; ?>
        <a href="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[1]['cle']; ?>">En savoir plus</a>
      </div>
      <div class="clearBoth"></div>
    </div>

    <div class="cadre imgG">
      <figure>
        <figcaption><?= $tabPDT[2]['designation']; ?></figcaption>
        <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[2]['image']; ?>" alt="" />
      </figure>
      <div class="infoPdt">
      <?= $tabPDT[2]['textecourt']; ?>
        <a href="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[2]['cle']; ?>">En savoir plus</a>
      </div>
      <div class="clearBoth"></div>
    </div>
  </section>


  <section class="footer">
    <p class="number">222</p>
  </section>