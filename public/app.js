Flat.prototype.onProgressLoading = function (value, isLoaded) {
};

Flat.prototype.onPageUpdate = function () {

};

Flat.prototype.onToast = function (title, msg, type) {
    switch (type) {
        case 'success':
            alert('success : TITLE' + title + ' // MSG' + msg);
            break;
        case 'warning':
            alert('warning : TITLE' + title + ' // MSG' + msg);
            break;
        case 'error':
            alert('error : TITLE' + title + ' // MSG' + msg);
            break;
        default:

    }
};

Flat.prototype.onPageLoad = function (page) {
    console.log('Page Loaded ');
};

var flat = new Flat('wss://' + window.location.hostname + '/wss/');

flat.debug = true; //Enable // Disable debug mode
