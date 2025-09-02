@props([
'id' => 'modal-confirm',
'method' => 'POST',
'submitText' => 'Submit',
'title' => '',
'message' => ''
])

<dialog id="{{ $id }}" class=" p-0 fade" closedby="any">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <header class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>

            </header>
            <div class="modal-body">
                <p>{{$message}}</p>
            </div>
            <div class="modal-footer">

                <form
                    id="{{ $id }}Form"
                    action=""
                    method="POST"
                    class="w-100"
                    
                >
                    @csrf
                    @method($method)
                    <div class= "flex items-center justify-between w-100">
                         <a
                        class="btn btn-info"
                        onClick="closeModal(event)">
                        Close
                    </a>

                    <input
                        type="submit"
                        class="btn btn-danger"
                        value="{{$submitText}}" />
                    </div>
                   
                </form>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</dialog>
<!-- /.modal -->