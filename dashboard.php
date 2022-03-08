<?php
require_once("includes/db.php");
require_once("includes/helpers.php");
require_once("includes/sessions.php");

global $connection;
$query = "SELECT * FROM posts";
$statement = $connection->query($query);
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
    <title>Blog | Admin</title>
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
                    <a href="dashboard.php" class="nav-link active">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="categories.php" class="nav-link ">Categories</a>
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
        <div class="row ">
            <div class="col-md-12 mb-2">
                <h1><i class="fas fa-blog text-primary"></i> Admin Dashboard</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="createPost.php" class="btn btn-primary d-block btn-lg"><i class="fas fa-edit"></i> Create blog</a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="categories.php" class="btn btn-secondary d-block btn-lg"><i class="fas fa-list"></i> Add Category</a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="categories.php" class="btn btn-light d-block btn-lg"><i class="fas fa-user-plus"></i> Add Admins</a>
            </div>
            <div class="col-lg-3">
                <a href="categories.php" class="btn btn-warning d-block btn-lg"><i class="fas fa-check"></i> Review Comments</a>
            </div>
        </div>
    </div>
</header>

<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo errorMessage();
            echo successMessage();?>
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Author</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Published</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($posts as $post){ ?>
                    <tr>
                    <th scope="row"><?php echo $post["id"]?></th>
                    <td><?php  subst($post["title"]);?></td>
                    <td><?php echo $post["category"]?></td>
                    <td><?php echo $post["author"]?></td>
                    <td><img src="uploads/<?php echo $post["image"]?>" alt="<?php echo $post["image"]?>" width="100px" height="50px" ></td>
                    <td><?php echo $post["comments"]?? "Comments"?></td>
                    <td><?php echo substr($post["timestamp"],0,9);?></td>
                    <td><a href="edit.php?id=<?php echo $post['id']?>"><span class="btn btn-sm btn-warning">Edit</span></a> <a href="delete.php?id=<?php echo $post['id']?>" ><span class="btn btn-sm btn-danger">Delete</span></a> <a href="post.php?id=<?php echo $post['id']?>" class="btn btn-primary btn-sm" target="_blank">Preview</a></td>
                </tr>
               <?php } ?>
                </tbody>
            </table>
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