<div class="modal fade" id="createData" tabindex="-1" aria-labelledby="modalCreate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreate">Tambah Data Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="/guests">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div>
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama lengkap...">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="identity_number" class="form-label">Nomor Identitas (NIP/NIM/NIK/NISN)</label>
                                <input type="text" class="form-control" name="identity_number" id="identity_number" placeholder="Masukkan nomor identitas...">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <label class="form-label">Jenis Kelamin</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="1">
                                    <label class="form-check-label" for="genderMale">Pria</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="2">
                                    <label class="form-check-label" for="genderFemale">Wanita</label>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email anda...">
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div>
                                <label for="phone" class="form-label">No Telepon/Whatsapp</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Masukkan nomor yang bisa dihubungi...">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>
