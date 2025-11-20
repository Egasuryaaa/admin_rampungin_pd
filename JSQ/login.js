// Dokumen ready di dalam satu file bisa lebih 1 namun saya anjurkan 1 aja dan apapun yang didalam dokumen ready kalau bisa berupa fungsi
// karena dokumen ready itu akan di panggil ketika halaman sudah siap ditampilkan
$(document).ready(function () {
  // Tangani submit form login
  $('#formLogin').on('submit', function (e) {
    e.preventDefault();
    login();
  });
});

//FUNGSI LOGIN KITA BUAT UNTUK MELAKUKAN PROSES LOGIN YANG DI TRIGER DENGAN SUBMIT FORM
function login() {
  //ada penamaan variabel ada Var, Const dan Let (ket cari di google)
  const data = $("#formLogin").serializeArray(); //serializeArray() digunakan untuk mengirim data form ke server dalam bentuk array
  // CSRF token tidak diperlukan karena sudah dinonaktifkan
  //AJAX REQUEST UNTUK MENGIRIM DATA LOGIN KE SERVER
  $.ajax({
    url: BaseUrlJsQ + "login", //URL untuk mengirim data login ke server
    type: "POST", //Metode pengiriman data ke server
    dataType: "JSON", //Tipe data yang diharapkan dari server
    data: $.param(data), //Mengirim data login yang sudah di serialize ke server
    success: function (response) {
      console.log("Login response:", response);
      // TAHAP 1
      //MENGATASI RESPONSE DARI FILTER==>
      if (response.Pesan_kirimke_ajax) {
        Swal.fire({
          icon: 'warning',
          title: 'Peringatan',
          text: response.Pesan_kirimke_ajax,
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = response.lempar_ke_url;
        });
        return;
      }
      //Kalau dari filter tidak ada pesan maka lanjut ke tahap 2
      // ===================================================>
      // TAHAP 2
      // MENGATASI RESPONSE DARI CONTROLER==>
      // CSRF token tidak diperlukan karena sudah dinonaktifkan
      if (response.status === 'success') {
        //Jika status berhasil
        Swal.fire({
          icon: 'success',
          title: 'Login Berhasil',
          text: 'Selamat datang!',
          timer: 2000,
          showConfirmButton: false
        }).then(() => {
          window.location.href = response.data.ke_route;
        });
        //arahkan ke dashboard alias login berhasil
      } else {
        //Jika status false atau tidak ada nilainya atau null
        let pesanError = response.pesan;
        let icon = 'error';
        let title = 'Login Gagal';
        let showTimer = false;

        // Cek jika akun terkunci
        if (response.is_locked) {
          icon = 'warning';
          title = 'Akun Terkunci';
          showTimer = true;
        }
        // Jika tidak terkunci tapi ada jumlah kegagalan
        else if (response.jumlah_kegagalan) {
          pesanError +=
            "\n\nPercobaan gagal: " +
            response.jumlah_kegagalan +
            " kali. Akun akan terkunci setelah 5 kali percobaan gagal.";
        }

        //Tampilkan pesan error dengan SweetAlert2
        Swal.fire({
          icon: icon,
          title: title,
          text: pesanError,
          confirmButtonText: 'OK',
          timer: showTimer ? (response.remaining_time * 60 * 1000) : undefined,
          timerProgressBar: showTimer,
          allowOutsideClick: !showTimer
        });
      }
      // END
    },
    error: function (jqXHR, textStatus, errorThrown) {
    // Tambahan console.log untuk debugging
    console.log("=== DEBUG LOGIN ERROR ===");
    console.log("jqXHR Status:", jqXHR.status);
    console.log("jqXHR Response Text:", jqXHR.responseText);
    console.log("jqXHR Response JSON:", jqXHR.responseJSON);
    console.log("Text Status:", textStatus);
    console.log("Error Thrown:", errorThrown);
    console.log("=== END DEBUG ===");

    let pesanError = 'Terjadi kesalahan. Silakan hubungi administrator.'; // Pesan default

    // Coba ambil pesan dari responseJSON (jQuery biasanya otomatis parse jika Content-Type benar)
    if (jqXHR.responseJSON && jqXHR.responseJSON.pesan) {
        pesanError = jqXHR.responseJSON.pesan;
    }
    // Fallback jika responseJSON tidak ada/kosong tapi status 403 (Forbidden)
    else if (jqXHR.status === 403) {
        pesanError = 'Akses ditolak (403). Periksa hak akses Anda.';
        // Anda bisa juga mencoba parse responseText di sini sebagai upaya terakhir jika perlu
        try {
             const json = JSON.parse(jqXHR.responseText);
             if (json && json.pesan) {
                 pesanError = json.pesan; // Ambil pesan dari parse manual jika ada
             }
        } catch(e) { 
            console.log("Error parsing responseText:", e);
        }
    }
    // Fallback untuk error server lainnya (500, dll)
    else if (jqXHR.status >= 500) {
         pesanError = 'Terjadi kesalahan pada server. Coba lagi nanti.';
    }

    // Tampilkan pesan error yang sudah didapatkan
    Swal.fire({
        icon: 'error',
        title: (jqXHR.status === 403) ? 'Akses Ditolak' : 'Login Gagal',
        text: pesanError,
        confirmButtonText: 'OK'
    });

    // Update CSRF token jika ada di respons error
    if (jqXHR.responseJSON && jqXHR.responseJSON.csrf_baru) {
        $('input[name="csrf_test_name"]').val(jqXHR.responseJSON.csrf_baru);
    }
}, // Akhir dari blok error
    }); // Akhir dari $.ajax
} // Akhir dari fungsi login