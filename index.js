 // JavaScript for header hide/show on scroll
 let lastScrollTop = 0;
 const header = document.getElementById("header");

 window.addEventListener("scroll", function() {
     let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
     if (scrollTop > lastScrollTop) {
         // Scrolling down
         header.style.top = "-80px"; // Change this value to match header height
     } else {
         // Scrolling up
         header.style.top = "0";
     }
     lastScrollTop = scrollTop;
 });

 // Function to scroll to the top
 function scrollToTop() {
     window.scrollTo({ top: 0, behavior: 'smooth' });
 }