<div class="col-md-6">
    <div class="panel panel-info">
        <div class="panel-heading"><?php echo !empty($formTitle)?$formTitle:'';?></div>
        <div class="panel-body">
        <form method="POST" action="" id="form_user">
            <div class="col-md-12">
                <div class="col-sm-12">
                    <strong>Nama Guru</strong>
                    <input type="text" name="first_name" placeholder="Masukkan Nama Guru / Pengguna" required="true" class="form-control form-control-line f_name name">
                </div>
            </div>
            <div class="col-md-12">
                <br/>
                <div class="col-sm-12">
                    <strong>Username / NIP/ Kode Login</strong>
                    <input type="text" name="username" placeholder="Dibutuhkan untuk masuk aplikasi" required="true" class="form-control form-control-line u_name">
                </div>
            </div>
            <div class="col-md-12">
                <br/>
                <div class="col-sm-12">
                    <strong>Role</strong>
                    <select name="role" id="" required="true" class="form-control form-control-line  role">
                        <option value="1">Super Admin</option>
                        <option value="2">Admin</option>
                        <option value="3">Guru Mata Pelajaran</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <br/>
                <i style="font-size:10px;color:orange;">* Perhatian, password pengguna untuk pertama kali dibuat akan sama dengan username/ NIP/ Kode Login. Nilai tersebut unik, tidak diizinkan jika yang diinputkan sudah tersimpan.</i>
                <br/>
                <br/>
                <div class="col-sm-12">
                    <div align="center">
                        <a href="<?php echo site_url('user')?>"  class="btn btn-danger" style="color:white">BATAL</a>
                        <button type="submit" class="btn btn-info">SIMPAN</button>
                    </div>
                </div>    
            </div>    
        </form>
        </div>
    </div>
</div>