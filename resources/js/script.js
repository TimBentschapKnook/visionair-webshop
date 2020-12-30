$(document).ready(function (){

    jQuery(document).ready(function($)
    {
        let url_string = window.location.href;
        let url = new URL(url_string);
        let page = url.searchParams.get("page").split("/");

        if (page)
        {
            page = page[page.length-1];
        }

        page = page.split('.');
        page = page[0];

        if (page === '')
        {
            page = 'index';
        }

        let target = $('header nav ul li[id="'+page+'"]');

        target.addClass('active');
    });


});