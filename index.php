<!DOCTYPE html>
<?php
include 'koneksi.php';
if (isset($_GET['error']))
{echo "<script>alert('Username atau Password Salah');</script>";}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="images/favico.ico" type="image/ico" sizes="32x32"> 
        <title>QR Code Decoder | C3x</title>

        <link rel="stylesheet" href="css/qr.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/qrcodelib.js"></script>
        <script type="text/javascript" src="js/webcodecamjquery.js"></script>
    </head>
    <body>
        <div id="header1">
            <h3>Deteksi QR Code dengan JQuery</h3>
            <div id="tombol_header">
                <button id="tombol_h_login" value="Submit">Login</button>
                <button id="tombol_h_help" value="Submit">Bantuan</button>
            </div>
        </div>
        <div id="header2">
            <span id="clock">&nbsp;</span>
        </div>


    <table align="center">
        <tr>
            <td style="padding-right: 200px;">
            <center>Dekatkan QR Code ke kamera<br/>
            <canvas></canvas>
            </td>
            <td>
                <div id="foto"="">
                    <img id="foto_p" src="images/no-image.jpg" height="150px" width="150px">
                </div>
            </td>             
            <td>
                <div id="status_cam">
                        <div id="cam_not_ready">
                        Siap dalam <span>7</span> detik
                        </div>
                        <div id="cam_ready">
                        Kamera Siap!
                        </div>   
                    </div>
                Hasil:                    
                <div class="hasil">
                </div>      
            </td>
                
        </tr>
        <tr>
            <td align="center" style="padding-right: 200px;"><select id="pengaturan"></select></td>
        </tr>
    </table>

    <!-- KEHADIRAN -->
                <div class="khd">
                    <div class="admin">
                        <div class="row">
                            
                                <label>Nama Pegawai:</label><br/>
                                <select name="pegawai" id="pegawai" class="InputBox" onChange="getKehadiran(this.value);">
                                    <option value="">Pilih Pegawai</option>
                                    <?php
                                    date_default_timezone_set('Asia/Makassar');
                                    $jam = date('H:i:s');
                                    $tanggal = date('Y-m-d');
                                    //PILIH PEGAWAI YANG TIDAK PRESENSI TANGGAL ...
                                    $sql=$db->query("SELECT p.id_peg, p.nama, p.foto FROM pegawai p LEFT JOIN presensi pr ON p.id_peg=pr.id_peg WHERE tgl IS NULL OR tgl!='$tanggal' GROUP BY p.id_peg");
                                    if(!$sql){
                                       die($db->error);
                                      }

                                    while($pegawai = $sql->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $pegawai['id_peg'].'/'.$pegawai['foto'];?>"><?php echo $pegawai["nama"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                </div>
                                <div class="row">
                                    <label>Kehadiran:</label><br/>
                                    <select name="kehadiran" id="list_kehadiran" class="InputBox">
                                        <option value="">Kehadiran</option>
                                    </select>
                                </div>
                                <button id="tombol1" type="submit" value="Submit">Kirim</button>
                                <button id="tombol_tutup" value="Submit">X</button>
                            

                          
                        </div>
                    </div>
                </div>

    <script type="text/javascript">

            function FungsiMenunggu() {
                $('#cam_ready').hide();
                $('#cam_not_ready').fadeIn('fast'); 
                var sec = 7
                var timer = setInterval(function() { 
                   $('#cam_not_ready span').text(sec--);
                   if (sec < 0) {
                      $('#cam_not_ready').hide();
                      $('#cam_ready').fadeIn('fast');                      
                      clearInterval(timer);                                               
                   } 
                }, 1000);
            }


            var arg = {
                resultFunction: function(result) {
                    //$('body').append($('<li>' + result.format + ': ' + result.code + ' </li>'));
                
                $.post('json/qr_cek.php?aksi=cek',{id:result.code},function(data){
                if(data.rows[0])
                {
                    FungsiMenunggu();
                    $('.hasil').prepend($('<li id=\'sukses\'> Nama: '+ data.rows[0].nama + ' <br/>Status: ' + data.rows.ket+ ' <br/>Tanggal: ' + data.rows.tanggal+ ' <br/>Jam: ' + data.rows.jam+ ' WITA <div class=\'bg_sukses\'>Sukses</div></li>'));
                        if (data.rows[0].foto=='')
                        {
                            $('#foto_p').attr('src', 'images/no-image.jpg');
                        }
                        else
                        {
                            $('#foto_p').attr('src', 'foto/'+ data.rows[0].foto);
                        }                        
                                        
                } 
                else if (data.rows.ket)
                {
                    FungsiMenunggu();
                    $('.hasil').prepend($('<li id=\'sukses2\'> Admin </li>'));                    
                    $('.khd').show();
                }
                else 
                {
                    FungsiMenunggu();
                    $('.hasil').prepend($('<li id=\'gagal\'> Gagal </li>'));
                }
                //SCROLL ALWAYS BOTTOM
                //$(".hasil").animate({ scrollTop: $(document).height() }, "slow");
            },'json');
                }
            };

            var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery
            decoder.buildSelectMenu("select#pengaturan");
            decoder.play();
            /*  Without visible select menu
                decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
            */         
                 
        </script>

    <script type="text/javascript">

        var d = new Date();

        var hours = d.getHours();
        var minutes = d.getMinutes();
        var seconds = d.getSeconds();

        var hari = d.getDay();
        var namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        hariIni = namaHari[hari];

        var tanggal = ("0" + d.getDate()).slice(-2);

        var month = new Array();
        month[0] = "Januari";
        month[1] = "Februari";
        month[2] = "Maret";
        month[3] = "April";
        month[4] = "Mei";
        month[5] = "Juni";
        month[6] = "Juli";
        month[7] = "Agustus";
        month[8] = "September";
        month[9] = "Oktober";
        month[10] = "Nopember";
        month[11] = "Desember";
        var bulan = month[d.getMonth()];
        var tahun = d.getFullYear();




        var date = Date.now(),
  second = 1000;

function pad(num) {
  return ('0' + num).slice(-2);
}

function updateClock() {
  var clockEl = document.getElementById('clock'),
  dateObj;
  date += second;
  dateObj = new Date(date);
  clockEl.innerHTML = 'Hari: ' + hariIni + '. Tanggal: ' + tanggal + ' ' + bulan + ' ' + tahun + '. Jam: ' + pad(dateObj.getHours()) + ':' + pad(dateObj.getMinutes()) + ':' + pad(dateObj.getSeconds());
}

setInterval(updateClock, second);


        //ONCLICK TOMBOL1 + RELOAD SEMUA JAVASCRIPT DI BODY UNTUK AJAX
        $('body').on('click', '#tombol1', function(){

            var peg_peg = $('#pegawai').val();
            var res = peg_peg.split("/");
            var pegawai = res[0];
            var foto = res[1];

            var pegawai = $('#pegawai').val();
            var jenis_khd = $('#list_kehadiran').val();

            var pegawai_t = $('#pegawai :selected').text();
            var jenis_khd_t = $('#list_kehadiran :selected').text();

            

            if (pegawai.length==0 && jenis_khd.length==0)
            {
                alert('Pegawai atau Kehadiran belum dipilih');
            }
            else
            {
                $.ajax({
                type: 'POST',
                url: 'json/qr_admin.php',
                data: 'pegawai=' + pegawai + '&jenis_khd=' + jenis_khd,   
                success:function(data) {
                   //update_div.html(html);
                   $('.hasil').prepend($('<li id=\'sukses3\'> Nama: ' + pegawai_t + ' <br/>Kehadiran: ' + jenis_khd_t + ' <br/>Tanggal: '+tanggal+' '+bulan+' '+tahun+' <br/>Jam: '+hours+':'+minutes+':'+seconds+' WITA <div class=\'bg_sukses\'>Sukses</div></li>'));
                    if (foto=='')
                        {
                            $('#foto_p').attr('src', 'images/no-image.jpg');
                        }
                        else
                        {
                            $('#foto_p').attr('src', 'foto/'+ foto);
                        }   
                   $('.khd').hide(); 
                   //RELOAD KEHADIRAN SETELAH DI KIRIM
                   $(".khd").load(location.href + " .khd");
                   //SCROLL ALWAYS BOTTOM
                   //$(".hasil").animate({ scrollTop: $(document).height() }, "slow");
                    
                    }
                });
            }
            
        });

        //KEHADIRAN
        function getKehadiran(val) {
        $.ajax({
        type: "POST",
        url: "json/qr_kehadiran.php",
        data:'id_peg='+val,
        success: function(data){
            $("#list_kehadiran").html(data);                
        }
        });
        }
        /*
        function selectCountry(val) {
        $("#search-box").val(val);
        $("#suggesstion-box").hide();
        }
        */    

        //ONCLICK TOMBOL TUTUP + RELOAD SEMUA JAVASCRIPT DI BODY UNTUK AJAX
        $('body').on('click', '#tombol_tutup', function(){
            $('.khd').hide();
            //RELOAD KEHADIRAN SETELAH DI KIRIM
            $(".khd").load(location.href + " .khd");
            //SCROLL ALWAYS BOTTOM
            //$(".hasil").animate({ scrollTop: $(document).height() }, "slow");
        });

    </script>

<!-- The Modal -->
<div id="login" class="modal">
  
  <form class="modal-content" method="POST" action="json/login.php">
    <div class="modal-header">
      <span class="tutup_l tutup">&times;</span>
      <h2>Login</h2>
    </div>
    <div class="modal-body">
    <table id="login_t">
        <tr>
          <td><label><b>Username</b></label></td>
          <td style="padding:0px;"><input class="InputBox input_login" type="text" placeholder="Masukan Username" name="username" required></td>
        </tr>
        <tr>
          <td><label><b>Password</b></label></td>
          <td style="padding:0px;"><input class="InputBox input_login" type="password" placeholder="Masukan Password" name="password" required></td>
        </tr>
        <tr> 
          <td><button id="tombol2" type="submit" name="login">Login</button></td>
        </tr>
    </table>
    </div>
  </form>
</div>



<div id="bantuan" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="tutup_b tutup">&times;</span>
      <h2>Bantuan</h2>
    </div>
    <div class="modal-body">
      <p><b>Penggunaan</b></p>
      <p>
      - Arahkan QR Code ke kamera<br/>
      - Tiap 10 detik waktu tunggu setelah QR Code diScan<br/>
      - QR Code Gagal: <br/>
      1. Tidak fit dengan kamera <br/>
      2. QR Code Kotor<br/>
      </p>
    </div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById('bantuan');

// Get the button that opens the modal
var btn = document.getElementById("tombol_h_help");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("tutup_b")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}


// Get the modal
var modalLogin = document.getElementById('login');

// Get the button that opens the modal
var btn2 = document.getElementById("tombol_h_login");

var span2 = document.getElementsByClassName("tutup_l")[0];

// When the user clicks the button, open the modal 
btn2.onclick = function() {
    modalLogin.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
    modalLogin.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modalLogin) {
        modalLogin.style.display = "none";
    }
    else if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


        
</body>
</html>