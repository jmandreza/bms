// Toggle Button
const toggleButton = (({
    selected: selected, 
    button: button, 
    enabled: enabled, 
    text: text 
}) => {
    if(enabled) {
        button.prop('disabled', enabled);
        if(typeof(selected !== "undefined")) {
            if(selected.children().length > 1) {
                selected.children().first().show('fast', 'linear');
            }
            selected.children().last().html(text);
        }

        return false;
    }

    $.each(button, function()  {
        button.prop('disabled', enabled);
        if(typeof(selected !== "undefined")) {
            if(selected.children().length > 1) {
                selected.children().first().hide('fast', 'linear');
            }
            selected.children().last().html(text);
        }

        return false;
    });
});

// Submit form
const submit = (({
    form: form,
    modal: modal,
    edit: edit,
    container: container,
    selected: selected,
    button: button,
    text: text,
}) => {
    let data = form.serializeArray();
    let link = form.attr("action");
    let errField = form.find(".error");

    // Toggle Button
    toggleButton({
        selected: selected,
        button: button,
        enabled: true,
        text: text[0],
    });

    // Submit Form
    $.post(link, data, function(data, status) {
        // Hide error messages
        errField.html("");
        errField.hide('fast', 'linear');

        if(data.success) {
            if(!edit) {
                form.get(0).reset();
            }

            if(typeof(container) !== 'undefined') {
                container.html(data.view);
            }

            if(typeof(modal) !== 'undefined') {
                modal.find('button.close').click();
            }
            

            Toast.fire({
                icon: 'success', 
                text: data.message
            });
        }
        else {
            if(typeof(data.errors) !== 'undefined') {
                // append error messages into the container
                for (let err in data.errors) {
                    let errDiv = errField.filter(`.error[data-error=${err}]`);
                    if(errDiv) {
                        errDiv.html(data.errors[err][0]);
                        errDiv.show('fast', 'linear');
                    }
                }
            }

            Toast.fire({
                icon: 'warning', 
                text: data.message
            });
        }

        toggleButton({
            selected: selected,
            button: button,
            enabled: false,
            text: text[1],
        });
    }).fail(function(xhr, status, error) {
        // Hide error messages
        errField.html("");
        errField.hide('fast', 'linear');
        
        Toast.fire({
            icon: 'error', 
            text: `Error excuting request. Reason: ${error}. Please try again.`
        });

        toggleButton({
            selected: selected,
            button: button,
            enabled: false,
            text: text[1],
        });
    });
});

const load = (({
    form: form,
    link: link,
    loader: loader,
    container: container,
}) => {
    container.empty();

    if(typeof(loader) !== 'undefined') {
        loader.show('fast', 'linear');
    }

    if(typeof(form) !== 'undefined') {
        link = form.attr('action');
        let data = form.serializeArray();

        $.post(link, data, function(data, status) {
            if(typeof(loader) !== 'undefined') {
                loader.hide('fast', 'linear');
            }
            
            container.html(data.view);
        });
    }

    else {
        $.get(link, function(data, status) {
            if(typeof(loader) !== 'undefined') {
                loader.hide('fast', 'linear');
            }

            container.html(data.view);        
        });
    }
    
});

const getNotification = (({
    form: form,
    link: link,
    container: container,
    counter: counter,
}) => {
    if(typeof(form) !== 'undefined') {
        link = form.attr('action');
        let data = form.serializeArray();

        $.post(link, data, function(data, status) {
            container.html(data.view);

            counter.html(data.count > 9 ? '9+' : data.count);
            (data.count > 0) ? counter.show('fast', 'linear') : counter.hide('fast', 'linear');
        });
    }
    else {
        $.get(link, function(data, status) {
            container.html(data.view);

            counter.html(data.count > 9 ? '9+' : data.count);
            (data.count > 0) ? counter.show('fast', 'linear') : counter.hide('fast', 'linear');
        });
    }
});

export default {
    toggleButton: toggleButton,
    submit: submit,
    load: load,
    getNotification: getNotification,
};