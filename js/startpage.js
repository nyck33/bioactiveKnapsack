
function show_signin(){
    document.getElementById('signin-box').style.display='block';
}
function show_join(){
    document.getElementById('join-box').style.display='block';
}
function hide_modals(){
    document.getElementById('signin-box').style.display='none';
    document.getElementById('join-box').style.display='none';
}




//todo: jquery for menu sign in and join
//show signin on click
$(document).ready(function() {
    $("#menu-signin").click(function () {
    $("#blanket").css("display", "block")
    $("#signin-box").css("display", "block")
});
$("#menu-join").click(function () {
    $("#blanket").css("display", "block")
    $("#join-box").css("display", "block")
});
$("#blanket").click(function () {
    $("#blanket").css("display", "none")
    $("#signin-box").css("display", "none")
    $("#join-box").css("display", "none")
});
$("#cancel-signin-button").click(function () {
    $("#blanket").css("display", "none")
    $("#signin-box").css("display", "none")
    $("#join-box").css("display", "none")
});
$("#cancel-join-button").click(function () {
    $("#blanket").css("display", "none")
    $("#signin-box").css("display", "none")
    $("#join-box").css("display", "none")
});
});


