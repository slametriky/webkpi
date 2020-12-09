<?= $this->extend('_partials/template') ?>

<?= $this->section('content') ?>
<div class="col-sm-12" id="myapp">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">SOP</h6>            
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="col-md-3 mb-3">
                <a href="<?= base_url('kpi') ?>" class="btn btn-primary"><i class="fa fa-back"></i> Kembali</a>
            </div>            
            <table class="table">
                <tr>
                    <td>Judul KPI</td>
                    <td><?= $kpi['judul_kpi'] ?></td>
                </tr>
                <tr>
                    <td>Tanggal Berakhir</td>
                    <td><?= tgl_indo($kpi['batas_tanggal']) ?></td>
                </tr>
            </table>
            <?php 
                // print_r($kpi);
            ?>

            <div class="row mt-0">                
                <form id="formSop" @submit.prevent="simpanSop" class="form-inline mb-3">                
                    <div class="mx-sm-3 mb-2">                    
                        <input type="hidden" name="kpi_id" v-model="form.kpi_id">
                        <input type="text" v-model="form.sop" class="form-control" name="sop" placeholder="SOP" required>
                    </div>
                    <div class="mx-sm-3 mb-2">                    
                        <select class="form-control" v-model="form.status" name="status">
                            <option value="0">Belum</option>
                            <option value="1">Selesai</option>                            
                        </select>                    
                    </div>
                    <div class="mx-sm-3 mb-2">                    
                        <input type="file" class="form-control" ref="file" v-on:change="onChangeFileUpload()" placeholder="Foto" required>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                </form>            

                <!-- <img src="<?= base_url('writable/uploads/1607439762_2bd837d49948ba5790f8.jpeg') ?>" alt="">         -->  

            </div>            
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>SOP</th>
                            <th>Status</th>
                            <th>Foto</th>                            
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr v-if="sop.length > 0" v-for="(data, index) in sop" :key="index">
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
                            <td><img :src="data.gambar" width="100"></td>                                                        
                            <td>                                                

                                <button @click="editSop(data)" data-toggle="modal" data-target="#modalEditSop"  class="btn btn-primary">Edit</button>                  
                                <button @click="hapusSop(data.id, data.file)" class="btn btn-danger">Hapus</button>                                                               
                            </td>                     
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalEditSop" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judulModal"> Edit SOP</h5>
                            <button class="close" type="button" data-dismiss="modal" @click="tutupModal()"  aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="updateSop">
                                <div class="form-group">                                    
                                    <label>SOP</label>
                                    <input type="hidden" class="form-control" v-model="tmpSop.id" required>  
                                    <input type="hidden" class="form-control" v-model="tmpSop.gambar" required>  
                                    <input type="text" class="form-control" v-model="tmpSop.sop" placeholder="SOP" required>                        
                                </div>             

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" v-model="tmpSop.status">
                                        <option value="0" :selected= "tmpSop.status == 0">Belum Selesai</option>
                                        <option value="1" :selected= "tmpSop.status == 1">Selesai</option>
                                    </select> 
                                </div>

                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" ref="file2" v-on:change="onChangeFileUpload2()" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <label>Foto Lama</label>
                                    <br>
                                    <img :src="tmpSop.gambar" width="150">
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
    <script>
        let app = new Vue({
            el: '#myapp',
            data: {
                tmpSop:{},
                sop: {},
                form: {
                  kpi_id: "<?= $kpi['id'] ?>",
                  sop: '',
                  status: '',                
                },            
                file:'',                
                file2:'',       

            },
            methods: {     
                getSop: function () {
                    axios.get('<?= base_url('getsop/'.$kpi['id']) ?>')
                        .then(res => {                            
                             // handle success                             
                            if(res.data != null){                                                                
                                this.sop = res.data.map((element) => {
                                    element.gambar = "<?= base_url("img") ?>/" + element.file;
                                    return element;
                                });                                
                            } 
                            
                        })
                        .catch(err => {
                            // handle error
                            console.log(err);
                        })
                },     
                simpanSop: function(){          

                    let formData = new FormData();
                    formData.append('file', this.file);
                    formData.append('kpi_id', this.form.kpi_id);
                    formData.append('sop', this.form.sop);
                    formData.append('status', this.form.status);                    

                    axios.post("<?= base_url('simpansop') ?>", formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                        
                    })
                    .then(res => {                        
                        // handle success                        
                        if(res.data.code == 200){
                            this.getSop();                            
                            alert('Berhasil');
                            this.bersihkanForm();
                        } else {
                            alert('Gagal');
                        }                        
                    })
                    .catch(err => {                        
                        console.log(err);
                    })                    

                    
                },      
                onChangeFileUpload(){
                    this.file = this.$refs.file.files[0];
                },
                onChangeFileUpload2(){
                    this.file2 = this.$refs.file2.files[0];
                },
                bersihkanForm(){
                    this.form.sop = '';
                    this.form.status = '';
                    this.$refs.file.value = '';
                },
                editSop: function(data){
                    this.tmpSop = data;                                                       
                    console.log(this.tmpSop);
                },
                updateSop: function(){              

                    let formData = new FormData();
                    formData.append('file', this.file2);
                    formData.append('id', this.tmpSop.id);
                    formData.append('sop', this.tmpSop.sop);
                    formData.append('status', this.tmpSop.status);                    
                    formData.append('gambar', this.tmpSop.gambar);    

                    axios.post("<?= base_url('updatesop') ?>", formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                        
                    })
                    .then(res => {
                        // handle success                                                                                        
                        if(res.data.code == 200){
                            this.getSop();
                            $('#modalEditSop').modal('hide'); 
                            alert('berhasil');
                        } else {
                            console.log('gagal');
                        }                        
                    })
                    .catch(err => {                        
                        console.log(err);
                    })
                },      
                hapusSop: function(id, file){            
                    // console.log(id);
                    const data = {id, file}
                    if(confirm("Yakin hapus data?")){                        
                        axios.post('<?= base_url('hapussop') ?>', {
                            data
                        })
                        .then(res => {                            
                            // handle success
                            if(res.data.code == 200){                                
                                this.getSop();                                                              
                            } else {
                                console.log('gagal');
                            }                           
                        })
                        .catch(error => {                        
                            if (error.response) {
                                /*
                                * The request was made and the server responded with a
                                * status code that falls out of the range of 2xx
                                */
                                console.log(error.response.data);
                                console.log(error.response.status);
                                console.log(error.response.headers);
                            } 
                            // console.log(error.config);
                        })
                    }
                },
                tutupModal(){
                    this.getSop();               
                }
            },    
            created: function(){
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; 
                this.getSop();               
            }
        })
    </script>
  
<?= $this->endSection() ?>