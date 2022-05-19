$('.sp-nav-toggle').on('click',function(){
    $('.sp-nav-toggle, .sp-nav').toggleClass('show');
});

const buttonOpen = document.querySelectorAll('.modalOpen');

buttonOpen.forEach(function(btn){
    btn.onclick = function(){
        console.log('open');
        var modal = btn.getAttribute('data-modal');
        console.log(modal);
        document.getElementById(modal).style.display = "block";
        console.log('open end');
    }
});


const buttonClose = document.querySelectorAll('.modalClose');


buttonClose.forEach(function(btn1){
    btn1.onclick = function(){
        console.log('close1');
        var modal = btn1.closest('.modal');
        modal.style.display = "none";
        console.log('close1 end');
    }
});

//モーダルコンテンツ以外がクリックされた時
window.onclick = function (event) {
    console.log('close2');
    if (event.target.className === "modal") {
        console.log('close2 none');
      event.target.style.display = "none";
    }
    console.log('close2 end');
};
