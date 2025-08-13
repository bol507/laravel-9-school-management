@props([
    'id' => 'modal-confirm',
    'method' => 'POST',
    'submitText' => 'Submit',
    'title' => '',
    'message' => ''
])

<dialog id="{{ $id }}" class="modal fade" closedby="any">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <header class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                
            </header>
            <div class="modal-body">
                <p>{{$message}}</p>
                <a
                    class="btn"
                    onClick="closeModal(event)"
                    data-dismiss="modal"
                >
                    Close
                </a>
                <form
                    id="{{ $id }}Form"
                    action=""
                    method="POST"
                    style="display: inline;">
                    @csrf
                    @method($method)
                    <input
                        type="submit"
                        class="btn btn-danger float-right"
                        value="{{$submitText}}" />
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</dialog>
<!-- /.modal -->