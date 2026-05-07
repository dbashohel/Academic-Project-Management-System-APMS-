$(document).ready(function () {
    
    // // on scroll actions
    // var scroll_offset = 120;
    // $(window).scroll(function () {
    //   var $this = $(window);
    //   if ($(".header-section").length) {
    //     if ($this.scrollTop() > scroll_offset) {
    //       $(".header-section").addClass("header-active");
    //     } else {
    //       $(".header-section").removeClass("header-active");
    //     }
    //   }
    // });

    $('select').select2();
    // $('#myid_grade').select2();



    // Project / Thesis Proposal Form 
    $(".select_placeholder").select2({
        placeholder: "Select Student ID",
        allowClear: true
    });

    // // tab
    // Tab functionality
    $(".tab_button").click(function () {
        var selectedTab = $(this).data('tab');

        $(".tab_content").hide();
        $(".tab_button").removeClass('active');

        // Show the selected tab content
        $("." + selectedTab).show();
        // clicked button
        $(this).addClass('active');
    });
    // by default
    $(".tab_content").hide();
    $(".tab_content.active").show();


   

    // three dot    
    $(".action_setting").on("click", function () {
        var $dot = $(this).next(".action_drop");
        $(".action_drop").not($dot).slideUp();
        $(this).next(".action_drop").slideToggle();
    });
    $(document).on("click", function (event) {
        if (!$(event.target).closest('.action_drop').length && !$(event.target).is('.action_setting, .action_setting i')) {
            $('.action_drop').slideUp();
        }
    });




    //
    //
    //
    //
    //
    //                  SIDEBAR AND MAIN BODY TOGGLING SCRIPT START
    //
    //
    //
    //
    //
    // Menu Toggle Script start
    $('#aside-toggler').click(function (e) {
        e.preventDefault();
        $('aside').toggleClass('hider');
        $('.top-navigation').toggleClass('toggled');
        $('.content-area').toggleClass('toggler');
    });

    $(window).on('resize load', function () {
        var width = $(window).width();

        if (width <= 768) {
            $('aside').addClass('hider');
            $('.top-navigation').addClass('toggled');
            $('.content-area').addClass('toggler');
        } else {
            $('aside').removeClass('hider');
            $('.top-navigation').removeClass('toggled');
            $('.content-area').removeClass('toggler');
        }
    });
    // Menu Toggle Script end
    //
    //
    //
    //
    //
    //                   tag Editor script
    //
    //
    //
    //
    //
    //tag Editor script start
    $(".tm-input").tagsManager({
        tagClass: 'tm-tag-info'
    });
    //tag Editor script close

    $('[data-toggle="tooltip"]').tooltip();
});

