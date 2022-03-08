<?php
require_once("includes/db.php");
require_once("includes/helpers.php");
require_once("includes/sessions.php");
global $connection;

$id = $_GET['id'];
if (isset($_POST['submit'])) {
    $query = "DELETE FROM posts WHERE id = '$id'";
    $execute = $connection->query($query);
    if ($execute) {
        $_SESSION['successMessage'] = "Post Deleted Successfully";
        redirect("dashboard.php");
    } else {
        $_SESSION['errorMessage'] = "We encountered an error please try again";
        redirect("dashboard.php");
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
    <title>Blog | Delete</title>
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
                    <a href="#" class="nav-link"><i class="fa-solid fa-user"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link ">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="categories.php" class="nav-link active">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Blogs</a>
                </li>
            </ul>
            <ul class="nav ms-lg-auto me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="#" class="nav-link logout">Logout <i
                                class="fa-solid text-danger fa-right-from-bracket"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<header class="bg-dark text-white py-4">
    <div class="container">
        <div class="row col-md-12">
            <h1><i class="fas fa-trash text-primary"></i> Delete Blog Post</h1>
        </div>
    </div>
</header>

<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-lg-10 offset-lg-1" style="min-height: 450px">
            <?php
            echo errorMessage();
            echo successMessage();
            $id = $_GET['id'];
            $query = "SELECT * FROM posts WHERE id = '$id'";
            $statement = $connection->query($query);
            $post = $statement->fetch();
            ?>
            <form action="delete.php?id=<?php echo $id; ?>" method="post" class="" enctype="multipart/form-data">
                <div class="card bg-dark text-light mb-3">
                    <div class="card-body mb-3">
                        <div class="form-group">
                            <p class="fs-3 fw-bold">Post Title: <?php echo $post['title'] ?></p>
                        </div>
                        <div class="form-group mt-3">
                            <p for="">Category: <?php echo $post['category'] ?></p>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <p for="">Thumbnail: <?php echo $post['image'] ?></p>
                        </div>
                        <div class="form-group mt-2">
                            <label for="postBody">Post Body:</label>
                            <textarea disabled class="form-control" name="postBody" id="postBody" cols="30"
                                      rows="10"><?php echo $post['body'] ?></textarea>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-6 d-grid mb-2">
                                <a class="btn btn-lg btn-primary btn-block" href="dashboard.php"><i
                                            class="fas fa-arrow-left"></i> Back to Dashboard</a>
                            </div>
                            <div class="col-lg-6 d-grid mb-2">
                                <button class="btn btn-lg btn-danger btn-block" type="submit" name="submit"><i
                                            class="fa-solid fa-trash-can-check"></i> Delete Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

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