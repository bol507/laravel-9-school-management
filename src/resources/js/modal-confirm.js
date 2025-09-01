document.addEventListener('DOMContentLoaded', function () {
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-modal-confirm]');

    if (!trigger) return;

    const dialogId = trigger.dataset.modalConfirm;
    const dialog = document.getElementById(dialogId);
    const form = document.getElementById(`${dialogId}Form`);

    if (!dialog || !form) return;

    form.action = trigger.dataset.url;
    dialog.showModal();
  });


  dialog.addEventListener('click', function (event) {
    if (event.target === dialog) {
      closeModal();
    }
  });
});

window.closeModal = function (event) {
  if (event) event.preventDefault();
  const dialog = event.target.closest('dialog');
  if (dialog) dialog.close();
};
