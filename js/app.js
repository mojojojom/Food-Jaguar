// import bootstrap from 'bootstrap';


// ACTIVE LINKS
const pageUrl = location.href;
const navLinks = document.querySelectorAll('.nav-link');
const menuLength = navLinks.length;
for(let i=0;i<menuLength;i++) {
    if(navLinks[i].href === pageUrl) {
        navLinks[i].classList.add("active");
    }
}


// NAVBAR ANIMATION
var lastScrollTop;
navbar = document.getElementById('header');
nav = document.getElementById('nav');
window.addEventListener('scroll',function(){
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if(scrollTop > lastScrollTop){
        navbar.style.top='-130px';
    }
    else{
        navbar.style.top='0';
    }
    lastScrollTop = scrollTop;
});

// ANIMATIONS - SCROLL
jQuery(function($){
    $( document ).ready(function() {
        var mywindow = jQuery(window);
        updateStyling(mywindow.scrollTop());
        console.log(mywindow.scrollTop());
    
        var mywindow = jQuery(window);
        var mypos = mywindow.scrollTop();
        let scrolling = false;
        window.addEventListener('scroll', function() {
            mypos = mywindow.scrollTop();
            scrolling = true;
        });
        setInterval(() => {
            if (scrolling) {
                scrolling = false;
                updateStyling(mypos);
            }
        }, 200);
    
        function updateStyling(mypos){
            if (mypos >= 20) {
                $('#header').addClass('header-scroll');
            }
            else {
                $('#header').removeClass('header-scroll');
            }
        }
    });
})