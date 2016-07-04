
<section class="header">
    <div class="bgCol bg<?= ucfirst($couleur); ?>">
      <p class="title"><?= $tabPDT[0]['categorie']; ?></p>
    </div>

</section>
<section class="corps model2">

  <?php for ($i=0; $i < 2 ; $i++) {
    $posImg = 'imgG';
    if($i%2==0) $posImg = 'imgD';

    if(!empty($tabPDT[$i]['cle'])):
  ?>
    <div class="cadre <?= $posImg; ?>">
      <figure>
        <img src="" data-img="http://www.canmk.fr/images/produit/<?= $tabPDT[$i]['image']; ?>" alt="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>" />
      </figure>
      <div class="border borderBas<?= ucfirst($couleur); ?>">
        <h3><?= $tabPDT[$i]['designation']; ?></h3>
        <div class="infoPdt">
          <?= $tabPDT[$i]['textecourt']; ?> <br>

        <div class="infoPrix">
          Réf : <?= $tabPDT[$i]['referenceU']; ?> <br>
          A partir de : <span class="price"><?= $tabPDT[$i]['prixht']*(1+$tabPDT[$i]['tva']); ?> &euro; <sup>TTC</sup></span>
        </div>
          <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>

          <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/enSavoirPlus.jpg" alt="" class="plusIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>"></a>
        </div>
      </div>
      <div class="clearBoth"></div>
    </div>
  <?php
    endif;
  } ?>
</section>


<section class="footer">
    <div class="imgFond">
      <p class="number"><?= $numeroPage; ?></p>
    </div>
    <div class="imgColor bg<?= ucfirst($couleur); ?>"></div>
</section>