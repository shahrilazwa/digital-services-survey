(function () {
    "use strict";

    $(".editor").each(function () {
        const element = this;
        ClassicEditor.create(element, {
      
        }).catch((error) => {
            console.error(error);
        });
    });
})();
