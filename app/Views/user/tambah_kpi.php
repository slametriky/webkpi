<?= $this->extend('_partials/template') ?>

<?= $this->section('content') ?>
    <div class="col-sm-12" id="myapp">
        <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah KPI</h6>            
        </div>
        <!-- Card Body -->
        <div class="card-body">                        
            <form method="post" action="<?= base_url('simpan_kpi') ?>">
                <div class="form-group">
                    <label>Judul KPI</label>
                    <input type="text" name="judulKpi" class="form-control" id="judulKpi" placeholder="Judul KPI">                
                </div>
                <div class="form-group">
                    <label>Tanggal Berakhir</label>
                    <input type="text" name="tanggalBerakhir" class="form-control" placeholder="Tanggal Berakhir">
                </div>           
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="modalKPI" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal"> Tambah KPI</h5>
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
 