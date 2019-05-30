@extends('layout.frontLayout')

@section('title')
    Register
@endsection

@section('content')

    @section('css')
        @parent
        <link rel="stylesheet" href="{{asset('/')}}css/forma.css">
    @endsection

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-login">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                        <a href="#" class="active" id="login-form-link">Login</a>
                </div>
                <div class="col-xs-6">
                        <a href="#" id="register-form-link">Register</a>
                </div>
            </div>
            <hr>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="login-form" action="{{ asset('/register/login') }}" method="post" role="form" style="display: block;">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" name="korisnickoIme" id="korisnickoIme" tabindex="1" class="form-control" placeholder="Username" value="">
                        </div>
                        <div class="form-group">
                                <input type="password" name="lozinka" id="lozinka" tabindex="2" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                                <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="logKorisnik" id="login-submit" tabindex="4" class="form-control btn btn-login" value="LogIn">
                                        </div>
                                </div>
                        </div>
                    </form>
                    <form id="register-form" action="{{ asset('/register/reg') }}" method="post" role="form" style="display: none;" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                                <input type="text" name="korisnickoIme" id="tbUsername" tabindex="1" class="form-control" placeholder="Username" onKeyUp="proveraUsername();">
                        </div>
                        <div class="form-group">
                                <input type="text" name="ime" id="tbFirstName" tabindex="1" class="form-control" placeholder="Name" onKeyUp="proveraFirstName();">
                        </div>
                        <div class="form-group">
                                <input type="text" name="prezime" id="tbLastName" tabindex="1" class="form-control" placeholder="Prezime" onKeyUp="proveraLastName();">
                        </div>
                        <div class="form-group">
                                <input type="text" name="email" id="tbEmail" tabindex="2" class="form-control" placeholder="E-mail" onKeyUp="proveraEmail();">
                        </div>
                        <div class="form-group">
                                <input type="password" name="lozinka" id="tbPassword" tabindex="2" class="form-control" placeholder="Password" onKeyUp="proveraPassword();">
                        </div>
                        <div class="form-group">
                                <input type="password" name="lozinka_confirmation" id="tbPassword2" tabindex="2" class="form-control" placeholder="Repeat password" onKeyUp="proveraPassword2();">
                        </div>
                        <div class="form-group">
                            <p>Profilna slicica:</p>
                            <label class="btn btn-success">Your avatar
                                <input type="file" name="slika" id="fileChooser" tabindex="2" class="form-control" style="display: none;" onchange="return ValidateFileUpload()"></label>
                            <img src="images/noimg.jpg" id="blah" width="50px" height="50px">
                        </div>
                        <div class="form-group">
                                <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="btnRegister" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register">
                                        </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    @section('ajax')
        @parent
        <script src="{{asset('/')}}js/provera.js"></script>
    @endsection

@endsection