
    function showToast(message = 'Something went wrong') {
        const toast = document.getElementById('globalToast');
        const msg = document.getElementById('globalToastMessage');
        if (!toast || !msg) return;

        msg.innerText = message;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    

