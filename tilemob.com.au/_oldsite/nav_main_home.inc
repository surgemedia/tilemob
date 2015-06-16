<?PHP
// Turn off all error reporting
error_reporting(0);
$gallery_address = 'http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/';
$root_address = "http://www.tilemob.com.au/tm_catalogue/";
?>

<div class="menu">
  <ul>
    <li><a href="<?=$gallery_address?>tiles/floors/commercial/page1/index.php?page=1"> <img src="images/btn_home_tiles_3.gif" alt="tiles" name="tiles" border="0" id="tiles" /> </a>
      <ul>
        <li><a href="<?=$gallery_address?>tiles/floors/commercial/page1/index.php?page=1"> Floors </a>
          <ul>
            <li><a href="<?=$gallery_address?>tiles/floors/internal/page1/index.php?page=1">Internal</a></li>
            <li><a href="<?=$gallery_address?>tiles/floors/external/page1/index.php?page=1">External</a></li>
            <li><a href="<?=$gallery_address?>tiles/floors/commercial/page1/index.php?page=1">Commercial</a></li>
          </ul>
        </li>
        <li><a href="<?=$gallery_address?>tiles/pool/page1/index.php?page=1">Pool</a></li>
        <li><a href="<?=$gallery_address?>tiles/wall/bathrooms/page1/index.php?page=1"> Wall </a>
          <ul>
            <li><a href="<?=$gallery_address?>tiles/wall/bathrooms/page1/index.php?page=1"> Bathrooms </a> </li>
            <li><a href="<?=$gallery_address?>tiles/wall/feature walls/page1/index.php?page=1">Feature Walls</a></li>
            <li><a href="<?=$gallery_address?>tiles/wall/kitchen/page1/index.php?page=1"> Kitchen </a> </li>
          </ul>
        </li>
      </ul>
    </li>
    <li><a href="<?=$gallery_address?>stone/page1/index.php?page=1"> <img src="images/btn_home_stone_3.gif" alt="stone" name="stone" border="0" id="stone" /></a> </li>
    <li><a href="<?=$gallery_address?>mosaics/page1/index.php?page=1"> <img src="images/btn_home_mosaics_3.gif" alt="mosaics" name="mosaic" border="0" id="mosaic" /></a></li>
    <li><a href="<?=$gallery_address?>slate/page1/index.php?page=1"> <img src="images/btn_home_slate_3.gif" alt="slate" name="slate" border="0" id="slate" /></a></li>
    <li><a href="<?=$gallery_address?>terracotta/page1/index.php?page=1"> <img src="images/btn_home_terracotta_3.gif" alt="terracotta" name="terracotta" border="0" id="terracotta" /></a></li>
  </ul>
</div>