

document.addEventListener("DOMContentLoaded", function() {
    // Thêm các năm vào filter
    const yearFilter = document.getElementById("yearFilter");
    const currentYear = new Date().getFullYear();
    for (let year = currentYear; year >= 2000; year--) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearFilter.appendChild(option);
    }

    
});

$(document).ready(function() {
    var currentIndex = 0;
    var slides = $('.slide');
    var totalSlides = slides.length;

    function showSlide(index) {
        slides.removeClass('active').eq(index).addClass('active');
        $('.index-item').removeClass('active').eq(index).addClass('active');
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        showSlide(currentIndex);
    }

    $('.btn-right').click(nextSlide);
    $('.btn-left').click(prevSlide);
    $('.index-item').click(function() {
        var index = $(this).data('slide');
        currentIndex = index;
        showSlide(index);
    });

    showSlide(currentIndex); // Initialize the first slide
});
