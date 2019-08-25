@extends('home')

@section('content')
@if($message = Session::get('success'))
        <div class ="alert alert-success">
            <p>{{$message}}</p>
        </div>
@endif
@if($message = Session::get('danger'))  
<div class ="alert alert-danger">
            <p>{{$message}}</p>
        </div>      
        @endif
        <div class="notif">
        	<ul>
        	@foreach($DotXet as $key)
        	@if ($key->Status == 0)
        		<li class='timeout'></li>
        	@endif
        	@if ($key->Status == 1)
        		<li class='active'></li>
        	@endif
        	@endforeach
        	</ul>
        </div>
	<form action="{{ URL('dangkytn') }}" method="POST" role="form">
		{{ csrf_field() }}
		<div class="form-group">
			<input type="hidden" name="MaSV" class="form-control" value="{{ Auth::user()->MaSV }}"/>
		</div>
		
        <div class="alert-dk alert-success"></div>
        <div class="dotxet-1">
            <table class = "bangdiem-l">
                <tr>
                    <th>Mã</th>
                    <th>Đợt xét</th>
                    <th>Trạng thái</th>
                    <th>Thời gian bắt đầu</th>
                    <th>Thời gian kết thúc</th>
                    <th>Hành động</th>
                </tr>
                @foreach($DotXet as $key)
                <tr>
                    <td>{{ $key->MaDX }}</td>
                    <td>{{ $key->TenDX }}</td>
                    <td>
                        @if( $key->Status == 0)
                            <div class="status-dx-off"><strong>Đã đóng</strong></div>
                        @else
                            <div class="status-dx-on"><strong>Đang mở</strong></div>
                        @endif
                    </td>
                    <td>{{ $key->NgayBatDau }}</td>
                    <td>{{ $key->NgayKetThuc }}</td>
                    <td>
                        <div class="form-group">
                            @if ($key->Status == 1)
                            <output type="button" name="DotXets_MaDX" id="dot-{{ $key->MaDX }}" value="{{ $key->MaDX }}" class="btn btn-primary rgdx" status="1">Đăng ký</output>
                            @else
                            <output type="button" name="DotXets_MaDX" id="dot-{{ $key->MaDX }}" value="{{ $key->MaDX }}" class="btn btn-primary rgdx" status="0">Chưa mở</output>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </form>


    <script type="text/javascript">
        $(document).ready(function(){
            
            isReg();
            $(".rgdx").each(function(){
                $(this).on("click", function(){
                    if($(this).attr("status") != 0){
                        var DotXets_MaDX = $(this).attr("value");
                        var MaSV = $('input[name="MaSV"]').val();
                        var _token = $('input[name="_token"]').val();
                        $(this).val("Đã đăng ký");
                        $(this).attr("disabled", "disabled");
                        $.ajax({
                            url: "/dangkytn",
                            method: "POST",
                            data:{
                                DotXets_MaDX: DotXets_MaDX,
                                MaSV: MaSV,
                                _token: _token,
                            },
                            success:function(result){
                                $('.alert-dk').html("Đăng ký thành công");
                                $('.alert-dk').css("padding", "10px");
                            },
                            error:function(xhr, status, error) {
                                console.log(xhr.responseText);
                            },
                        });
                    }
                    else{
                        $('.alert-dk').html("Đợt đăng ký này chưa mở");
                        $('.alert-dk').css("padding", "10px");
                    }
                })
            })


            function isReg(){
                var MaSV = $('input[name="MaSV"]').val();
                var _token = $('input[name="_token"]').val();
                var url = "/dotxet-status/"+MaSV;
                $.get(url,function(data){
                    var id = "#dot-"+data;
                    $(id).val("Đã đăng ký");
                    $(id).css("pointer-events", "none");
                    $(id).attr("disabled", "disabled");
                })
            }
        });
    </script>
@endsection