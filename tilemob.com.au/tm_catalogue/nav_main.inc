<?PHP
// Turn off all error reporting
error_reporting(0);
$gallery_address = 'http://www.tilemob.com.au/tm_catalogue/gallery/';
$root_address = "http://www.tilemob.com.au/tm_catalogue/";
?>

<div class="menu">
  <ul>
    <li> <a href="<?=$gallery_address?>tiles/floors/commercial/page1/index.php?page=1"> tiles </a>
      <ul>
        <li> <a href="<?=$gallery_address?>tiles/floors/commercial/page1/index.php?page=1"> Floors </a>
          <ul>
            <li><a href="<?=$gallery_address?>tiles/floors/internal/page1/index.php?page=1">Internal</a></li>
            <li><a href="<?=$gallery_address?>tiles/floors/external/page1/index.php?page=1">External</a></li>
            <li><a href="<?=$gallery_address?>tiles/floors/commercial/page1/index.php?page=1">Commercial</a></li>
          </ul>
        </li>
        <li><a href="<?=$gallery_address?>tiles/pool/page1/index.php?page=1">Pool</a></li>
        <li> <a href="<?=$gallery_address?>tiles/wall/bathrooms/page1/index.php?page=1"> Wall </a>
          <ul>
            <li> <a href="<?=$gallery_address?>tiles/wall/bathrooms/page1/index.php?page=1"> Bathrooms </a> </li>
            <li><a href="<?=$gallery_address?>tiles/wall/feature walls/page1/index.php?page=1">Feature Walls</a></li>
            <li> <a href="<?=$gallery_address?>tiles/wall/kitchen/page1/index.php?page=1"> Kitchen </a> </li>
          </ul>
        </li>
      </ul>
    </li>
    <li> <a href="<?=$gallery_address?>stone/page1/index.php?page=1"> stone</a> </li>
    <li><a href="<?=$gallery_address?>mosaics/page1/index.php?page=1"> mosaics</a></li>
    <li><a href="<?=$gallery_address?>slate/page1/index.php?page=1"> slate</a></li>
    <li><a href="<?=$gallery_address?>terracotta/page1/index.php?page=1"> terracotta</a></li>
  </ul>
</div>
