<header id="header">
  <div class="header__top">
    <div class="container">
      <div class="header__top__logo">
        <h1><a href="/" style="color:black;text-decoration:none;"><?php echo $config['title'];?></a></h1>
      </div>
      <nav class="header__top__menu">
        <ul>
          <li><a href="/">Главная</a></li>
          <li><a href="/pages/about_me.php">Обо мне</a></li>
          <li><a href="<?php echo $config['vk_page']?>" target="_blank">Я Вконтакте</a></li>
        </ul>
      </nav>
    </div>
  </div>

  <?php 
    $categories = mysqli_query($connection, "SELECT * FROM `articles_categories`");
  ?>

  <div class="header__bottom">
    <div class="container">
      <nav>
        <ul>
          <?php 
            while( ($category = mysqli_fetch_assoc($categories)) ) {
              echo '<li><a href="/articles.php?categorie_id='. $category['_id'] .'">' . $category['title'] .'</a></li>';
            }
          ?>
        </ul>
      </nav>
    </div>
  </div>
</header>