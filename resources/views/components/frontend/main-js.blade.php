    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" defer></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.js') }}" defer></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js" defer></script>
    <script src="{{ asset('frontend/assets/js/jquery.waypoints.min.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/menu.js') }}" defer></script>
    <!-- GSAP Plugins for title animation -->
    <script src="{{ asset('frontend/assets/js/gsap.min.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/gsap-scroll-trigger.min.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/gsap-split-text.min.js') }}" defer></script>
    <script src="{{ asset('frontend/assets/js/custom.js') }}" defer></script>
    <script>
$(document).ready(function () {

    // Mobile only
    if ($(window).width() <= 991) {

        $(".submenu-toggle").on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            let parent = $(this).closest(".menu-item-has-children");
            let submenu = parent.children(".sub-menu");

            // Toggle
            parent.toggleClass("open");
            submenu.stop(true, true).slideToggle(200);
        });

        // Allow normal page navigation
        $(".main-nav-link").on("click", function (e) {
            e.stopPropagation();
        });
    }
});
</script>