### Saya Muhammad Yusuf Bahtiar NIM 2107980 mengerjakan Tugas Prkatikum 3 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

<br>

## Deskripsi Tugas

Buatlah program menggunakan bahasa pemrograman PHP dengan spesifikasi sebagai berikut:

- Program bebas, kecuali program Ormawa
- Menggunakan minimal 3 buah tabel
- Terdapat proses Create, Read, Update, dan Delete data
- Memiliki fungsi pencarian dan pengurutan data (kata kunci bebas)
- Menggunakan template/skin form tambah data dan ubah data yang sama
- 1 tabel pada database ditampilkan dalam bentuk bukan tabel, 2 tabel sisanya ditampilkan dalam bentuk tabel (seperti contoh saat praktikum)
- Menggunakan template/skin tabel yang sama untuk menampilkan tabel
  <br>

## Desain Program

Program didesain menggunakan 5 tabel, yaitu:

1. Tabel players memiliki 7 atribut diantaranya:

   - id untuk id pemain
   - name untuk nama pemain
   - photo untuk identitas fisik pemain
   - club_id untuk foreign key dari atribut id pada tabel clubs
   - position_id untuk foreign key dari atribut id pada tabel positions
   - jersey_number untuk identitas pemain di club
   - age untuk umur pemain

2. Tabel position memiliki 2 atribut diantaranya:

   - id untuk id posisi
   - name untuk nama posisi yang tersedia sebagai posisi (role) player di klub

3. Tabel clubs memiliki 5 atribut diantaranya:

   - id untuk id klub
   - name untuk nama klub
   - stadium_id untuk foreign key dari atribut id pada tabel stadiums
   - logo untuk identitas fisik klub
   - coach untuk nama pelatih yang melatih klub

4. Tabel matches memiliki 4 atribut diantaranya:

   - id untuk id pertandingan
   - home_id untuk foreign key dari atribut id pada tabel clubs
   - away_id untuk foreign key dari atribut id pada tabel clubs
   - date untuk waktu pertandingan di selenggarakan

5. Tabel stadiums memiliki 4 atribut diantaranya:

   - id untuk id stadion
   - name untuk nama stadion
   - location untuk lokasi stadion
   - photo untuk identitas fisik stadion

Dari desain yang dirancang tersebut, dapat dilihat bahwa terdapat beberapa relasi, diantaranya relasi _many to one_ antara tabel players dan positions karena setiap pemain hanya dapat memiliki 1 posisi (role) di klub, relasi _many to one_ antara tabel players dan clubs karena setiap pemain juga hanya dapat terikat kontrak dengan 1 club saja, _one to one_ antara tabel clubs dan stadiums karena setiap 1 stadion dirancang untuk dimiliki oleh 1 klub saja, dan _one to many_ antara tabel clubs dan matches karena setiap klub dapat memainkan banyak pertandingan.
<br>

## Alur Program

Program akan menampilkan halaman `Home` yang berisi daftar pemain dalam bentuk card dan dilengkapi beberapa menu di navigation bar, diantarnya `Add Player`, `Club List`, `Stadium List`, dan `Match List`.

1. Jika pengguna meng-klik card pemain, maka akan menampilkan detail dari pemain tersebut. Tersedia juga tombol update untuk mengubah data pemain yang ketika di-klik akan langsung diarahkan ke halaman form update (templatenya sama dengan create), dan tombol delete yang ketika di-klik akan langsung menghapus data pemain.
2. Jika pengguna meng-klik menu `Add Player` di navigation bar, maka akan langsung diarahkan ke halaman form create. Tersedia beberapa field yang harus diisi oleh pengguna untuk data pemain sebelum menambahkannya dengan meng-klik tombol Add Player.
3. Jika pengguna meng-klik menu `Club List` di navigation bar, maka akan menampilkan daftar klub beserta informasinya dalam bentuk tabel dan menu `Add` di navigation bar sebelumnya berubah menjadi `Add Club`. Tersedia juga icon update untuk mengubah data klub yang ketika di-klik akan menampilkan modal form berisi beberapa field yang dapat diubah oleh pengguna, dan tombol delete yang ketika di-klik akan langsung menghapus data klub.
4. Jika pengguna meng-klik menu `Stadium List` di navigation bar, maka akan menampilkan daftar stadion beserta informasinya dalam bentuk tabel dan menu `Add` di navigation bar sebelumnya berubah menjadi `Add Stadium`. Tersedia juga icon update untuk mengubah data stadion yang ketika di-klik akan menampilkan modal form berisi beberapa field yang dapat diubah oleh pengguna, dan tombol delete yang ketika di-klik akan langsung menghapus data stadion.
5. Jika pengguna meng-klik menu `Match List` di navigation bar, maka akan menampilkan daftar jadwal pertandingan beserta informasinya dalam bentuk tabel dan menu `Add` di navigation bar sebelumnya berubah menjadi `Add Match`. Tersedia juga icon update untuk mengubah data pertandingan yang ketika di-klik akan menampilkan modal form berisi beberapa field yang dapat diubah oleh pengguna, dan tombol delete yang ketika di-klik akan langsung menghapus data stadion.

- Halaman create akan ditampilkan ketika pengguna meng-klik menu `Add` di navigation bar dan fieldnya akan disesuaikan dengan data yang diperlukan oleh setiap tabel, contohnya jika yang di-klik `Add Player`, maka akan ditampilkan field yang diperlukan untuk data pemain, jika yang di-klik `Add Club`, maka akan ditampilkan field yang diperlukan untuk data club, dan seterusnya.

Program akan menampilkan frame berisi 2 objek, yakni objek _player_ yang direpresentasikan dalam bentuk lingkaran dan objek _box_ yang direpresentasikan dalam bentuk persegi. Tombol untuk mengendalikan objek _player_ dapat menggunakan _WASD_ atau _arrow key_, informasi _score_ yang ditampilkan di layar akan bertambah +1 ketika _user_ menggerakkan objek _player_ berganti-ganti arah (sesuai deskripsi tugas). Terdapat juga sistem collision, yakni ketika objek _player_ mengenai objek _box_, maka _score_ terkini akan ditambah +5, objek _box_ tersebut akan dihapus dan dibuat kembali, tetapi ditempatkan secara acak.

<br>

## Dokumentasi