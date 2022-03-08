<?php
require_once("includes/db.php");
require_once("includes/helpers.php");
require_once("includes/sessions.php");

global $connection;

if (isset($_GET['submit'])) {
    $term = $_GET['search'];
    $query = "SELECT * FROM posts WHERE title LIKE :search OR category LIKE :search OR body LIKE :search ";
    $statement = $connection->prepare($query);
    $statement->bindValue(':search', '%' . $term . '%');
    $statement->execute();
} else {
    $query = "SELECT * FROM posts ORDER BY id desc";
    $statement = $connection->query($query);
}
$posts = $statement->fetchAll();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>BlogKe | Home</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark text-white mb-2 nav-pills">
    <div class="container">
        <a href="#" class="navbar-brand text-primary">BlogKe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapse"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="navbar-nav ms-lg-auto me-auto mb-2 mb-lg-0 ">
                <li class="nav-item">
                    <a href="index.php" class="nav-link active"><i class="fa-solid fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Join Us</a>
                </li>
            </ul>
            <form class="d-sm-flex d-none" method="get" action="index.php">
                <input class="form-control me-2" name="search" type="text" placeholder="Search">
                <button class="btn btn-outline-primary" name='submit' type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="row">
        <h1>The Latest Hot Topics</h1>
        <?php foreach ($posts

                       as $post) { ?>
            <div class="col-sm-6">
                <div class="card mb-4 bg-dark text-light">
                    <img class="img-fluid card-img-top" src="uploads/<?php echo $post['image'] ?>" alt="">
                    <div class="card-body">
                        <h4 class="card-title">
                            <?php echo $post['title']; ?>
                        </h4>
                        <small class="text-muted"><i>Article by <a class="link"><?php echo $post['author']; ?></a>
                                on <?php echo substr($post["timestamp"], 0, 9); ?></i></small>
                        <span class="badge bg-secondary float-end">comments 20</span>
                        <hr>
                        <p class="card-text"><?php echo substr($post['body'], 0, 250) . "..." ?></p>
                        <a href="post.php?id=<?php echo $post['id'] ?>" class="float-end btn btn-primary fw-bold">Read
                            More
                            <i
                                    class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--        <div class="col-sm-4">-->
        <!---->
        <!--        </div>-->
    </div>
</div>

<footer class="bg-dark text-white d-flex align-items-center">
    <div class="container align-center my-5">
        <div class="row ">
            <p class="lead text-center">Designed by | Brian &copy;<span id="year"></span></p>
        </div>
    </div>
</footer>
<script crossorigin="anonymous"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const year = document.querySelector("#year")
    year.innerHTML = new Date().getFullYear().toString()
</script>
</body>
</html>