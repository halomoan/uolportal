<div class="jumbotron text-center">
    <div class="container">
        <h1>Welcome To UOL Portal</h1>
        <p class="lead">We Have Chat Bot To Serve You</p>
        @if(auth()->check())
            <p><a class="btn btn-primary btn-lg" href="dashboard" role="button">Dashboard &raquo;</a></p>
        @endif
    </div>
</div>