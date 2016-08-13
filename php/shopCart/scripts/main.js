/**
 * 添加商品到购物车
 * @int pid
 */
function addCart(pid) {
    var num = parseInt($('#pNum').html());
    var data = {'pid':pid,'num':num};
    $.post('doAction.php',data,function(data){
        alert(data.msg);
    },'json');
}
/**
 * 改变购物车中的商品数量
 * @param pId
 * @param num
 */
function changeNum(pId,num){
    var data = {'pId':pId,'num':num};
    var price = $('#price-'+pId).html();
    var allTotal = $('#alltotal').html();
    $.post('changNum.php',data,function(data){
        if (data.status===1) {  //当商品数量改变并成功提交到数据库时,同时改变购物车中的该商品的总价格
            $('#total-'+pId).html(price*num);
            $('#allTotal').html(data.msg);
        }
    },'json');
}
/**
 * 点击删除按钮删除该商品的记录,并更新总价格
 * @param pId
 */
function delProduct(pId){
   $.post('delProduct.php',{'pId':pId},function (data) {
       if (data.status == 1) {
           $('#product-'+pId).remove();   //移出该商品的html代码
           $('#allTotal').html(data.msg);  //更新总价
       }
   },'json');
}
/**
 * 清空用户购物车中数据
 */
function delAll(){
    $.post('delAll.php',{},function (data) {
        if (data.status == 1) {
            $('.product').remove();
            $('#allTotal').html('');
        }
    },'json');
}

$(function(){
    //单击商品数量减少按钮
	$('#num-left-btn').click(function(){
        num = $('#pNum').html();
        if (num > 1) {
            $('#pNum').html(num-1);
        }
    });
    //单击商品熟练增加按钮
    $('#num-right-btn').click(function(){
        num = $('#pNum').html();
        var limitNum = $('#limit-num').html();
        if (num < parseInt(limitNum)) {
            $('#pNum').html(parseInt(num)+1);
        }
    });


    
	
	
    
});

