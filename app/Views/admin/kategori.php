<?= $this->extend('_partials/template') ?>

<?= $this->section('content') ?>
    <div class="col-sm-12" id="myapp">
        <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Kategori</h6>            
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modalKategori"><i class="fa fa-plus"></i> Tambah Kategori</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for='(kategori,index) in categories'>
                            <td>{{ ++index }}</td>
                            <td>{{ kategori.kategori }}</td>
                            <td>
                                <a href="" class="btn btn-xs btn-primary ">Edit</a>
                                <a href="" class="btn btn-xs btn-danger">Hapus</a>
                            </td>                         
                        </tr>                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="modalKategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal"> Kategori</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="add">
                        <div class="form-group">
                        <input type="hidden" name="form.id">
                        <label>Kategori</label>
                            <input type="text" class="form-control" v-model="form.kategori" id="kategori" placeholder="Masukkan Kategori" required>                        
                        </div>             

                        <button type="submit" class="btn btn-primary" v-show="!updateSubmit">Simpan</button> <!-- jika tidak update maka tombol update tidak muncul --> 
                        <button type="button" v-show="updateSubmit" @click="update(form)">Update</button> <!-- jika tombol edit di klik maka tombol add akan berubah menjadi update -->                              
                    </form>
                </div>
                    <div class="modal-footer">                        
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
    <script src="<?= base_url('themes'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('themes'); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('themes'); ?>/js/demo/datatables-demo.js"></script>

    <script>
        var app = new Vue({
            el: '#myapp',
            data: {
                categories: [],
                form: {
                  id: '',
                  kategori: ''
                },            
                updateSubmit: false
            },
            methods: {
                allRecords: function(){
                    axios.get('<?= base_url('api/kategori') ?>').then(res => {
                        this.categories = res.data //respon dari rest api dimasukan ke users                        
                    }).catch ((err) => {
                        console.log(err);
                    })
                },         
                add: function(){
                    axios.post('<?= base_url('api/kategori/create') ?>', {
                        kategori: this.form.kategori
                    },
                    headers: {
                        // 'application/json' is the modern content-type for JSON, but some
                        // older servers may use 'text/json'.
                        // See: http://bit.ly/text-json
                        'content-type': 'text/json'
                    }).then(res => {
                        
                        console.log(res.data);

                    }).catch ((err) => {
                        console.log(err);
                    })
                }       
            },
            created: function(){
                this.allRecords();
            }
        })
    </script>
    
<?= $this->endSection() ?>
 