<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><span id="modalMessage"></span> <b id="modalItemName"></b>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="modalForm" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger" id="modalSubmitButton">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
