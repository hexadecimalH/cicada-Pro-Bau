$(document).ready(function(){
    $('.cont').hide();
    $('#two').show();
    $('.cancel').hide();
    $('.saveEdit').hide();
    $('.not-showing').hide();
});
//function for switching between pannels
function switchPannels(e){
    var id = $(e.target).attr('data-id');
    $('.cont').hide();
    $('#'+id).show();
}
//listening for upload button and tringerring input upload
$(document).on('click','button.upload',function(){
    var upload = $(this).next();
    $(upload).click();
});

//listening for change in input upload button
$('#upload').on('change',function(){
    var data = new FormData();
    for (var i = 0; i < $(this).get(0).files.length; ++i) {
        data.append('pic-'+i, $(this).get(0).files[i]);
    }
    uploadPic(data, this);
});
//listening for change in input upload button
$('#uploadSlider').on('change',function(){
    var data = new FormData();
    data.append('pic', $(this).get(0).files[0]);
    uploadPic(data, this);
});
//function for sending pictures to the Back-end
function uploadPic(data, object){
    var folderName = ($(object).attr('id') == 'upload') ? "gallerypictures" : "projectpictures";
    $.ajax({
        url: "/upload-pictures/"+folderName,
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        storePictureToPannel(data, object);
    });
}
//displaying picture after storing it on the disk
function storePictureToPannel(data,obj){
    var containerClass = ($(obj).attr('id') == 'upload') ? "upload-pannel" : "holder";
    var hiddenInput = $(obj).next();
    var urls = '';
    $(data).each(function(el,url){
        var image = $('<img>',{'class': 'pic'});
        $(image).attr('src',url);
        var x = $('<img>', { 'class':'closeX permanent'}).attr('data-url',url);
        $(x).attr('src','/front-end/img/x.png');
        var div = $('<div>', {'class':'col-sm-3 fixed'});
        $(div).append(image,x);
        $('.'+containerClass).append(div);
        urls += url+",";
    });
    $(hiddenInput).val(urls);
}

$('.save').on('click',function(){
    var type = ($(this).attr('id') == "save") ? 'gallery':'projects';
    var urls = $(this).prev().val().split(',');
    var data = new FormData();
    $(urls).each(function(i,el){
        if(el.length != 0){
            data.append('url-'+i, el);
        }
    });
    if(type == 'gallery'){
        storeGalleryPics(data);
    }
    else{
        storeProject(data);
    }
});

function storeGalleryPics(data){
    $.ajax({
        url: "/store/gallery-picture",
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        placeGalleryPictures(data);
    });
}

function placeGalleryPictures(data){
    var divs = $('.upload-pannel').children();
    $('.upload-pannel').empty();
    $(data).each(function(i,el){
        $(divs[i]).find('.closeX').removeClass('permanent').attr('data-id', el.id);
    });
    $('.galleryPics').append(divs);
}

function storeProject(data){
    var title = $('#title').val();
    $('#title').val('');
    var about = $('#about').val();
    $('#about').val('')
    $('.holder').empty();
    data.append('title', title);
    data.append('about',about);
    $.ajax({
        url: "/store/projects",
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        placeProject(data);
    });
}

function placeProject(data){
    var row = $('<tr>');
    var cellOne = $('<td>');
    var div = $('<div>',{'class':'col-sm-3'});
    var img = $('<img>',{'class': 'pic'});
    $(img).attr('src', data.url);
    $(div).append(img);
    $(cellOne).append(div);
    var cellTwo = $('<td>').text(data.name);
    var cellThree = $('<td>').text(data.about);
    var cellFour = $('<td>');
    var edit = $('<button>',{'class':'btn btn-default edit', 'text':'Bearbeiten'});
    var del = $('<button>',{'class':'btn btn-danger delete', 'text':'Löschen'}).attr('data-id',data.id);
    var cancel = $('<button>',{'class':'btn btn-default cancel', 'text':'Annullieren'});
    var save = $('<button>',{'class':'btn btn-success saveEdit', 'text':'Speichern'}).attr('data-id',data.id);
    $(cellFour).append(edit,del,cancel,save);
    $(cancel).hide();
    $(save).hide();
    $(row).append(cellOne, cellTwo, cellThree, cellFour);
    $('table').append(row);
}

$(document).on('click','.closeX',function(){
    if($(this).attr('class').includes('permanent')){
        var url = $(this).attr('data-url');
        deleteUploaded(url);
    }
    else{
        var id = $(this).attr('data-id');
        deleteStoredToDb(id);
    }
});

function deleteUploaded(url){
    var divImg = $('img[data-url="'+url+'"]').parent();
    console.log(divImg);
    $(divImg).hide();
    var data = new FormData();
    data.append('url', url);
    $.ajax({
        url: "/delete/stored-picture",
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        console.log(data);
    });
}

function deleteStoredToDb(id){
    var divImg = $('img[data-id="'+id+'"]').parent();
    console.log(divImg);
    $(divImg).hide();
    $.ajax({
        url: "/delete/picture/"+id,
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        console.log(data);
    });
}

$(document).on('click','button.delete',function(){
    var id = $(this).attr('data-id');
    var self = this;
    $.ajax({
        url: "/delete/project/"+id,
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        $(self).parent().parent().hide();
    });
});
$(document).on('click','button.edit', function(){
    var cell = $(this).parent();
    $(cell).children().hide();
    $(cell).find('.saveEdit').show();
    $(cell).find('.cancel').show();
    var row = $(this).parent().parent();
    var cells = $(row).children();
    var textOne = $(cells[1]).text().trim();
    $(cells[1]).empty();
    $('<input>',{'id': 'name'}).val(textOne).appendTo(cells[1]);
    var textTwo = $(cells[2]).text().trim();
    $(cells[2]).empty();
    $('<input>',{'id': 'about'}).val(textTwo).appendTo(cells[2]);
});

$(document).on('click','button.cancel', function(){
    var cell = $(this).parent();
    $(cell).children().hide();
    $(cell).find('.delete').show();
    $(cell).find('.edit').show();
    var row = $(this).parent().parent();
    var cells = $(row).children();
    var textOne = $(cells[1]).find('input#name').val();
    $(cells[1]).empty().text(textOne);
    var textTwo = $(cells[2]).find('input#about').val();;
    $(cells[2]).empty().text(textTwo);  
});

$(document).on('click','button.saveEdit',function(){
    var id = $(this).attr('data-id');
    var cell = $(this).parent();
    $(cell).children().hide();
    $(cell).find('.delete').show();
    $(cell).find('.edit').show();
    var row = $(this).parent().parent();
    var cells = $(row).children();
    var textOne = $(cells[1]).find('input#name').val();
    $(cells[1]).empty().text(textOne);
    var textTwo = $(cells[2]).find('input#about').val();;
    $(cells[2]).empty().text(textTwo);  
    saveChanges(id,textOne,textTwo);
});

function saveChanges(id, name, about){
    var data = new FormData();
    data.append('name', name);
    data.append('about', about);
    $.ajax({
        url: "/edit/project/"+id,
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        console.log(data);
    });
}