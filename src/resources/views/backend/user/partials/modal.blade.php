<div id="modal-delete" class="modal fade" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete user</h4>
        <a
          type="button"
          class="close"
          onclick="closeModal(event)"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this user?</p>
        <a
          type="button"
          class="btn"
          data-dismiss="modal"
          onclick="closeModal(event)">
          Close
        </a>
        <form 
          id="deleteUserForm" 
          action="" 
          method="POST" 
          style="display: inline;"
        >
          @csrf
          @method('DELETE')
          <input
            type="submit"
            class="btn btn-danger float-right"
            value="Delete"
          />
          
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->