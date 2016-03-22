$(document).ready(function() {

    // this monster function changes the URL based on the tab open, providing tab persistence across refreshes
    // would like to refactor this to make it more general and less enormous
    $('.nav-tabs li a').on("click", function (event) {
        var tab_link = $(event.target);
        var tab_target = tab_link.attr('href');
        var url = window.location.href;

        var re_software = /software\/[A-Za-z0-9]+\/(edit)$/;
        var re_versions = /software\/[A-Za-z0-9]+\/edit\/versions/;
        var re_people = /software\/[A-Za-z0-9]+\/edit\/people/;
        var re_legal = /software\/[A-Za-z0-9]+\/edit\/legal/;
        var re_files = /software\/[A-Za-z0-9]+\/edit\/files/;
        var re_images = /software\/[A-Za-z0-9]+\/edit\/images/;


        if (tab_target.indexOf("software") > -1) {
            // then we are going to the software tab
            if (url.search(re_software) > -1) {
                // we're already there, so don't do anything
            }
            else {
                // cut down url to remove everything after /edit
                var new_url = url.slice(0, url.length - (url.length - url.indexOf("/edit") - 5));
                history.pushState({"state": "software"}, "", new_url);
            }
        }
        else if (tab_target.indexOf("versions") > -1) {
            // then we are going to the files tab
            if (url.search(re_versions) > -1) {
                // we're already there, so don't do anything
            }
            else {
                // cut down url to remove everything after /edit
                var new_url = url.slice(0, url.length - (url.length - url.indexOf("/edit") - 5));
                new_url = new_url + "/versions";
                history.pushState({"state": "versions"}, "", new_url);
            }
        }
        else if (tab_target.indexOf("legal") > -1) {
            // then we are going to the files tab
            if (url.search(re_legal) > -1) {
                // we're already there, so don't do anything
            }
            else {
                // cut down url to remove everything after /edit
                var new_url = url.slice(0, url.length - (url.length - url.indexOf("/edit") - 5));
                new_url = new_url + "/legal";
                history.pushState({"state": "legal"}, "", new_url);
            }
        }
        else if (tab_target.indexOf("people") > -1) {
            // then we are going to the files tab
            if (url.search(re_people) > -1) {
                // we're already there, so don't do anything
            }
            else {
                // cut down url to remove everything after /edit
                var new_url = url.slice(0, url.length - (url.length - url.indexOf("/edit") - 5));
                new_url = new_url + "/people";
                history.pushState({"state": "people"}, "", new_url);
            }
        }
        else if (tab_target.indexOf("files") > -1) {
            // then we are going to the files tab
            if (url.search(re_files) > -1) {
                // we're already there, so don't do anything
            }
            else {
                // cut down url to remove everything after /edit
                var new_url = url.slice(0, url.length - (url.length - url.indexOf("/edit") - 5));
                new_url = new_url + "/files";
                history.pushState({"state": "files"}, "", new_url);
            }
        }
        else if (tab_target.indexOf("images") > -1) {
            // then we are going to the files tab
            if (url.search(re_images) > -1) {
                // we're already there, so don't do anything
            }
            else {
                // cut down url to remove everything after /edit
                var new_url = url.slice(0, url.length - (url.length - url.indexOf("/edit") - 5));
                new_url = new_url + "/images";
                history.pushState({"state": "images"}, "", new_url);
            }
        }
    });

});