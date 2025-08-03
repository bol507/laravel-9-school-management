@if(Session::has('message'))
<script>
  let type = "{{ Session::get('alert-type') }}"
  switch (type){
    case 'info':
      Toastify({
            text: "{{ Session::get('message') }}",
            className: "info",
            duration: 3000,
            close: true,
            onClick: function () {
              Toastify.hide();
            }
          }).showToast();
      break;
    case 'success':
        Toastify({
          text: "{{ Session::get('message') }}",
          className: "success",
          duration: 3000,
          close: true,
          onClick: function () {
            Toastify.hide();
          }
        }).showToast();
        break;
    case 'warning':
        Toastify({
          text: "{{ Session::get('message') }}",
          className: "warning",
          duration: 3000,
          close: true,
          onClick: function () {
            Toastify.hide();
          }
        }).showToast();
        break;
    case 'error':
        Toastify({
          text: "{{ Session::get('message') }}",
          className: "error",
          duration: 3000,
          close: true,
          onClick: function () {
            Toastify.hide();
          }
        }).showToast();
        break;
    default:
        Toastify({
          text: "{{ Session::get('message') }}",
          className: "info",
          duration: 3000,
          close: true,
          onClick: function () {
            Toastify.hide();
          }
        }).showToast();
        break;
  }//end switch
  
</script>
@endif