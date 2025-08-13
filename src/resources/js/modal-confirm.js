document.addEventListener('click', (e) => {
  const trigger = e.target.closest('[data-modal-confirm]');
 
  if (!trigger) return;

  const dialogId = trigger.dataset.modalConfirm;
  const dialog = document.getElementById(dialogId);
  const modalInstance = new bootstrap.Modal(dialog);

  

  window.openModal = function (element) {
    const form = document.getElementById(`${dialogId}Form`);
    form.action = element.getAttribute('data-url');

    modalInstance.show();
  };

  window.closeModal = function (event) {
    
    if (event) {
      event.preventDefault();
    }
    modalInstance.hide();
    return false;
  };

  dialog.addEventListener('click', function (event) {
    if (event.target === dialog) {
      closeModal();
    }
  });
});