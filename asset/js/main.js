$(function() {
	
	var getNowbuybottomAndRight = function() {
		var
		about_height = $('.about').outerHeight(),
		about_width = $('.about').outerWidth(),
		$position = $('.buy').position(),
		bottom = about_height - ($position.top + 70),
		right = about_width - ($position.left + 150);
		
		return {'bottom': bottom, 'right': right};
	}

	$(window).resize(function(){

		var nowbuy = getNowbuybottomAndRight();

		$('#now-buy').css({bottom: nowbuy.bottom+'px', right: nowbuy.right+'px'});
	});
	
	$('#iview').iView({
		pauseTime: 8000,
		pauseOnHover: true,
		directionNav: false,
		controlNav: true,
		controlNavNextPrev: false,
		controlNavThumbs: true,
		controlNavHoverOpacity: 1
	});
	
	$("#distpicker").distpicker({autoSelect: false});
	
	$("#distpicker select").on("change",function(){
		var $select = $(this);
		var $option = $select.children();
		if($option.eq(0).attr("selected")){
			$select.css({"color":"#aaa"});
		}
		else{
			$select.css({"color":"#333"});
		}
	});
	
	$('.color a').on('click', function(){
		var $this = $(this);
		$this.siblings('.active').removeClass()
			.end().addClass('active');
		$('#color').val($this.data('color'));
	});
	
	$('#now-buy').on('click', function(){

		var nowbuy = getNowbuybottomAndRight();

		$('#now-buy').css({bottom: nowbuy.bottom+'px', right: nowbuy.right+'px'})
				.velocity({right: '30px',bottom: '30px',opacity: 0}, 300);
		
		$('#order-submit').velocity({opacity: 1, display:'block'}, {delay: 300, begin: function(){
			$(this).css('display', 'block');
			$('#order-cancel').css('display', 'block');
		}});
		
		var
		colorTop = $('.intr').position().top + 30,
		aboutHeight = $('.about').outerHeight();
		
		$('.order').velocity({
			opacity: 1,
			width: '100%',
			height: aboutHeight - colorTop + 'px',
			borderRadius: 0,
			backgroundColor: '#fff',
			bottom: 0,
			left: 0,
			marginTop: 0,
			zIndex: 1
		},
		{
			delay: 400,
			duration: 400,
			complete: function(){
				$('#linkman').velocity({opacity: 1}).focus();
				$('#mobile').velocity({opacity: 1}, {delay: 200});
				$('#distpicker').velocity({opacity: 1}, {delay: 300});
				$('#address').velocity({opacity: 1}, {delay: 400});
				$('#quantity').velocity({opacity: 1}, {delay: 500});
				$('#message').velocity({opacity: 1}, {delay: 600});
				$('#order-cancel').velocity({opacity: 1, right: '200px'});
			}
		});
	});
	
	$('#order-cancel').on('click', function(){
		
		$('#order-cancel').velocity('reverse', {begin: function(){
			$(this).css('display', 'none');
		}});
		
		$('#order-submit').velocity('reverse', {begin: function(){
			$(this).css('display', 'none');
		}});

		var nowbuy = getNowbuybottomAndRight();
		
		$('#now-buy').velocity({right: nowbuy.right+'px',bottom: nowbuy.bottom+'px',opacity: 1}, {duration: 300});
		
		$('.order,#linkman,#mobile,#distpicker,#address,#quantity,#message').velocity('reverse');
	});
	
	$('#more').on('click', function(){
		$('#details').velocity({height: '100%'}, {begin: function(){
			$('body').css('overflow', 'hidden');
		}});
		$('#details .content').velocity({paddingTop: 0, opacity: 1});
		$('#close').velocity({top: '+=100px'}, {delay: 300}).velocity({top: '-=20px'});
	});
	
	$('#close').on('click', function(){
		$(this).velocity({top: '+=20px'},200).velocity({top: '-150px'}, 400);
		$('#details').velocity({height: 0}, {delay: 300, complete:function(){
			$('body').css('overflow', '');
		}});
		$('#details .content').velocity('reverse');
	});
	
	$('#order-submit').click(function(){
		var
		item_id = $("#item_id").val(),
		color = $("#color").val(),
		linkman = $("#linkman").val(),
		mobile = $.trim($("#mobile").val()),
		quantity = $("#quantity").val(),
		province = $("#province").val(),
		city = $("#city").val(),
		district = $("#district").val(),
		address = $("#address").val();
		
		if(item_id == ''){
			alert('商品已下架！');
			location.reload();
			return false;
		}
		
		if(color == ''){
			alert('请选择商品的颜色！');
			return false;
		}
		
		if(linkman == ''){
			alert('请填写收货人的姓名！');
			$("#linkman").focus();
			return false;
		}
		
		if(mobile.length != 11 || !/^1[3|4|5|8|7][0-9]\d{8}$/.test(mobile)){
			alert('请填写有效的手机号码！');
			$("#mobile").focus();
			return false;
		}
		
		if(province == '' || city == ''){
			alert('请选择所在的地区！');
			return false;
		}
		
		if(address == ''){
			alert('请填写详细的街道和门牌号！');
			$("#address").focus();
			return false;
		}
		
		if(quantity == '' || parseInt(quantity) <= 0  ){
			alert('请填写购买的数量！');
			$("#quantity").focus();
			return false;
		}
		
		$(this).attr('disabled', true).text('请稍候...');

		var data = $('#order-form').serialize();

		$.post('./order', data, function(json) {
			if (json.code == 0) {
				alert(json.message);
				location.reload();
				//$('#order-cancel').trigger('click');
			} else {
				alert(json.message);
			}
			$('#order-submit').attr('disabled', false).text('提交订单');
		}, 'JSON');
	});
	
});
