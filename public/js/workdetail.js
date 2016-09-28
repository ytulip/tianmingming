var newImg = 0;

function dropHandleEvent(event){
    var info = "",file,data;
    event.stopPropagation();
    event.preventDefault();
    if(event.type == 'drop'){
        file = event.dataTransfer.files[0];
        if(!file){
            return;
        }
        //console.log(file.type);
        if(file.type.search('image') === -1){
            alert('不支持的文件格式!');
            return;
        }

        newImg++;

        var currentNewImg = newImg;
        $('#work-detail-panel').append('<img class="detail-img" new-img="'+currentNewImg+'"/>');

        var formData = new FormData();
        formData.append('pic',file);
        $.ajax({
            url:'/app.php/saveworkdetailimg',
            data:formData,
            type:'post',
            contentType: false,
            processData: false,
            dataType:'json',
            success:function(data){
                if(data.status){
                    $('img[new-img="'+currentNewImg+'"]').attr('src',data.path);
                    /*EMASCript 6的多行字符串*/
                    $("html,body").animate({scrollTop:($('img[new-img="'+currentNewImg+'"]').offset().top)},1000);
                }
            }
        });

    }
}

var contentWrapper = document.querySelector('html');
contentWrapper.addEventListener('dragenter',dropHandleEvent,false);
contentWrapper.addEventListener('dragover',dropHandleEvent,false);
contentWrapper.addEventListener('drop',dropHandleEvent,false);
contentWrapper.addEventListener('dragleave',dropHandleEvent,false);

$('body').on('click','#work-detail-save',function(){
    /**
     * 工作详情图片
     */
    var imgs = '';
    $('.detail-img').each(function(){
        if($(this).attr('src')){
            imgs += $(this).attr('src') + ',';
        }
    });


    $.ajax({
        url:'/app.php/saveworkdetail',
        data:{id:$('input[name="id"]').val(),title:$('input[name="title"]').val(),imgs:imgs,describe:encodeURI($('#describe').html())},
        dataType:'json',
        async:false,
        success:function(data){
            //refreshWork();
            if(data.status){
                alert('保存成功！');
                location.reload();
            }else{
                alert('保存失败!');
            }
        },
        error:function(){
            alert('网络异常！');
        }
    });
});


/*加载删除按钮*/
$(function(){
    var anchorHtml = `<a id="scrollUp" style="position: fixed; z-index: 2147483647; display: block;"><i class="fa fa-trash-o"></i></a>`;
    $('body').append(anchorHtml);


    var scrollUpTarget = null;

    $('body').on('dragstart','.detail-img',function(event){
        scrollUpTarget = $(this);
    });

    $('body').on('dragend','.detail-img',function(event){
        scrollUpTarget = null;
    });

    $('body').on('drop','#scrollUp',function(event){
        event.stopPropagation();
        event.preventDefault();
        if(scrollUpTarget){
            scrollUpTarget.remove();
        }
    });
});
