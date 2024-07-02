<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Control Panel</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <ul id="slide-out" class="side-nav fixed z-depth-4">
        <li>
            <div class="userView">
                <div class="background">
                    <img src="{{ asset('assets/admin/img/photo1.png') }}">
                </div>
                <a href="#!user"><img class="circle" src="{{ asset('assets/admin/img/avatar04.png') }}"></a>
                <a href="#!name"><span class="white-text name">Welcome back,</span></a>
                <a href="#!email"><span class="white-text email">user!</span></a>
            </div>
        </li>
        <li>
            <form class="sidebar-form">
                <div class="input-group">
                    <input id="accounts" type="text" name="username" class="form-control" placeholder="Universal Search"
                        autocomplete="off" />
                </div>
            </form>
        </li>
        <li><a class="active" href="index.html"><i class="material-icons pink-item">dashboard</i>Dashboard</a></li>
        <li>
            <div class="divider"></div>
        </li>
        <li><a class="subheader">Management</a></li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header">Category<i class="material-icons pink-item">person</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="{{route('category.index')}}">list</a></li>
                            <li><a href="{{route('category.create')}}">create</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="collapsible-header">Brand<i class="material-icons pink-item">person</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="{{route('brand.index')}}">list</a></li>
                            <li><a href="{{route('brand.create')}}">create</a></li> 
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="collapsible-header">Product<i class="material-icons pink-item">person</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="{{route('product.index')}}">list</a></li>
                            <li><a href="{{route('product.create')}}">create</a></li>
                            <li><a href="{{route('product.attribute')}}">attribute</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
    @yield('content')
    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                © 2017 Farooq Designs. All rights reserved.
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>


    @yield('api_representation')
</body>

</html>