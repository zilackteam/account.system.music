@extends('layouts.default')
@section('title', 'Nạp thẻ')

@section('content')
    <div id="page-charge">
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Zilack</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="user"><i class="fa fa-user fa-fw"></i> {{ $user->name }}</a></li>
                        <li>
                            <a href="#">
                            @if (isset($user->user_info))
                                {{ number_format($user->user_info->balance) }}
                            @else
                                0
                            @endif
                                VND
                            </a>
                        </li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <h1 class="page-title"><i class="fa fa-star" aria-hidden="true"></i> Nạp thẻ</h1>
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @elseif(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <hr>
            <form action="{{ route('charge.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" id="card-type" name="provider">
                <div class="title-card">Lựa chọn loại thẻ</div>
                <div class="row choose-card">
                    <div class="col-md-2 col-xs-3">
                        <img src="{{ asset('img/viettel.png') }}" class="img-responsive" data-id="VTT">
                    </div>
                    <div class="col-md-2 col-xs-3">
                        <img src="{{ asset('img/vinaphone.png') }}" class="img-responsive" data-id="VNP">
                    </div>
                    <div class="col-md-2 col-xs-3">
                        <img src="{{ asset('img/mobifone.png') }}" class="img-responsive" data-id="VMS">
                    </div>
                </div>
                <br>
                <div class="title-card">Mệnh giá thẻ</div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Giá</th>
                                    <th>Tiền nhận được</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10.000 VND</td>
                                    <td>10.000 VND</td>
                                </tr>
                                <tr>
                                    <td>20.000 VND</td>
                                    <td>20.000 VND</td>
                                </tr>
                                <tr>
                                    <td>50.000 VND</td>
                                    <td>50.000 VND</td>
                                </tr>
                                <tr>
                                    <td>100.000 VND</td>
                                    <td>100.000 VND</td>
                                </tr>
                                <tr>
                                    <td>200.000 VND</td>
                                    <td>200.000 VND</td>
                                </tr>
                                <tr>
                                    <td>300.000 VND</td>
                                    <td>300.000 VND</td>
                                </tr>
                                <tr>
                                    <td>500.000 VND</td>
                                    <td>500.000 VND</td>
                                </tr>
                                <tr>
                                    <td>1.000.000 VND</td>
                                    <td>1.000.000 VND</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="serie">Số serie:</label>
                            <input type="text" name="serial" class="form-control" id="serie" placeholder="Số serie" required>
                        </div>
                        <div class="form-group">
                            <label for="code">Mã nạp thẻ:</label>
                            <input type="text" name="pin" class="form-control" id="code" placeholder="Mã nạp thẻ" required>
                        </div>
                        <button type="submit" class="btn btn-danger" id="charge-button" style="width: 100%">Tiến hành thanh toán</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('inline_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
           $(document).on('click', '.choose-card .img-responsive', function() {
                $('.choose-card .img-responsive').removeClass('selected');
                $(this).addClass('selected');
                $('#card-type').val( $(this).data('id'));
           });

            $(document).on('click', '#charge-button', function(event) {
                if (!$('#card-type').val()) {
                    alert('Xin hãy chọn loại thẻ cần nạp');
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
