(function($, Drupal){
//  $(window).on('load', function(){
  //-----------------hiệu ứng menu chinh--------------------//
    if($("#block-menuchinh").length > 0){
      if($(".click-show-menu-left").length != 0){
        $(".click-show-menu-left").on("click", function(event){
          //if($("#block-menuchinh > ul > li:first-child > ul").is(":hidden")){
          if($("#block-views-block-menu-sidebar-block-1").is(":hidden")){
            //-----09/04------//
            $("#block-views-block-menu-sidebar-block-1").fadeIn();
          }
          //else if($("#block-menuchinh > ul > li:first-child > ul").is(":visible")){
          else if($("#block-views-block-menu-sidebar-block-1").is(":visible")){
            //----------------Ẩn menu chính----------------//
            //-----09/04------//
            $("#block-views-block-menu-sidebar-block-1").fadeOut();
          }
          $('.slideout-side-left .main-content > div > div >div > section').toggleClass('full-width');
          $('.slideout-side-left .main-content > div > div >div > aside').toggleClass('hidden-left');
        });
      }
      //--------------- click event - menu chính -----------------//
      //--------------- show menu con khi click ------------------//
      if($(".menu-chinh-quan-ly").length != 0){
        $(".menu-chinh-quan-ly").removeAttr("href");
        $(".menu-chinh-quan-ly").on("click", function(e){
          if($("#block-menuchinh > ul > li:last-child > ul").is(":hidden")){
            $("#block-menuchinh > ul > li:last-child > ul").fadeIn();
          }
          else if($("#block-menuchinh > ul > li:last-child > ul").is(":visible")){
            $("#block-menuchinh > ul > li:last-child > ul").fadeOut();
          }
        });
      }

      all_in_one();

      $(".menu-chinh-subscribe ~ ul>li>a").text("");
      function all_in_one(){
        if($("#block-menuchinh > ul > li:first-child > ul").is(":hidden")){
          if($(".path-taxonomy").length != 0){

          }
        }
            //------------------- thay đổi icon danh muc ---------------------//
            //--------------------đây màn hình-------------------------------//
            $(".slideout-side-left .main-content.region--dark-typography.region--white-background > div > div > div > section").removeClass("col-md-12 col-md-8 col-md-push-4 ").toggleClass('col-sm-push-2 col-sm-10 body-cus-style');
            //------------------------------
            //--DS-09/04-menu-side-left---//
            //------------------------------
            $(".slideout-side-left .main-content.region--dark-typography.region--white-background > div > div > div aside").removeClass("col-md-4 col-md-pull-8 ").toggleClass(' col-sm-2 col-sm-pull-10');
            //------------------------------
            //--CT-09/04-menu-side-left---//
            //------------------------------
            $(".page-node-type-article .clearfix.main-content__container > .row > section").removeClass(" col-md-8 col-md-push-4 ").toggleClass('col-sm-10 col-sm-push-2 col-xs-12 body-cus-style full-width');
            $(".page-node-type-article .clearfix.main-content__container > .row aside").removeClass("col-md-4 col-md-pull-8 ").toggleClass(' col-sm-2 menu-cus-style hidden-left');
            
            if($("#block-menuchinh > ul > li:first-child > ul > li.menu-item--expanded > ul").is(":visible")){
              //---------------------------thay đổi icon-----------------------------//
              $(".menu-chinh-sub-blog").removeClass('change-turnOff').toggleClass('change-turnOn');
            }
      }
    
  }
  //----------------sửa theme----------------//
  if($(".path-taxonomy").length != 0 || $(".path-frontpage").length != 0 || $(".path-tim-kiem").length != 0){
    $(".slideout-side-left .main-content > div").removeClass('container').toggleClass('container-fluid');
  }
  // Gán title vào ô tìm kiếm (Khi gõ tìm kiếm quá dài sẽ bị che text thì khi hover vào input text sẽ hiện full dưới dạng tooltip)
  function add_title_search_input(){
    var input_value = $('div#block-exposedformdanh-sach-bai-dangpage-3 .form-item input').val();
    $('div#block-exposedformdanh-sach-bai-dangpage-3 .form-item input').attr('title',input_value);
  }
  $('div#block-exposedformdanh-sach-bai-dangpage-3 .form-item input').on('keyup',function(){
    add_title_search_input();
  });
    add_title_search_input();

  //----------scrol------------
  $(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    if(scroll > $(window).height() / 3){
      $(".to-top").fadeIn();
    }
    if(scroll >= "56px"){
        $("#block-menuchinh > ul").css("box-shadow", "0 1px 5px 1px rgba(0, 0, 0, 0.17)");
    }
    if(scroll < "56px")
        $("#block-menuchinh > ul").css("box-shadow","none");
    if (scroll < $(window).height() / 3){
      $(".to-top").fadeOut();
    }
  });
//click để hiện thông tin User trên top right
  $('.account-icon img').on('click',function(){
    $('.drowdown-info').toggle(500);
  });
// thêm mãu vào menu bên trái
  $('nav[id*="block-menusidebar"] ul.clearfix > li').each(function(){
    var color = $(this).find('a').attr('title');
    if($(this).hasClass('menu-item--active-trail')){
       $(this).children('a').css('color',color);
    }
      $(this).children().append('<span style="background:'+color+'"></span>');
 })
// Hàm lấy mã màu cho chuyên mục.
function settingcolor_background(){
    var arr = [];
    // Lấy mã màu và tid tương ứng để đổ màu
    $('nav[id*="block-menusidebar"] ul.clearfix > li').each(function(){
        var color = $(this).find('a').attr('title');
        var str = $(this).find('a').attr('data-drupal-link-system-path');
        var number_string = str.match(/\d+/g);
        // truyền key và array vào mảng rỗng
        arr.push({
            number: number_string[0], 
            color:  color
        });
        if($(this).hasClass('menu-item--active-trail')){
          $(this).children('a').css('color',color);
        }
        $(this).children().append('<span style="background:'+color+'"></span>');
    })
    // lấy toàn bộ tất cả term để đổ màu
     $('span[class*="term-"]').each(function(){
        var str1 = $(this).attr('class');
        var number_string1 = str1.match(/\d+/g);

        // lặp mảng arr và kiểm tra phần tử tồn tại trong mảng thì bắn màu tương ứng
        for(var i = 0 ; i < arr.length ; i ++) {
            if(arr[i].number === number_string1[0]){
              $(this).children().css('background',arr[i].color);
            }
        }
    });
    
    // Lấy mã màu cho chuyên mục trong chi tiết tin 
    $('.danhmuc-detial').each(function(){
      var danhmuc_color = $(this).attr('danhmuc-color');
      $(this).css('background',danhmuc_color);
    });
    // Lấy mã màu cho tiêu đề trong chi tiết tin tức
    var bg_color = $('.title-acticle').attr('bg-title');
    $('.title-acticle').css('background',bg_color);
    $('.title-acticle-head > div:first-child a').css('color',bg_color);
    
  } //end funtion
  settingcolor_background();
  $( document ).ajaxComplete(function( event, request, settings ) {
    settingcolor_background();
  });
  // Color herotop
  var color_herotag = $('.TagHero').attr('color-taghero');
  $('.TagHero').css('background',color_herotag);
  if(color_herotag == ''){
    $('.TagHero h2, .TagHero p ').css('color','#667d99');
  }
})(jQuery, Drupal);