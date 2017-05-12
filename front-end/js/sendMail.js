$('button').on('click',function(){
    sendMail();
});
function sendMail(){
    var name = $('#name').val();
    $('#name').val('');
    var mail = $('#mail').val();
    $('#mail').val('');
    var content = $('#content').val();
    $('#content').val('');
    var data = new FormData();
    data.append('name', name);
    data.append('mail', mail);
    data.append('content', content);
    $.ajax({
        url: "/send-mail",
        type: 'POST',
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
        console.log(data);
    });
}