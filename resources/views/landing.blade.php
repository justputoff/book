<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }
        .navbar {
            background-color: #ff6347;
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 1rem;
        }
        .card {
            border: 1px solid #ff6347;
        }
        .card-footer {
            background-color: #ffebcd;
        }
        footer {
            background-color: #ff6347;
            color: #ffffff;
        }
        footer a {
            color: #ffffff;
        }
        .btn-primary {
            background-color: #4682b4;
            border-color: #4682b4;
        }
        .btn-primary:hover {
            background-color: #5a9bd4;
            border-color: #5a9bd4;
        }
        .bg-custom {
            background-color: #ffebcd;
        }
        .text-custom {
            color: #ff6347;
        }
        .dino {
            position: relative;
            /* width: 350px;
            height: 350px; */
            background-size: cover;
            z-index: 10;
            pointer-events: none; /* Added this */
        }
        @keyframes walk {
            0% { left: 0; }
            100% { left: 100%; }
        }
        .dino a {
            animation: walk 10s linear infinite;
            z-index: 20;
            position: relative;
            pointer-events: auto; /* Added this to enable click on link */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">BookStore</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books.list') }}">Book List</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @for ($i = 0; $i < 3; $i++)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></li>
                @endfor
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="https://images.unsplash.com/photo-1512820790803-83ca734da794?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDF8fGJvb2t8ZW58MHx8fHwxNjY1NzY0NzY0&ixlib=rb-1.2.1&q=80&w=1080" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Welcome to BookStore</h5>
                        <p>Discover a variety of books</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fGJvb2t8ZW58MHx8fHwxNjY1NzY0NzY0&ixlib=rb-1.2.1&q=80&w=1080" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Explore New Arrivals</h5>
                        <p>Find the latest books in our collection</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://images.unsplash.com/photo-1519681393784-d120267933ba?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDN8fGJvb2t8ZW58MHx8fHwxNjY1NzY0NzY0&ixlib=rb-1.2.1&q=80&w=1080" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Join Our Community</h5>
                        <p>Connect with other book lovers</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="dino mt-5 p-2 border-bottom border-top w-100">
            <a href="{{ route('books.create') }}" target="_blank" class="btn btn-sm btn-primary">Upload Buku</a>
        </div>

        <h1 class="text-center mb-4 mt-5 text-custom">Our Books</h1>
        <div class="row">
            @foreach($books as $book)
            <div class="col-md-4 mb-3">
                <div class="card h-100 bg-custom">
                    <img src="{{ Storage::url($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-custom">{{ $book->title }}</h5>
                        <p class="card-text">Author: {{ $book->author }}</p>
                        <p class="card-text">ISBN: {{ $book->isbn }}</p>
                        <p class="card-text">Pages: {{ $book->page }}</p>
                        <span class="badge badge-info">New</span>
                    </div>
                    <div class="card-footer">
                        <a href="{{ Storage::url($book->pdf) }}" class="btn btn-primary">See Book</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <footer class="bg-dark text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">BookStore</h5>
                    <p>
                        Your one-stop destination for all kinds of books. Join our community and explore a world of knowledge.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="{{ route('books.list') }}" class="text-white">Book List</a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="text-white">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-white">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-secondary text-white">
            © 2023 BookStore. All rights reserved.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
