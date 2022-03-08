<?php
require_once("includes/db.php");
require_once("includes/helpers.php");
require_once("includes/sessions.php");

global $connection;
$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id = '$id'";
$statement = $connection->query($query);
$post = $statement->fetch();


if (isset($_POST['commentSubmit'])) {
    date_default_timezone_set("Africa/Nairobi");
    $now = time();
    $time = strftime("%b-%d-%y %H:%M:%S", $now);

    if (empty($_POST['name']) || empty($_POST['comment']) || empty($_POST['email'])) {
        $_SESSION['errorMessage'] = "All required fields must be filled";
        redirect("post.php?id=" . $id);
    } elseif (strlen($_POST['comment']) <= 3) {
        $_SESSION['errorMessage'] = "Enter a valid comment";
        redirect("post.php?id=" . $id);
    } elseif (strlen($_POST['comment']) > 500) {
        $_SESSION['errorMessage'] = "Comment cannot exceed 500 characters";
        redirect("post.php?id=" . $id);
    } else {
        //insert to dbn
        global $connection;
        $sql = "INSERT INTO comments(name , email, comment, timestamp, post_id, approver) VALUES(:name, :email, :comment, :timestamp, :postId, 'pending' )";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':name', $_POST['name']);
        $statement->bindValue(':email', $_POST['email']);
        $statement->bindValue(':comment', $_POST['comment']);
        $statement->bindValue(':postId', $id);
        $statement->bindValue(':timestamp', $time);
        $execute = $statement->execute();

        if ($execute) {
            $_SESSION['successMessage'] = "Comment Added Successfully";
            redirect("post.php?id=" . $id);
        } else {
            $_SESSION['errorMessage'] = "We encountered an error trying to add the comment please try again";
            redirect("post.php?id=" . $id);
        }
    }
}

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
    <title>BlogKe | Article</title>
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
                    <a href="index.php" class="nav-link"><i class="fa-solid fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Features</a>
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
        <div class="col-sm-10 offset-1">
            <?php echo errorMessage(); ?>
            <?php echo successMessage(); ?>
            <div class="card bg-dark text-light">
                <img class="img-fluid card-img-top" src="uploads/<?php echo $post['image'] ?>" alt="">
                <div class="card-body">
                    <h4 class="card-title">
                        <?php echo $post['title']; ?>
                    </h4>
                    <small class="text-muted"><i>Article by <a class="link"><?php echo $post['author']; ?></a>
                            on <?php echo substr($post["timestamp"], 0, 9); ?></i></small>
                    <span class="badge bg-secondary float-end">comments 20</span>
                    <hr>
                    <p class="card-text"><?php echo $post['body'] ?></p>
                </div>
            </div>
            <div class="my-3 bg-light p-4 rounded border-info">
                <h4 class="text-sm text-decoration-underline">comments</h4>
                <?php
                $query = "SELECT * FROM comments WHERE post_id = '$id'";
                $statement = $connection->query($query);
                $comments = $statement->fetchAll();
                foreach ($comments

                         as $comment) {
                    ?>
                    <div class="media d-flex">
                        <img src="images/image.png" alt="user profile" class="mx-2 img-fluid align-self-start" width="100" height="100">
                        <div class="media-body ml-2">
                            <h6 class="lead"><?php echo $comment['name'] ?></h6>
                            <p class="small"><?php echo $comment['timestamp'] ?></p>
                            <p class="small"><?php echo $comment['comment'] ?></p>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
            <div class="mt-5">
                <form action="post.php?id=<?php echo $post['id'] ?>" method="post">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4>Share your thoughts on the article</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas py-1 fa-user"></i></span>
                                    </div>
                                    <input class="form-control" id="name" type="text" name="name"
                                           placeholder="User name">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas py-1 fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control" id="email" type="text" name="email" placeholder="Email">
                                </div>
                                <div class="form-group mt-3">
                                    <textarea class="form-control" name="comment" id="" cols="30" rows="5"></textarea>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" name="commentSubmit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
