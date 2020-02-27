function loadClasses(src) {
    let script = document.createElement('script');
    script.src = src;
    document.body.appendChild(script);
}

//Class Loader
loadClasses('src/js/classes/UI.class.js');
loadClasses('src/js/classes/ServerRequest.class.js');
loadClasses('src/js/classes/Messagebox.class.js');
loadClasses('src/js/classes/InputFilter.class.js');