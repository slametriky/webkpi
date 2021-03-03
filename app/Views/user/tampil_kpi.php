<?= $this->extend('_partials/template') ?>

<?= $this->section('content') ?>
<div class="col-sm-12" id="myapp">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen KPI</h6>            
        </div>
        <!-- Card Body -->
        <div class="card-body">            
            <a data-toggle="modal" @click="modalTambah()" data-target="#modalKPI" href="#" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah KPI</a>            
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul KPI</th>
                            <th>Tanggal Berakhir</th>
                            <th>Jumlah SOP</th>
                            <th>Selesai</th>
                            <th>Belum Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr v-if="form.length > 0" v-for="(data, index) in form" :key="index">
                            <td>{{ ++index }}</td>
                            <td>{{ data.judulKpi }}</td>
                            <td>{{ data.batasTanggal }}</td>
                            <td>{{ data.jumlahSop }}</td>
                            <td>{{ data.selesai }}</td>                            
                            <td>{{ data.belum }}</td>       
                            <td>                                                
                                <button @click="sop(data.id)" class="btn btn-primary">SOP</button>                      
                                <button @click="selectedKpi(data)" data-toggle="modal" data-target="#modalEditKPI" class="btn btn-primary">Edit</button>        
                                <button :disabled="data.jumlahSop > 0 ? true : false" @click="hapusKpi(data.id, index)" class="btn btn-danger">Hapus</button>                                      
                            </td>                     
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" id="modalKPI"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judulModal"> {{ judulModal }}</h5>
                            <button class="close" type="button"  data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="simpanKpi">
                                <div class="form-group">                                    
                                    <label>Judul KPI</label>
                                    <input type="text" class="form-control" v-model="form.judul_kpi" id="judul_kpi" placeholder="Judul KPI" required>                        
                                </div>             

                                <div class="form-group">
                                <label>Tanggal Berakhir</label>
                                    <input type="text" data-date-format="yyyy-mm-dd"  class="form-control datepicker" v-model="form.tanggal_berakhir" autocomplete="off" id="tanggal_berakhir" placeholder="Tanggal Berakhir" required>                        
                                </div>
                                    
                                <button type="submit" class="btn btn-primary" v-show="!updateSubmit">Simpan</button> <!-- jika tidak update maka tombol update tidak muncul -->                                 
                            </form>
                        </div>
                        <div class="modal-footer">                        
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        </div>                    
                    </div>
                </div>
            </div>

            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditKPI" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judulModal"> Edit KPI</h5>
                            <button class="close" type="button" data-dismiss="modal" @click="tutupModal()"  aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="updateKpi">
                                <div class="form-group">                                    
                                    <label>Judul KPI</label>
                                    <input type="hidden" class="form-control" v-model="tmpKpi.id" required>  
                                    <input type="text" class="form-control" v-model="tmpKpi.judulKpi" placeholder="Judul KPI" required>                        
                                </div>             

                                <div class="form-group">
                                <label>Tanggal Berakhir</label>
                                    <input type="text" class="form-control" data-date-format="yyyy-mm-dd" v-model="tmpKpi.batasTanggal" id="tanggal_berakhir_edit" placeholder="Tanggal Berakhir" required>                        
                                </div>
                                    
                                <button type="submit" class="btn btn-primary">Update</button> <!-- jika tidak update maka tombol update tidak muncul -->                                 
                            </form>
                        </div>
                        <div class="modal-footer">                        
                            <button class="btn btn-secondary" type="button" @click="tutupModal()"  data-dismiss="modal">Batal</button>
                        </div>                    
                    </div>
                </div>
            </div>

        </div>
   </div>
</div>        

<?= $this->endSection() ?>

<?= $this->section('script') ?>
    <script src="<?= base_url('themes'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('themes'); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('themes'); ?>/js/demo/datatables-demo.js"></script>

    <!-- <script>        

        $(document).ready(function(){
            $('#tanggal_berakhir').datepicker({
                // format: 'yyyy-mm-dd',            
                autoclose: true    
            });
        })        
    </script> -->

    <script>
        let app = new Vue({
            el: '#myapp',
            data: {
                kpi: [],
                form: {         
                    
                },            
                updateSubmit: false,
                judulModal : '',
                judulKpiEdit: '',
                tanggalBerakhirEdit: '',
                showModalEdit:false,
                tmpKpi: {},                

            },
            methods: {     
                getKpi: function () {
                    axios.get('getKpiByUser')
                        .then(res => {                            
                             // handle success
                            if(res.data != null){
                                this.form = res.data;
                            } else {
                                this.form = [];
                            }
                            
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },        
                simpanKpi: function(){                    
                    
                    axios.post('simpankpi', {
                        judul_kpi: this.form.judul_kpi,
                        tanggal_berakhir: this.form.tanggal_berakhir
                    })
                    .then(res => {
                        // handle success                        
                        if(res.data.code == 200){
                            
                            $('#modalKPI').modal('hide'); 
                            alert('berhasil');
                            this.getKpi();
                        } else {
                            console.log('gagal');
                        }                        
                    })
                    .catch(err => {                        
                        console.log(err);
                    })
                }, 
                updateKpi: function(){                    
                    axios.post('updatekpi', {
                        id: this.tmpKpi.id,
                        judulKpi: this.tmpKpi.judulKpi,
                        batasTanggal:this.tmpKpi.batasTanggal

                    })
                    .then(res => {
                        // handle success                                                
                        if(res.data.code == 200){
                            this.getKpi();
                            $('#modalEditKPI').modal('hide'); 
                            alert('berhasil');
                        } else {
                            console.log('gagal');
                        }                        
                    })
                    .catch(err => {                        
                        console.log(err);
                    })
                },                
                modalTambah: function(){
                    this.judulModal = 'Tambah KPI';        
                    this.showModalTambah = true;    
                },
                selectedKpi: function(data){
                    this.tmpKpi = data;                                                       
                },
                hapusKpi: function(id, index){                                             

                    if(confirm("Yakin hapus data?")){                                                                                                                 
                        axios.post('hapuskpi', {
                            id
                        })
                        .then(res => {                            
                            // handle success
                            if(res.data.code == 200){                                                                    
                                                                
                                this.getKpi();                                                              

                            } else {
                                console.log('gagal');
                            }                           
                        })
                        .catch(err => {                        
                            console.log(err);
                        })
                    }
                },
                sop: function(id) {                    
                    // console.log(id);                    
                    window.location.href = "<?= base_url('sop') ?>/"+id;
                },
                tutupModal: function(){
                    this.getKpi();
                }

            },    
            created: function(){
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                this.getKpi();
            },
            mounted() {
                
                $("#tanggal_berakhir").datepicker({autoclose:true}).on(
                    "changeDate", () => {this.form.tanggal_berakhir = $('#tanggal_berakhir').val()}
                );

                $("#tanggal_berakhir_edit").datepicker({autoclose:true}).on(
                    "changeDate", () => {this.tmpKpi.batasTanggal = $('#tanggal_berakhir_edit').val()}
                );
                
            },  
        })
    </script>
  
    
<?= $this->endSection() ?>
 