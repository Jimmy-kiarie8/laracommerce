<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/posts">Blog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/profiles">Profile</a>
      </li>
  </ul>
  <ul class="navbar-nav mr-auto navbar-right">
      @guest
        <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
      @else
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Notifications
          <span class="badge">{{ count(Auth()->user()->unreadNotifications) }}</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        {{--  <a class="btn btn-info btn-sm"  href="#">
            @foreach (Auth()->user()->unreadNotifications as $notification)
              @include('notification_'.snake_case(class_basename($notification->type)))
            @endforeach
         </a>
          <!-- <div class="dropdown-divider"></div> -->
        </div> --}}
                @endguest
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
  </div>
</nav>
<div class='clearfix' style="padding:2.5%;"></div>