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
        // for (var input of formData) console.log(input);

        // Send formdata to server
        let request = new XMLHttpRequest();
        request.open("POST", `${root_path}/src/controller/c.form.php`, true);
        request.onload = (event) => {
          if (request.status == 200) {
            // console.log(request.responseText);
            try {
              
              let result = JSON.parse(request.responseText);
              if (result.hasOwnProperty('error')) {
                // TODO: error handling
                // console.log('JSON:', result);
                switch (result.error) {
                  case 'email_exists':
                    alert('You can not apply more than once!');
                    break;

                  default:
                    break;
                }
              } else {
                // TODO: success handling
                // console.log(result);
                alert('Thank you for your application!');
                document.getElementById('form').reset();
              }

            } catch (e) {
              console.log(e);
            }
          } else {
            console.error("Error:", request.status);
          }
        };

        // Send the data
        request.send(formData);
    });
})();