<script src="{{ asset('templates/pike-admin/assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('templates/pike-admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('templates/pike-admin/assets/js/moment.min.js') }}"></script>

<script src="{{ asset('templates/pike-admin/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('templates/pike-admin/assets/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('templates/pike-admin/assets/js/detect.js') }}"></script>
<script src="{{ asset('templates/pike-admin/assets/js/fastclick.js') }}"></script>
<script src="{{ asset('templates/pike-admin/assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('templates/pike-admin/assets/js/jquery.nicescroll.js') }}"></script>

<script>
    $(window).on("load", function(){
        var w = $(window).width(); 
        if(w >= 768 && w < 992){
            $("#logo-full").removeClass("d-md-block");
            $("#logo-mini").removeClass("d-md-none");
        }
    });
    $(window).resize(function(){
        var w = $(window).width(); 
        if(w >= 768 && !$("body").hasClass("adminbody")){
            $("#logo-full").removeClass("d-md-block");
            $("#logo-mini").removeClass("d-md-none");
        }
    });
</script>

<!-- App js -->
<script src="{{ asset('templates/pike-admin/assets/js/pikeadmin.js') }}"></script>