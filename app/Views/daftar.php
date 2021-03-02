<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>KPI - Daftar</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('themes'); ?>/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
  <div class="container" id="myapp">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">              
              <div class="col-md-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">KPI</h1>
                    <p>Registrasi User</p>
                  </div>
                    
                  <div v-show="showError" class="alert" :class="info">{{ message }}</div>
                    
                  <form @submit.prevent="daftar" class="user" name="formPendaftaran">                        
                      <div class="form-group">
                          <input type="text" v-model="form.nik" class="form-control" maxlength="16" minlength="16" name="nik" id="nik" required placeholder="NIK">
                      </div>                        
                      <div class="form-group">
                          <input type="text" class="form-control" v-model="form.nama" name="nama" id="nama" required placeholder="Nama">
                      </div>                       
                      <div class="form-group">
                        <select name="jenkel" v-model="form.jenkel" class="form-control">
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="L">Laki-Laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>                       
                      <div class="form-group">
                          <input type="text" v-model="form.email" class="form-control" name="email" id="email" required placeholder="Email">
                      </div>                       
                      <div class="form-group">
                          <input type="text" v-model="form.handphone" class="form-control" name="handphone" id="handphone" required placeholder="Handphone">
                      </div>                        
                      <div class="form-group">
                          <input type="password" v-model="form.password" class="form-control" name="password" id="password" required placeholder="Password">
                      </div>     
                      <div class="form-group">
                          <input type="password" v-model="form.password_konfirm" class="form-control" name="password_konfirm" id="password_konfirm" required placeholder="Konfirmasi Password">
                      </div>                                                                  
                      <button class="btn btn-primary btn-block" type="submit">Daftar</button>                    
                      <hr>               
                      <p class="text-center">Sudah punya akun, silahkan <a href="<?= base_url('login') ?>">Masuk</a></p>  
                  </form>                            
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('themes'); ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('themes'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('themes'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('themes'); ?>/js/sb-admin-2.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>

  <script>
        let app = new Vue({
            el: '#myapp',
            data: {                
                form: {
                  nik: '',
                  nama: '',
                  jenkel: '',                
                  email:'',
                  handphone:'',
                  password:'',
                  password_konfirm:''
                },                  
                showError:false,    
                info:'',           
                message:''
            },
            methods: {                       
                daftar(){                                           

                    let form  = document.forms.namedItem("formPendaftaran");
                    let formData = new FormData(form);    


                    if(this.form.password.length < 8) {

						            this.showError = true;
                        this.info = 'alert-danger';
                        this.message = 'Password Minimal 8 Karakter'
						
                    } else {

                      if(this.form.password == this.form.password_konfirm){
                        axios.post("<?= base_url('daftar') ?>", formData)
                        .then(res => {           
                              
                          // handle success                                                
                          if(res.data.code == 200){
                            
                            this.showError = true;
                            this.info = 'alert-success';
                            this.message = 'Berhasil daftar, silahkan login'                                                                                        

                            this.form.nik = '';
                            this.form.nama = '';
                            this.form.jenkel = '';
                            this.form.email = '';
                            this.form.handphone = '';
                            this.form.password = '';
                            this.form.password_konfirm = '';

                          } else {

                            this.showError = true;
                            this.info = 'alert-danger';
                            this.message = res.data.message                                
                            
                          }        

                        })
                        .catch(err => {                        
                          console.log(err);
                        })   
                                  
                      } else {
                        this.showError = true;
                        this.info = 'alert-danger';
                        this.message = 'Password dan Konfirmasi Password tidak sama'
                      }                                     

                    }                                        

                },                                        
            },    
            created: function(){
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';                              
            }
        })
    </script>

</body>

</html>
