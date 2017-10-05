@extends('layouts.default')
@section('title', 'Đăng nhập')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <form class="form-signin mg-btm" action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    <h3 class="heading-desc">
                        Login to Zilack
                    </h3>
                    <div class="social-box">
                        <div class="row mg-btm">
                            <div class="col-md-12" style="text-align: center">
                                <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="login_with"
                                     onlogin="checkLoginState();" data-show-faces="false" data-auto-logout-link="false"
                                     data-use-continue-as="false"></div>
                            </div>
                        </div>
                    </div>
                    <div class="break-line"><span>OR</span></div>
                    <div class="main">
                        @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <input type="email" name="email" class="form-control" placeholder="Email" autofocus required>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="login-footer">
                        <div class="row">
                            <div class="col-xs-4 col-md-4 pull-right">
                                <button type="submit" class="btn btn-large btn-danger pull-right">Login</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('inline_scripts')

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '158489461404657',
                cookie     : true,
                xfbml      : true,
                version    : 'v2.10'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $(document).ready(function() {
            $(document).on('click', '#login-fb', function() {
                FB.getLoginStatus(function(response) {
                    console.log(response);
                });
            });

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }

        function statusChangeCallback(response) {
            $.ajax({
                method: "POST",
                url: "{{ route('login_fb') }}",
                data: { access_token: response.authResponse.accessToken}
            })
            .done(function(result) {
                if (result) {
                    window.location.href = "{{ route('charge') }}";
                } else {
                    alert('Login không thành công, xin vui lòng thử lại sau');
                }
            });
        }
    </script>
@endsection
