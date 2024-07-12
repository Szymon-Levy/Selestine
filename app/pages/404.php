<?php
  $page_title = 'Error 404';
  include '../app/pages/includes/top.php';
?>

    <section class="error-page">
      <div class="container">
        <div class="row">
          <img class="error-page__image" src="<?= get_image_path('404.svg'); ?>" alt="Error 404 page not found">

          <a href="<?=ROOT?>" class="btn btn--accent">Go to home page</a>
        </div>
      </div>
    </section>

  </main>

<?php
  include '../app/pages/includes/bottom.php';
?>
</body>
</html>