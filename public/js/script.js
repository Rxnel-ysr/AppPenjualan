document.querySelectorAll('.toast').forEach(toastEl => {
    const toast = new bootstrap.Toast(toastEl, {
        delay: 4000,
        autohide: false
    });

    toastEl.addEventListener('hide.bs.toast', (e) => {
        e.preventDefault();
        toastEl.classList.add('animate__animated', 'animate__fadeOutDown');

        toastEl.addEventListener('animationend', () => {
            toastEl.classList.remove('animate__animated', 'animate__fadeOutDown');
            toast.hide();
        }, {
            once: true
        });
    });

    toast.show();

    setTimeout(() => {
        toast.hide();
    }, 4000);
});