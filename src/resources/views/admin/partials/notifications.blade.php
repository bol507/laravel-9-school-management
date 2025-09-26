@if(Session::has('message'))
<script>
  let type = "{{ Session::get('alert-type') }}"
  switch (type){
    case 'info':
      Toastify({
            text: "{{ Session::get('message') }}",
            style: {
              background:"hsl(267, 93%, 62%)",
            },
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
          style: {
            background:"hsl(164, 100%, 33%)",
          },
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
          style: {
            background:"hsl(43, 100%, 45%)",
          },
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
          style: {
            background:" hsl(0, 85%, 52%)",
          },
          duration: 3000,
          close: true,
          onClick: function () {
            Toastify.hide();
          }
        }).showToast();
        break;
  }//end switch
  
</script>
@else

    @if ($errors->any())
    <script>
    Toastify({
        text: "There were errors in the form. Please review it.",
        duration: 4000,
        close: true,
        style: {
        background:" hsl(0, 85%, 52%)",
        },
        onClick: function () {
        Toastify.hide();
        }
    }).showToast();
    </script>
    @endif

@endif