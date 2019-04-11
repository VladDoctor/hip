let sections = $('section');
//Buttons on Navbar
let listBtn = $('#list-btn');
let addPubBtn = $('#addPub-btn');
let addMenuBtn = $('#addMenu-btn');
let settingsBtn = $('#settings-btn');
//Sections
let list = $('#list');
let addPub = $('#addPub');
let addMenu = $('#addMenu');
let settings = $('#settings');

listBtn.on('click', function(){
    sections.removeClass('current');
    list.addClass('current');
});

addPubBtn.on('click', function(){
    sections.removeClass('current');
    addPub.addClass('current');
});

addMenuBtn.on('click', function(){
    sections.removeClass('current');
    addMenu.addClass('current');
});

settingsBtn.on('click', function(){
    sections.removeClass('current');
    settings.addClass('current');
});