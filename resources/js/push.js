import Push from 'push.js';

// check for permission
const check = function() {
    if(!Push.Permission.has()) {
        Push.Permission.request();
    }
}

var create = (({
    title: title, 
    message: message, 
    icon: icon = '/images/notification.png', 
    link: link = '#'
}) => {
    return Push.create(title, {
        body: message,
        icon: icon,
        onClick: function () {
            window.focus();
            window.location.href = link;
            this.close();
        },
        onClose: function () {
            this.clear();
        }
    });
});

export default {
    check: check, 
    create: create
};