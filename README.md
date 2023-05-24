### Saya Muhammad Yusuf Bahtiar NIM 2107980 mengerjakan Tugas Praktikum 3 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

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

![Design-DataBase](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/dee4c7fb-f98c-429a-a6da-ddbf7a1efe02)

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
   - home_club_id untuk foreign key dari atribut id pada tabel clubs
   - away_club_id untuk foreign key dari atribut id pada tabel clubs
   - date untuk waktu pertandingan diselenggarakan

5. Tabel stadiums memiliki 4 atribut diantaranya:

   - id untuk id stadion
   - name untuk nama stadion
   - location untuk lokasi stadion
   - photo untuk identitas fisik stadion

Dari desain yang dirancang tersebut, dapat dilihat bahwa terdapat beberapa relasi, diantaranya relasi _many to one_ antara tabel players dan positions karena setiap pemain hanya dapat memiliki 1 posisi (role) di klub, relasi _many to one_ antara tabel players dan clubs karena setiap pemain juga hanya dapat terikat kontrak dengan 1 club saja, _one to one_ antara tabel clubs dan stadiums karena setiap 1 stadion dirancang untuk dimiliki oleh 1 klub saja, dan _one to many_ antara tabel clubs dan matches karena setiap klub dapat memainkan banyak pertandingan.

<br>

## Alur Program

Program akan menampilkan halaman `Home` yang berisi daftar pemain dalam bentuk card dan dilengkapi beberapa menu di navigation bar, diantarnya `Add Player`, `Club List`, `Stadium List`, `Match List`, dan `Search Bar`. Menu `Search Bar` pada halaman `Home` dapat digunakan untuk mencari pemain berdasarkan nama pemain, nama klub, atau posisi pemain di klub. Pada halaman `Home` juga tersedia fitur sorting dapat secara ascending/descending berdasarkan id klub.

1. Jika pengguna meng-klik card pemain, maka akan menampilkan detail dari pemain tersebut. Tersedia juga tombol update untuk mengubah data pemain yang ketika di-klik akan langsung diarahkan ke halaman form update (templatenya sama dengan create), dan tombol delete yang ketika di-klik akan langsung menghapus data pemain.
2. Jika pengguna meng-klik menu `Add Player` di navigation bar, maka akan langsung diarahkan ke halaman form create. Tersedia beberapa field yang harus diisi oleh pengguna untuk data pemain sebelum menambahkannya dengan meng-klik tombol Add Player.
3. Jika pengguna meng-klik menu `Club List` di navigation bar, maka akan menampilkan daftar klub beserta informasinya dalam bentuk tabel dan menu `Add` di navigation bar sebelumnya berubah menjadi `Add Club`. Tersedia juga icon update untuk mengubah data klub yang ketika di-klik akan menampilkan modal form berisi beberapa field yang dapat diubah oleh pengguna, dan tombol delete yang ketika di-klik akan langsung menghapus data klub. Pada halaman `Club List`, menu `Search Bar` dapat digunakan untuk mencari klub berdasarkan nama klub atau nama pelatih.
4. Jika pengguna meng-klik menu `Stadium List` di navigation bar, maka akan menampilkan daftar stadion beserta informasinya dalam bentuk tabel dan menu `Add` di navigation bar sebelumnya berubah menjadi `Add Stadium`. Tersedia juga icon update untuk mengubah data stadion yang ketika di-klik akan menampilkan modal form berisi beberapa field yang dapat diubah oleh pengguna, dan tombol delete yang ketika di-klik akan langsung menghapus data stadion. Pada halaman `Stadium List`, menu `Search Bar` dapat digunakan untuk mencari stadion berdasarkan nama stadion atau lokasi stadion.
5. Jika pengguna meng-klik menu `Match List` di navigation bar, maka akan menampilkan daftar jadwal pertandingan beserta informasinya dalam bentuk tabel dan menu `Add` di navigation bar sebelumnya berubah menjadi `Add Match`. Tersedia juga icon update untuk mengubah data pertandingan yang ketika di-klik akan menampilkan modal form berisi beberapa field yang dapat diubah oleh pengguna, dan tombol delete yang ketika di-klik akan langsung menghapus data stadion. Pada halaman `Match List`, menu `Search Bar` dapat digunakan untuk mencari data pertandingan berdasarkan nama klub yang bertanding atau waktu pertandingan.

*Note : Halaman create akan ditampilkan ketika pengguna meng-klik menu `Add` di navigation bar dan fieldnya akan disesuaikan dengan data yang diperlukan oleh setiap tabel, contohnya jika yang di-klik `Add Player`, maka akan ditampilkan field yang diperlukan untuk data pemain, jika yang di-klik `Add Club`, maka akan ditampilkan field yang diperlukan untuk data club, dan seterusnya.

<br>

## Dokumentasi
- Home
![Home](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/5e67a5ed-31f8-481c-b052-0b0c78e0bb0f)

- Player Details
![Detail](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/7da29a63-2ee0-4560-bd44-0499da4a036b)

- Form Create (example: Player)
![Form-Create](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/48b9be28-3147-4679-9931-d81476adcc50)

- Club List
![Club-List](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/78ce271f-0600-46d7-b296-77f1c5aea816)

- Stadium List
![Stadium-List](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/5b193585-506c-41c9-b99c-319f3270be95)

- Match List
![Match-List](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/ce198a16-10bd-4208-a089-bd42d28067e9)

- Form Update (example: Club)
![Form-Update](https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/a06430c0-de5e-4eec-b9d0-950cacb0ba96)

- Video
https://github.com/bahtiaryusuf10/TP3DPBO2023C2/assets/100776170/013c0170-74c2-432c-bfb3-44e4a69d7371.mp4
