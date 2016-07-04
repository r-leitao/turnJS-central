
  <section class="header">
    <div class="bgCol bg<?= ucfirst($couleur); ?>">
      <p class="title"><?= $tabPDT[0]['categorie']; ?></p>
    </div>
  </section>
<section class="corps model3">

  <?php for ($i=0; $i < 3 ; $i++) {
    $posImg = 'imgD';
    if($i%2==0) $posImg = 'imgG';
      if(!empty($tabPDT[$i]['cle'])):
  ?>
  <div class="cadre <?= $posImg; ?>">
    <figure>
      <img src="" data-img="http://www.canmk.fr/images/produit/<?= str_replace('.jpg', '-min.jpg', $tabPDT[$i]['image']); ?>" alt="" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>"  data-numPage="<?= $numeroPage+1; ?>" />
    </figure>
    <div class="border borderBas<?= ucfirst($couleur); ?>">
      <h3>>>><?= $tabPDT[$i]['designation']; //.' -- '.$tabPDT[$i]['cle']; 
      ?></h3>
      <div class="infoPdt">
        <?php  //$tabPDT[$i]['prixht'].'--'.

        $boutonEnSavoirPlus=$tabPDT[$i]['boutonEnSavoirPlus'];

        if(strlen($tabPDT[$i]['textecourt']) > 300 ) { echo substr($tabPDT[$i]['textecourt'],0,300).'...'; $boutonEnSavoirPlus=1;}
          else echo $tabPDT[$i]['textecourt'];

         ?> <br>

      <div class="infoPrix">
        Réf : <?= $tabPDT[$i]['referenceU']; ?> <br>
        A partir de : <span class="price"><?= number_format($tabPDT[$i]['prixht']*(1+($tabPDT[$i]['tva']/100)),2,',','.'); ?> &euro; <sup>TTC</sup></span>
      </div>
        <a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/panierIco.jpg" alt="" class="panierIco" flp-click="infosProduit(this)" data-refPdt="<?= $tabPDT[$i]['cle']; ?>" data-numPage="<?= $numeroPage+1; ?>"></a>

        <?php 

        if($boutonEnSavoirPlus==1) 
          {
            $numP=$numeroPage+1;
            echo '<a href="#" ><img src="http://www.canmk.fr/turnJS-central/img/enSavoirPlus.jpg" alt="" class="plusIco" flp-click="infosProduit(this)" data-refPdt="'.$tabPDT[$i]['cle'].'"  data-numPage="'.$numP.'"></a>';
          }

        ?>
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