<dialog id="dialog" class="modal fade" closedby="any"> 

  <div class="modal-dialog" role="document"> 

    <div class="modal-content"> 

      <header class="modal-header"> 

        <h4 class="modal-title"></h4> 

        <a
          class="close" 
          aria-label="Close"
          onClick="closeModal(event)"
          > 

          <span aria-hidden="true">&times;</span> 

        </a> 

      </header> 

      <div class="modal-body"> 

        <p></p> 

        <a 
          class="btn" 
          onClick="closeModal(event)"
        > 
          Close 
        </a> 

        <form  
          id="dialogForm"  
          action=""  
          method="POST"  
          style="display: inline;" 
        > 

          @csrf 
          @method($method)
          <input 
            type="submit" 
            class="btn btn-danger float-right" 
            value="{{$submit ?? 'Submit'}}"
          /> 

        </form> 

      </div> 

    </div> 

    <!-- /.modal-content --> 

  </div> 

  <!-- /.modal-dialog --> 

</dialog> 
<!-- /.modal -->