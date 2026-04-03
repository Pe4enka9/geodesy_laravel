const wrappers = document.querySelectorAll('.actions__wrapper');
const createForm = document.getElementById('create-form');

document.addEventListener('click', (event) => {
    const actionBtn = event.target.closest('.actions__btn');
    const wrapper = event.target.closest('.actions__wrapper');
    const addBtn = event.target.closest('.tab-actions__add-btn');

    if (addBtn) {
        createForm.style.display = 'block';
    }

    if (actionBtn) {
        document.body.style.pointerEvents = 'none';
        actionBtn.nextElementSibling.classList.add('actions__wrapper--active');
        return;
    }

    if (!wrapper) {
        wrappers.forEach(el => el.classList.remove('actions__wrapper--active'));
        document.body.style.pointerEvents = '';
    }
});
