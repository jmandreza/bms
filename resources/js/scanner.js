import { Html5QrcodeScanner, Html5QrcodeSupportedFormats} from "html5-qrcode";

const scan = (({
    form: form,
    scannerContainer: scannerContainer,
    container: container,
    loader: loader
}) => {
    let scanner = new Html5QrcodeScanner(
        scannerContainer.attr('id'), {
            fps: 10,
            qrbox: 300,
            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
        }
    );

    scanner.render((decoded, result) => {
        scanner.pause();
        loader.show('fast', 'linear');
        form.find('input[name=cert_id]').val(decoded);

        $.post(form.attr('action'), form.serializeArray(), function(data, status) {
            if(data.success) {
                container.html(data.view);
                Toast.fire({
                    icon: 'success', 
                    text: data.message,
                });
            }
            else {
                Toast.fire({
                    icon: 'warning', 
                    text: data.message,
                });
            }
            loader.hide('fast', 'linear');
            scanner.resume();
        }).fail(function(xhr, status, error) {         
            Toast.fire({
                icon: 'error', 
                text: `Error excuting request. Reason: ${error}. Please try again.`
            });
            loader.hide('fast', 'linear');
            scanner.resume();
        });
    });
});

export default {
    scan: scan,
}