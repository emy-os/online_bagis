
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            const amountInput = form.querySelector('input[name="miktar"]');
            if (amountInput && amountInput.value <= 0) {
                e.preventDefault();
                alert('Lütfen geçerli bir bağış tutarı girin.');
            }
        });
    }
});