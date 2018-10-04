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
            <?php
              $didCategorySetted = isset($_GET['categorie_id']);
              $titleOfBlock = 'Все статьи';
            ?>
            <div class="block">
              <h3>Все статьи</h3>
              <?php
              if($didCategorySetted) {
                
                foreach( $categories as $category ) {
                  if( $category['_id'] == $_GET['categorie_id'] ) {
                    echo "<h4>Категория: " . $category['title'] . "</h4>";
                    break;
                  }
                }
              }
              ?>
              <div class="block__content">
                
                <div class="articles articles__horizontal">
                  <?php 
                    $queryWhere = '';
                    

                    if ($didCategorySetted) {
                      $queryWhere = 'WHERE `categories_id` = ' . (int) $_GET['categorie_id'];
                    }

                    $page = 1;

                    if( isset($_GET['page'])) {
                      $page = (int) $_GET['page'];
                    };

                    $totalCountQ = mysqli_query($connection, "SELECT COUNT(`_id`) AS `totalCount` FROM `articles` $queryWhere");
                    $totalCount = mysqli_fetch_assoc($totalCountQ);
                    $totalCount = $totalCount['totalCount'];
                    
                    $totalPages = ceil($totalCount / $config['limit_pagination']);
                    if ($page <= 1 || $page > $totalPages) {
                      $page = 1;
                    }

                    $offset = ($config['limit_pagination'] * $page) - $config['limit_pagination'];

                    


                    $articles = mysqli_query($connection, "SELECT * FROM `articles` " . $queryWhere . " ORDER BY `_id` DESC LIMIT $offset, ". $config['limit_pagination']);

                    $articleExist = true;
                    
                    if( mysqli_num_rows($articles) <= 0) {
                      echo 'Нет статей.';
                      $articleExist = false;
                    }
                    while( $article = mysqli_fetch_assoc($articles)) {
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

                <?php
                  if($didCategorySetted) {
                    $categorieInPath = '&categorie_id=' . $_GET['categorie_id'];
                  }
                  if( $articleExist == true) {
                    echo '<div class="paginator">';

                    if( $page > 1) {
                      echo '<a href="/articles.php?page=' . ($page - 1) . $categorieInPath . '">&laquo; Прошлая страница </a>';
                    };

                    if( $page < $totalPages) {
                      echo '<a href="/articles.php?page=' . ($page + 1) . $categorieInPath .'">Следующая страница &raquo;</a>';
                    };

                    echo '</div>';
                  }
                ?>
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