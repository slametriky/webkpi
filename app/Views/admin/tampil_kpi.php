<?= $this->extend('_partials/template') ?>

<?= $this->section('content') ?>
<div class="col-sm-12" id="myapp">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">List KPI</h6>            
        </div>
        <!-- Card Body -->
        <div class="card-body">            
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah KPI</th>
                            <th>Jumlah SOP</th>                            
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr v-if="form.length > 0" v-for="(data, index) in form" :key="index">
                            <td>{{ ++index }}</td>
                            <td>{{ data.nama }}</td>
                            <td>{{ data.jmlKpi }}</td>
                            <td>{{ data.jmlSop }}</td>                               
                            <td>                                                
                                <button :disabled="data.jmlKpi == '0' ? true : false" @click="detailKpi(data.user_id)" class="btn btn-primary">Lihat KPI</button>                                                                               
                            </td>                     
                        </tr>
                    </tbody>
                </table>
            </div>                     
        </div>
    </div>

    <div class="modal fade" id="modalKPI"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal"> Daftar KPI</h5>
                    <button class="close" type="button"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Judul KPI</th>
                            <th>Tanggal Berakhir</th>
                            <th>Jumlah SOP</th>
                            <th>Selesai</th>
                            <th>Belum</th>
                            <th>Aksi</th>
                        </tr>
                        <tr v-if="dataKpi.length > 0" v-for="(data, index) in dataKpi" :key="index">
                            <td>{{ ++index }}</td>
                            <td>{{ data.judulKpi }}</td>
                            <td>{{ data.batasTanggal }}</td>
                            <td>{{ data.jumlahSop }}</td>                               
                            <td>{{ data.selesai }}</td>         
                            <td>{{ data.belum }}</td>         
                            <td>                                                
                                <button :disabled="data.jumlahSop == '0' ? true : false" @click="detailSop(data.id)" class="btn btn-primary">Lihat SOP</button>                                                                               
                            </td>                     
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">                        
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                </div>                    
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSOP"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal"> Daftar SOP</h5>
                    <button class="close" type="button"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SOP</th>
                                    <th>Status</th>
                                    <th>Foto</th>                                                                
                                </tr>
                            </thead>
                            <tbody>                        
                                <tr v-if="dataSop.length > 0" v-for="(data, index) in dataSop" :key="index">
                                    <td>{{ ++index }}</td>
                                    <td>{{ data.sop }}</td>
                                    <td>                                
                                        <span v-if="data.status == 0">
                                            Belum Selesai
                                        </span>
                                        <span v-else>
                                            Selesai
                                        </span>                                
                                    </td>                            
                                    <td><img :src="data.file" width="100"></td>                                                        
                                                
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
        let app = new Vue({
            el: '#myapp',
            data: {               
                form: {
                    user_id: '',
                    nama: '',
                    jmlKpi: '',
                    jmlSop: '',
                },                  
                dataKpi: {
                    judulKpi: '',
                    batasTanggal: '',
                    jumlahSop:'',
                    selesai:'',
                    belum:''
                },                
                kpi: {
                    id:'',
                    judul_kpi:'',
                    batas_tanggal: '',
                },
                dataSop: {
                    id:'',
                    kpi_id:'',
                    sop:'',
                    status:''
                }                                               
            },
            methods: {     
                getKpi: function () {
                    axios.get('getListKpi')
                        .then(res => {                            
                             // handle success
                            // console.log(res.data);
                            if(res.data != null){
                                this.form = res.data;
                            } 
                            
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },                                            
                sop: function(id) {                    
                    // console.log(id);                    
                    window.location.href = "<?= base_url('sop') ?>/"+id;
                },               
                detailKpi(user_id) {       
                    axios.post('getKpiByUser', {
                        user_id
                    })
                    .then(res => {                            
                            // handle success
                        // console.log(res.data);
                        if(res.data != null){
                            res.data.data.map((dt) => {
                                dt.batasTanggal = dt.batasTanggal.toString().split("-").reverse().join("-");
                                
                                return dt;
                            })
                            this.dataKpi = res.data.data;
                        } else {
                            this.dataKpi = '';
                        }
                        
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                    })             
                    $('#modalKPI').modal('show'); 
                },
                detailSop(id) {       
                    axios.post('getSop', {
                        id
                    })
                    .then(res => {                            
                            // handle success
                        // console.log(res);
                        if(res.data != null){

                            res.data.kpi.batas_tanggal = res.data.kpi.batas_tanggal.toString().split("-").reverse().join("-");          

                            this.dataSop = res.data.sop.map((element) => {
                                element.file = "<?= base_url("img") ?>/" + element.file;
                                return element;
                            });                    

                            this.kpi = res.data.kpi;                            
                            this.dataSop = res.data.sop;         

                            console.log(this.dataSop);;                                                                     

                            // console.log(this.datas.sop);                                              
                            // this.dataKpi = res.data.data;
                        } else {
                            this.kpi = '';                            
                            this.dataSop = ''; 
                        }
                        
                    })
                    .catch(err => {
                        // handle error
                        console.log(err);
                    })             
                    $('#modalSOP').modal('show'); 
                }

            },    
            created: function(){
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                this.getKpi();
            }
        })
    </script>
  
    
<?= $this->endSection() ?>
 