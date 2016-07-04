<section class="header">
  <div class="bgCol bg<?= ucfirst($couleur); ?>">
    <p class="title">Index</p>
  </div>
</section>
<section class="corps indexation">

  <p id="descri">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis fugit accusamus obcaecati facilis quam reiciendis nostrum commodi, nobis officiis optio assumenda dignissimos velit adipisci explicabo atque pariatur veniam, debitis praesentium.</p>
  <div class="col">
    <?php 
      $tabLettre = array();
      $nbTab = count($index);
      for ($i=0; $i < 50; $i++)
      {
        $premiereLettre = $index[$i]{0};
        if(!in_array($premiereLettre, $tabLettre))
        {
          if(!empty($index[$i])) echo ' - <span class="color">'.$premiereLettre.'</span>'.substr($index[$i],1).' <br>';
          $tabLettre[] = $premiereLettre;
        }
        else{
          if(!empty($index[$i])) echo ' - '.$index[$i].' <br>';
        }
      }
    ?>
  </div>
  <div class="col">
    <?php 
      for ($i=50; $i < 100; $i++)
      {
        if(!empty($index[$i])) echo ' - '.$index[$i].' <br>';
      }
    ?>
  </div>
  <div class="col">
    <?php 
      for ($i=100; $i < 150; $i++)
      {
        if(!empty($index[$i]))  echo ' - '.$index[$i].' <br>';
      }
    ?>
  </div>
</section>
<section class="footer">
   <div class="imgFond">
      <p class="number"><?= $numeroPage; ?></p>
    </div>
    <div class="imgColor bg<?= ucfirst($couleur); ?>"></div>
</section>