<?php
session_start();
include 'header.php';
?>
  <!-- floating petals background -->
  <div class="petal" aria-hidden="true">🌸</div>
  <div class="petal" aria-hidden="true">🌺</div>
  <div class="petal" aria-hidden="true">🌸</div>
  <div class="petal" aria-hidden="true">🌷</div>
  <div class="petal" aria-hidden="true">🌸</div>
  <div class="petal" aria-hidden="true">🌺</div>

  <!-- ── HEADER ── -->
  

  <!-- ── MAIN ── -->
  <main class="container section">

    <!-- Search Hero -->
    <div class="search-header">
      <span class="search-header__icon">🌸</span>
      <h2 id="search-title">Search Results</h2>
      <p class="search-subtext">Find your perfect bouquet</p>
      <div class="search-divider">
        <span>✿</span>✿<span>✿</span>
      </div>
    </div>

    <!-- Results Grid -->
    <div class="products__container grid" id="search-results"></div>

    <!-- No Results -->
    <div id="no-results" style="display:none;">
      <span class="no-results__emoji">🥀</span>
      <p class="no-results__title">Not available…</p>
      <p class="no-results__sub">We couldn't find that. Try one of these:</p>
      <div class="no-results__chips">
        <a href="rose.php" class="no-results__chip">🌹 Roses</a>
        <a href="tulip.php" class="no-results__chip">🌷 Tulips</a>
        <a href="lily.php" class="no-results__chip">🌸 Lilies</a>
        <a href="orchids.php" class="no-results__chip">🌺 Orchids</a>
        <a href="sunflower.php" class="no-results__chip">🌻 Sunflowers</a>
        <a href="valentine.php" class="no-results__chip">🐻 Bears</a>
        <a href="valentine.php" class="no-results__chip">🍫 Chocolates</a>
        <a href="occasions.php" class="no-results__chip">🎁 Gifts</a>
      </div>
    </div>

  </main>

  <div id="invalid-toast">
    <span class="invalid-toast__icon">🥀</span>
    <div class="invalid-toast__body">
      <span class="invalid-toast__title">Not available…</span>
      <span class="invalid-toast__sub">Try flowers, bears, or chocolates 🌸</span>
    </div>
  </div><?php include 'footer.php'; ?>
