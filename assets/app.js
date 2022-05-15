/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import './scss/app.scss';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
// loads the Bootstrap jQuery plugins

//import 'bootstrap-sass/assets/javascripts/bootstrap/transition.js';
//import 'bootstrap-sass/assets/javascripts/bootstrap/alert.js';
//import 'bootstrap-sass/assets/javascripts/bootstrap/collapse.js';
//import 'bootstrap-sass/assets/javascripts/bootstrap/dropdown.js';
//import 'bootstrap-sass/assets/javascripts/bootstrap/modal.js';
import 'bootstrap';

const $ = require('jquery');
// create global $ and jQuery variables
global.$ = global.jQuery = $;

$( function() {
    $( 'i' ).tooltip();
} );



$(function() {
    var moveLeft = 20;
    var moveDown = 10;

    $('.imgHover').hover(function(e) {
        $(this).attr('width', '500px');
        $(this).addClass('absolute');
    }, function() {
        $(this).attr('width', '50px');
        $(this).removeClass('absolute');
    });

    $('.descriptionArticle').hover(function(e) {
        $(this).next().show();
        //.css('top', e.pageY + moveDown)
        //.css('left', e.pageX + moveLeft)
        //.appendTo('body');
    }, function() {
        $('.pop-up').hide();
    });

    $('.descriptionArticle').mousemove(function(e) {
        $(this).next().css('top', e.pageY + moveDown-300).css('left', e.pageX + moveLeft);
    });

});

$("#search_parse1").hide();
$(".fa-minus").hide();

$(".fa-minus").click(function(){
    $("#search_parse1").hide();
    $(".fa-minus").hide();
    $(".fa-plus").show();
});

$(".fa-plus").click(function(){
    $("#search_parse1").show();
    $(".fa-plus").hide();
    $(".fa-minus").show();
});
// loads the code syntax highlighting library



