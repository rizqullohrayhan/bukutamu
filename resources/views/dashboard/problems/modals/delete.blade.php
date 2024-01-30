<div id="deleteData{{$category->id}}" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="modalDelete{{$category->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <form method="post" enctype="multipart/form-data" action="/problems/{{$category->id}}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="category_id" value="{{$category->id}}">
                    <lord-icon src="{{asset('/assets/json/trash-bin.json')}}"
                               trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-4">
                        <h4 class="mb-3">Yakin hapus data?</h4>
                        <p class="text-muted mb-4"> Jika kamu menghapus data, maka kamu tidak akan bisa mengembalikannya!</p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Yakin</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

