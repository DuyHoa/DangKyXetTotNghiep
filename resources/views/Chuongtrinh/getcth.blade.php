@extends('home')

@section('sub-title')
<div class="sub-title">
    <a>Chương trình học</a>
</div>
@endsection

@section('banner-title')
<div class="banner-title">
    <a>Quản lý Chương trình học</a>
</div>
@endsection


@section('content')
@if($message = Session::get('success'))
    <div class ="alert alert-success">
        <p>{{$message}}</p>
    </div>
@endif
@if($message = Session::get('remove'))
    <div class ="alert alert-warning">
        <p>{{$message}}</p>
    </div>
@endif
@if(count($errors) > 0)
    <div class ="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </div>
@endif
<div class="add" style="padding-bottom: 15px"><a class="btn btn-success" href="{{ URL('/chuongtrinhhoc/create') }}">Tạo chương trình học</a></div>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<div class="form-group dfex" style="width: 100%;">
        <label for="MaKhoa" class="row col-md-3">Chọn Khoa:</label>
        <select name="Khoa" id="MaKhoa" class="form-control input-lg dynamic" data-dependent="MaNganh">
            <option value="">Chọn Khoa</option>
                @foreach(App\Khoa::all() as $key)
            <option value="{{ $key->MaKhoa}}">{{ $key ->TenKhoa }}</option>
                @endforeach
        </select>
    </div>
<div class="form-group dfex">
    <label for="MaNganh" class="row col-md-3">Chọn ngành:</label>
    <select name="Nganh" id="MaNganh" class="form-control input-lg dynamic">
        <option value="">Chọn ngành</option>
    </select>
</div>
<div class="form-group dfex">
    <label for="Keycode" class="row col-md-3">Chọn khóa:</label>
    <select name="Keycode" id="Keycode" class="form-control input-lg dynamic">
        <option value="">Chọn khóa</option>
            @foreach(App\course::all() as $key)
            <option value="{{ $key->course_code}}">{{ $key ->course_code }}</option>
            @endforeach
    </select>
</div>
<div>
    <strong>Môn đại cương</strong>
    <table class="bangdiem-l cthmdc">
        <tr>
            <th>Mã Môn</th>
            <th>Tên Môn</th>
            <th>Tin Chi</th>
        </tr>
    </table>
</div>
<div>
    <strong>Môn chuyên ngành</strong>
    <table class="bangdiem-l cthmcn">
         <tr>
            <th>Mã Môn</th>
            <th>Tên Môn</th>
            <th>Tin Chi</th>
        </tr>
        
    </table>
</div>
<div>
    <strong>Môn chuyên ngành (tự chọn)</strong>
    <table class="bangdiem-l cthcntc">
        <tr>
            <th>Mã Môn</th>
            <th>Tên Môn</th>
            <th>Tin Chi</th>
        </tr>
    </table>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#MaKhoa").change(function(){
        if($(this).val != ''){
            var select = $(this).attr("id"); //Makhoa--MaNganh
            var value = $(this).val(); //Makhoa--
            var dependent = $(this).data('dependent'); //MaNganh
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('dynamicdependent.fetch') }}",
                method: "POST",
                data:{
                    select:select,
                    value: value,
                    _token: _token,
                    dependent: dependent,
                },
                success:function(result){
                    $('#MaNganh').html(result);
                },
                error:function(mes){
                    console.log(mes);
                }
            });
        }
    });
    
    $('#Keycode').change(function() {
        var val = $("#MaNganh option:selected").val();
        var courseCode = $("#Keycode option:selected").val();
        var url = "/cth/"+val+"/"+courseCode;
        var sumdc = 0;
        var sumcn = 0;
        var sumcntc = 0
        var countdc = 0;
        var countcn = 0;
        var countcntc = 0;
        $(".bangdiem-l").empty();
        var temptr = $("<tr/>");
            temptr.append($("<th/>",{ text: "Mã Môn"
            })).append($("<th/>",{ text: "Tên Môn"
            })).append($("<th/>",{ text: "Tín chỉ"
            }));
        $(".bangdiem-l").append(temptr);
        $.get(url,function(data){
            $.each(data, function(i, value){
                var tr = $("<tr/>");
                    tr.append($("<td/>",{ text: value.MaMon
                    })).append($("<td/>",{ text: value.TenMon
                    })).append($("<td/>",{ text: value.Tinchi
                    }));
                    if(value.Term == 1){
                        $(".cthmcn").append(tr);
                        sumcn += value.Tinchi;
                        countcn++;
                    }
                    else if(value.Term == 0){
                        $(".cthmdc").append(tr);
                        sumdc += value.Tinchi;
                        countdc++;
                    }
                    else{
                        $(".cthcntc").append(tr);
                        sumcntc += value.Tinchi;
                        countcntc++;
                    }
            });
            $(".cthmdc").append($("<tr/>").append($("<td/>",{ text: "Tổng"
                    })).append($("<td/>",{ text: countdc+" môn"
                    })).append($("<td/>",{ text: sumdc+ " tín" })));
            $(".cthmcn").append($("<tr/>").append($("<td/>",{ text: "Tổng"
                    })).append($("<td/>",{ text: countcn+" môn"
                    })).append($("<td/>",{ text: sumcn+ " tín" })));
            $(".cthcntc").append($("<tr/>").append($("<td/>",{ text: "Tổng"
                    })).append($("<td/>",{ text: countcntc+" môn"
                    })).append($("<td/>",{ text: sumcntc+ " tín" })));
        });

    });
});
</script>
@endsection


@section('script')

@endsection