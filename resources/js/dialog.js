import Swal from 'sweetalert2';

let dialog = Swal.mixin({
        showCancelButton: true,
        // cancelButtonColor: "#1f2937",
        // confirmButtonColor: "#339476",
        customClass: {
            actions: 'custom-action',
            cancelButton: 'order-1',
            confirmButton: 'order-2',
        }
    });

export default { dialog: dialog };