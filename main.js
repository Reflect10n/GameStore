let menuOpacity = 0;

function showMenu(){
    let menu_item = document.getElementsByClassName('main-header__dropdown main-header__nav active');
    let menu_button = document.getElementsByClassName('main-header__btn main-header__menu');
    let dropdown_block = document.getElementsByClassName('block-dropdown');
    const body = document.body;
    if (menuOpacity==0)
    {
        menuOpacity++;
        menu_item[0].style.opacity = menuOpacity;
        dropdown_block[0].style.display = "block";
        body.classList.add('no-scroll');
        menu_button[0].style.background = "#f03d3d";
        menu_item[0].style.visibility = "visible";
        let coords = menu_button[0].getBoundingClientRect();
        menu_item[0].style.left = coords.left + "px";
        menu_button[0].style.backgroundColor = "rgb(240, 61, 61)";
    }
    else
    {
        menu_item[0].style.opacity = 0;
        menuOpacity--;
        menu_item[0].style.visibility = "hidden";
        dropdown_block[0].style.display = "none";
        body.classList.remove('no-scroll');
        menu_button[0].style.backgroundColor = "";
    }
}

let slideIndex = 1;
let wrapperSlide = document.getElementsByClassName("wrapper_slide");
showSlide(slideIndex);

let next = document.getElementsByClassName('main-slider__btn-next')[0];
let prev = document.getElementsByClassName('main-slider__btn-prev')[0];
let nextsmall = document.getElementsByClassName('small-right')[0];
let prevsmall = document.getElementsByClassName('small-left')[0];
let controls = document.getElementsByClassName('label-control');

for (let i=0; i<controls.length; i++)
{
controls[i].addEventListener("click", function() {
    slideIndex = i + 1;
    showSlide(slideIndex); makeTimer(); });
}

next.addEventListener("click", function() {
    showSlide(slideIndex += 1);
    makeTimer();
});

prev.addEventListener("click", function() {
    showSlide(slideIndex -= 1);
    makeTimer();
});

nextsmall.addEventListener("click", function() {
    showSlide(slideIndex += 1);
    makeTimer();
});

prevsmall.addEventListener("click", function() {
    showSlide(slideIndex -= 1);
    makeTimer();
});


function showSlide(n){
    if (n > wrapperSlide.length) 
    {
        slideIndex = 1;
    }
    if (n < 1) 
    {
        slideIndex = wrapperSlide.length;
    }
    for (let slide of wrapperSlide) {
        slide.checked = false;
    }
    wrapperSlide[slideIndex-1].checked = true;
}

var timer = 0;
makeTimer();    
function makeTimer(){
    clearInterval(timer);
    timer = setInterval(function() {
        slideIndex++;
        showSlide(slideIndex);
    }, 5000);
}
