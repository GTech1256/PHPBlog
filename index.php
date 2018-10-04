<?php
require "includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<?php
include "./includes/head.php";
?>
<body>

  <div id="wrapper">

    <?php include "./includes/header.php" ?>

    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">

            <div class="block">
              <a href="/articles.php">Все записи</a>
              <h3>Новейшее в блоге</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">

                  <?php 
                    $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `_id` DESC LIMIT ". $config['limit_articles']);
                  
                    while( $article = mysqli_fetch_assoc($articles)) {
                      print_r($article) 
                      ?>
                      <article class="article">
                        <div class="article__image" style="background-image: url(/static/images/<?php echo $article['image']?>);"></div>
                        <div class="article__info">
                          <a href="/article.php?id=<?php echo $article['_id']?>"><?php echo $article['title']?></a>
                          <div class="article__info__meta">
                            <?php 
                              $article_category = false;
                              foreach( $categories as $category ) {
                                if( $category['_id'] == $article['categories_id'] ) { 
                                  $article_category = $category;
                                  break;
                                }
                              }
                            ?>
                            <small>Категория: <a href="/articles.php?categorie_id=<?php echo $article_category['_id']?>"><?php echo $article_category['title']?></a></small>
                          </div>
                          <div class="article__info__preview"><?php echo mb_substr(strip_tags($article['text']), 0, 50, 'utf-8') . '...' ?></div>
                        </div>
                      </article>
                      <?php
                    }
                  ?>
                </div>
              </div>
            </div>

            

            <div class="block">
              <a href="/articles.php?categorie_id=8">Все записи</a>
              <h3>Безопасность [Новейшее]</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">

                  <?php 
                    $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categories_id` = 8 ORDER BY `_id` DESC LIMIT ". $config['limit_articles']);
                  
                    while( $article = mysqli_fetch_assoc($articles)) {
                      print_r($article) 
                      ?>
                      <article class="article">
                        <div class="article__image" style="background-image: url(/static/images/<?php echo $article['image']?>);"></div>
                        <div class="article__info">
                          <a href="/article.php?id=<?php echo $article['_id']?>"><?php echo $article['title']?></a>
                          <div class="article__info__meta">
                            <?php 
                              $article_category = false;
                              foreach( $categories as $category ) {
                                if( $category['_id'] == $article['categories_id'] ) { 
                                  $article_category = $category;
                                  break;
                                }
                              }
                            ?>
                            <small>Категория: <a href="/articles?categorie_id=<?php echo $article_category['_id']?>"><?php echo $article_category['title']?></a></small>
                          </div>
                          <div class="article__info__preview"><?php echo mb_substr(strip_tags($article['text']), 0, 50, 'utf-8') . '...' ?></div>
                        </div>
                      </article>
                      <?php
                    }
                  ?>

                </div>
              </div>
            </div>

            <div class="block">
              <a href="/articles.php?categorie_id=4">Все записи</a>
              <h3>Программирование [Новейшее]</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">

                  <?php 
                    $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categories_id` = 4 ORDER BY `_id` DESC LIMIT ". $config['limit_articles']);
                  
                    while( $article = mysqli_fetch_assoc($articles)) {
                      print_r($article) 
                      ?>
                      <article class="article">
                        <div class="article__image" style="background-image: url(/static/images/<?php echo $article['image']?>);"></div>
                        <div class="article__info">
                          <a href="/article.php?id=<?php echo $article['_id']?>"><?php echo $article['title']?></a>
                          <div class="article__info__meta">
                            <?php 
                              $article_category = false;
                              foreach( $categories as $category ) {
                                if( $category['_id'] == $article['categories_id'] ) { 
                                  $article_category = $category;
                                  break;
                                }
                              }
                            ?>
                            <small>Категория: <a href="/articles?categorie_id=<?php echo $article_category['_id']?>"><?php echo $article_category['title']?></a></small>
                          </div>
                          <div class="article__info__preview"><?php echo mb_substr(strip_tags($article['text']), 0, 50, 'utf-8') . '...' ?></div>
                        </div>
                      </article>
                      <?php
                    }
                  ?>

                </div>
              </div>
            </div>
          </section>
          <section class="content__right col-md-4">
            <?php include './includes/sidebar.php' ?>
          </section>
        </div>
      </div>
    </div>

    <?php include './includes/footer.php' ?>

  </div>

</body>
</html>