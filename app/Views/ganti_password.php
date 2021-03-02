<?= $this->extend('_partials/template') ?>

<?= $this->section('content') ?>
<div class="col-sm-5" id="myapp">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Ganti Password</h6>            
        </div>
        <!-- Card Body -->
        <div class="card-body">                       
            <div class="row mt-0">     
                <div class="col-sm-12">
                    <p class="text-danger" v-show="showError"> {{ err }} </p>
                    <form @submit.prevent="gantiPassword" class="user">
                        <div class="form-group">
                            <input type="password" v-model="form.passwd_lama" class="form-control" name="password" required placeholder="Password Lama">
                        </div>     
                        <div class="form-group">
                            <input type="password" v-model="form.passwd_baru" class="form-control" name="password" required placeholder="Password Baru">
                        </div>                   
                        <div class="form-group">
                            <input type="password" v-model="form.passwd_konfirm" class="form-control" name="password" required placeholder="Konfirmasi Password">
                        </div>                   
                        <button class="btn btn-primary btn-block" type="submit">Ganti Password</button>                                                        
                    </form>                       
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
                form: {
                  passwd_lama: '',
                  passwd_baru: '',
                  passwd_konfirm: '',                
                },                  
                showError:false,    
                err:''           
            },
            methods: {                       
                gantiPassword(){          
                                        
                    let formData = new FormData();                    
                    formData.append('passwd_lama', this.form.passwd_lama);
                    formData.append('passwd_baru', this.form.passwd_baru);
                    formData.append('passwd_konfirm', this.form.passwd_konfirm);                    

                    if(this.form.passwd_baru == this.form.passwd_konfirm){

                        axios.post("<?= base_url('ganti_password') ?>", formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                            
                        })
                        .then(res => {           
                            console.log(res);             
                            // handle success                                                
                            if(res.data.code == 200){
                                alert(res.data.message);
                                // this.getSop();                            
                                window.location = "<?= base_url('/logout') ?>";
                                // this.bersihkanForm();
                            } else {
                                this.showError = true;
                                this.err = res.data.message;
                            }                        
                        })
                        .catch(err => {                        
                            console.log(err);
                        })   
                        
                    } else {
                        this.showError = true;
                        this.err = 'Password Baru dan Konfirmasi Tidak Sama!';
                    }                                     

                    
                },                                        
            },    
            created: function(){
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; 
                             
            }
        })
    </script>
  
<?= $this->endSection() ?>