const root_path = '/RRM-PHP-FORM';

// Init
(()=> {
    const form = document.getElementById('form');
    // Listen for form submit event
    form.addEventListener('submit', (e) => {
        e.preventDefault();        
        new FormData(form);
    });

    // Listen for formdata event
    form.addEventListener('formdata', (e) => {
        let formData = e.formData;
        
        // DEBUG: formdata
        // for (var value of formData.values()) console.log(value);

        // Send formdata to server
        let request = new XMLHttpRequest();
        request.open("POST", `${root_path}/src/controller/c.form.php`, true);
        request.onload = (event) => {
          if (request.status == 200) {
            console.log('Returned:', request.responseText);
          } else {
            console.log("Error:", request.status);
          }
        };

        // Send the data
        request.send(formData);
    });
})();