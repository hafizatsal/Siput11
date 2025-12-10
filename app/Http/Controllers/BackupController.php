<?php
$host = "localhost"; // MySQL host name eg. localhost
$user = "mqhnikvc_siput_root"; // MySQL user. eg. root ( if your on localserver)
$password = "p@ssw0rd_s1putUnila"; // MySQL user password  (if password is not set for your root user then keep it empty )
$database = "mqhnikvc_siput"; // MySQL Database name
// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error)
{
    die("Connection failed: " . $con->connect_error);
}

$query = "UPDATE `setting` SET `status` = '0', `maintenance_time` = NOW() WHERE `setting`.`id` = '1';";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$query = "SELECT * FROM users";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$path = '/home/mqhnikvc/public_html/backup/';
$time = time();
$path = $path . $time . '/';
mkdir($path, 0777, true);

$file = fopen($path . 'users_backup_' , "w");
fputcsv($file, array(
    'No',
    'nama',
    'username',
    'email',
    'instansi',
    'last_login',
    'logout_time',
    'api_token',
    'password',
    'pass_default',
    'pass_stat',
    'id_role',
    'remember_token',
    'created_at',
    'updated_at',
    'deleted_at'
));
$no = 1;
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $no,
            $row['nama'],
            $row['username'],
            $row['email'],
            $row['instansi'],
            $row['last_login'],
            $row['logout_time'],
            $row['api_token'],
            $row['password'],
            $row['pass_default'],
            $row['pass_stat'],
            $row['id_role'],
            $row['remember_token'],
            $row['created_at'],
            $row['created_at'],
            $row['updated_at'],
            $row['deleted_at']
        ));
        $no++;
    }
}
fclose($file);

$query = "SELECT * FROM kategori_klaster";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'kategori_backup_' , "w");
fputcsv($file, array(
    'id_data_klaster',
    'id_data_klaster2',
    'pengukuran_ke',
    'tahun_pengukuran',
    'nama_pengukur',
    'kategori',
    'input_by',
    'verif'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_data_klaster'],
            $row['id_data_klaster2'],
            $row['pengukuran_ke'],
            $row['tahun_pengukuran'],
            $row['nama_pengukur'],
            $row['kategori'],
            $row['input_by'],
            $row['verif']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM data_fauna";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'data_fauna_backup_' , "w");
fputcsv($file, array(
    'id_fauna',
    'id_klaster_plot_fauna',
    'id_plot_fauna',
    'id_master_fauna',
    'jumlah',
    'pengukuran_ke',
    'isInserted'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_fauna'],
            $row['id_klaster_plot_fauna'],
            $row['id_plot_fauna'],
            $row['id_master_fauna'],
            $row['jumlah'],
            $row['pengukuran_ke'],
            $row['isInserted']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM data_tanaman_plot";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'data_tanaman_plot_backup_' , "w");
fputcsv($file, array(
    'id_tanaman_plot',
    'id_klaster_plot',
    'id_plot',
    'id_master_jenis_tanaman',
    'pengukuran_ke',
    'status',
    'isInserted'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_tanaman_plot'],
            $row['id_klaster_plot'],
            $row['id_plot'],
            $row['id_master_jenis_tanaman'],
            $row['status'],
            $row['pengukuran_ke'],
            $row['isInserted']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM error_log";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'error_backup_' , "w");
fputcsv($file, array(
    'id',
    'time_error',
    'executed_by',
    'type'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id'],
            $row['time_error'],
            $row['executed_by'],
            $row['type']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM foto_kerusakan";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'foto_kerusakan_' , "w");
fputcsv($file, array(
    'id_foto_kerusakan',
    'id_pengukuran',
    'title',
    'filename',
    'size',
    'keterangan'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_foto_kerusakan'],
            $row['id_pengukuran'],
            $row['title'],
            $row['filename'],
            $row['size'],
            $row['keterangan']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM foto_klaster";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'foto_klaster_' , "w");
fputcsv($file, array(
    'id',
    'id_klaster',
    'url',
    'ket_foto',
    'upload_by'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id'],
            $row['id_klaster'],
            $row['url'],
            $row['ket_foto'],
            $row['upload_by']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM foto_ktk";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'foto_ktk_' , "w");
fputcsv($file, array(
    'id_foto_ktk',
    'kode_plot',
    'title',
    'filename',
    'size',
    'keterangan'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_foto_ktk'],
            $row['kode_plot'],
            $row['title'],
            $row['filename'],
            $row['size'],
            $row['keterangan']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM foto_lbds";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'foto_lbds_' , "w");
fputcsv($file, array(
    'id_foto_lbds',
    'id_pengukuran',
    'title',
    'filename',
    'size',
    'keterangan'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_foto_lbds'],
            $row['id_pengukuran'],
            $row['title'],
            $row['filename'],
            $row['size'],
            $row['keterangan']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM foto_tajuk";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'foto_tajuk_' , "w");
fputcsv($file, array(
    'id_foto_tajuk',
    'id_pengukuran',
    'title',
    'filename',
    'size',
    'keterangan'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_foto_tajuk'],
            $row['id_pengukuran'],
            $row['title'],
            $row['filename'],
            $row['size'],
            $row['keterangan']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM foto_user";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'foto_user_' , "w");
fputcsv($file, array(
    'id_foto',
    'id_user',
    'filename',
    'size'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_foto'],
            $row['id_user'],
            $row['filename'],
            $row['size']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM hak_milik_jenis_fungsi_hutan";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'hak_milik_jenis_fungsi_hutan_' , "w");
fputcsv($file, array(
    'id_hmjf',
    'id_klaster_plot',
    'id_hak_milik',
    'id_fungsi_hutan'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_hmjf'],
            $row['id_klaster_plot'],
            $row['id_hak_milik'],
            $row['id_fungsi_hutan']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM kerusakan_pohon";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'kerusakan_pohon_' , "w");
fputcsv($file, array(
    'id',
    'id_pengukuran',
    'id_tanaman',
    'kdDgL1',
    'kdDgT1',
    'kdSrVT1',
    'kdDgL2',
    'kdDgT2',
    'kdSrVT2',
    'kdDgL3',
    'kdDgT3',
    'kdSrVT3'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id'],
            $row['id_pengukuran'],
            $row['id_tanaman'],
            $row['kdDgL1'],
            $row['kdDgT1'],
            $row['kdSrVT1'],
            $row['kdDgL2'],
            $row['kdDgT2'],
            $row['kdSrVT2'],
            $row['kdDgL3'],
            $row['kdDgT3'],
            $row['kdSrVT3']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM kondisi_tajuk";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'kondisi_tajuk_' , "w");
fputcsv($file, array(
    'id',
    'id_pengukuran',
    'id_tanaman',
    'lcr',
    'cden',
    'ft',
    'cdb',
    'cdw',
    'cd90',
    'cd',
    'nlcr',
    'ncden',
    'nft',
    'ncdb',
    'vcri',
    'kesimpulan'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id'],
            $row['id_pengukuran'],
            $row['id_tanaman'],
            $row['lcr'],
            $row['cden'],
            $row['ft'],
            $row['cdb'],
            $row['cdw'],
            $row['cd90'],
            $row['cd'],
            $row['nlcr'],
            $row['ncden'],
            $row['nft'],
            $row['ncdb'],
            $row['vcri'],
            $row['kesimpulan']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM ktk_fisika";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'ktk_fisika_' , "w");
fputcsv($file, array(
    'id_ktk',
    'kode_klaster',
    'kode_plot',
    'pengukuran_ke',
    'titik_plot',
    'terbuka',
    'tertutup',
    'tekstur',
    'warna_tanah',
    'ketebalan',
    'lintang_tanah',
    'bujur_tanah'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_ktk'],
            $row['kode_klaster'],
            $row['kode_plot'],
            $row['pengukuran_ke'],
            $row['titik_plot'],
            $row['terbuka'],
            $row['tertutup'],
            $row['tekstur'],
            $row['warna_tanah'],
            $row['ketebalan'],
            $row['lintang_tanah'],
            $row['bujur_tanah']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM ktk_kimia";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'ktk_kimia_' , "w");
fputcsv($file, array(
    'id_ktk',
    'kode_klaster',
    'id_sifat',
    'cec',
    'pengukuran_ke'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_ktk'],
            $row['kode_klaster'],
            $row['id_sifat'],
            $row['cec'],
            $row['pengukuran_ke']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM lbds";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'lbds_' , "w");
fputcsv($file, array(
    'id',
    'id_pengukuran',
    'id_tanaman',
    'azimuth',
    'jarak',
    'keliling',
    'jarijari',
    'tinggi',
    'Hasil_LBDS',
    'v',
    'isInserted'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id'],
            $row['id_pengukuran'],
            $row['id_tanaman'],
            $row['azimuth'],
            $row['jarak'],
            $row['keliling'],
            $row['jarijari'],
            $row['tinggi'],
            $row['Hasil_LBDS'],
            $row['v'],
            $row['isInserted']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM login";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'login_' , "w");
fputcsv($file, array(
    'id_login',
    'id_user',
    'time_login',
    'time_logout'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_login'],
            $row['id_user'],
            $row['time_login'],
            $row['time_logout']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM lokasi";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'lokasi_' , "w");
fputcsv($file, array(
    'id_lokasi',
    'id_klaster_plot',
    'id_provinsi',
    'id_kabupaten',
    'id_kecamatan',
    'id_desa',
    'id_kondisi'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_lokasi'],
            $row['id_klaster_plot'],
            $row['id_provinsi'],
            $row['id_kabupaten'],
            $row['id_kecamatan'],
            $row['id_desa'],
            $row['id_kondisi']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM nilai_tertimbang_copy";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'nilai_tertimbang_copy_' , "w");
fputcsv($file, array(
    'id',
    'id_data_klaster',
    'nilai_ktpk',
    'nilai_kphn',
    'nilai_ktjk',
    'nilai_kjpb',
    'nilai_kjfb',
    'nilai_prod'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id'],
            $row['id_data_klaster'],
            $row['nilai_ktpk'],
            $row['nilai_kphn'],
            $row['nilai_ktjk'],
            $row['nilai_kjpb'],
            $row['nilai_kjfb'],
            $row['nilai_prod']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM password_resets";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'password_resets_' , "w");
fputcsv($file, array(
    'email',
    'token',
    'created_at'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['email'],
            $row['token'],
            $row['created_at']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM pengukuran_master";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'pengukuran_master_' , "w");
fputcsv($file, array(
    'id_pengukuran',
    'id_data_klaster',
    'pengukuran_ke',
    'id_plot',
    'tahun_pengukuran',
    'nama_pengukur'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_pengukuran'],
            $row['id_data_klaster'],
            $row['pengukuran_ke'],
            $row['id_plot'],
            $row['tahun_pengukuran'],
            $row['nama_pengukur']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM tabel_master_fauna";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'table_master_fauna_' , "w");
fputcsv($file, array(
    'id_jenis_fauna',
    'nama_latin_fauna',
    'nama_fauna'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_jenis_fauna'],
            $row['nama_latin_fauna'],
            $row['nama_fauna']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM table_master_jenis_tanaman";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'table_master_jenis_tanaman_' , "w");
fputcsv($file, array(
    'id_jenis_tanaman',
    'nama_latin',
    'nama_tanaman'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_jenis_tanaman'],
            $row['nama_latin'],
            $row['nama_tanaman']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM tbl_klaster_plot";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'tbl_klaster_plot_' , "w");
fputcsv($file, array(
    'id_klaster_plot',
    'id_data_klaster',
    'input_by',
    'lintang_klaster',
    'bujur_klaster',
    'nama_klaster',
    'pengelola',
    'ket_pengelola',
    'tipe_hutan',
    'nama_titik_ikat',
    'jarak_ke_titik_ikat',
    'luas',
    'azimuth',
    'koordinatBT',
    'koordinatLS',
    'altitude',
    'tahun_tanam',
    'usia',
    'jarak_tanam_x',
    'jarak_tanam_y',
    'pola_tanam',
    'jenis_tanaman'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_klaster_plot'],
            $row['id_data_klaster'],
            $row['input_by'],
            $row['lintang_klaster'],
            $row['bujur_klaster'],
            $row['nama_klaster'],
            $row['ket_pengelola'],
            $row['tipe_hutan'],
            $row['nama_titik_ikat'],
            $row['jarak_ke_titik_ikat'],
            $row['luas'],
            $row['azimuth'],
            $row['koordinatBT'],
            $row['koordinatLS'],
            $row['koordinatLS'],
            $row['altitude'],
            $row['tahun_tanam'],
            $row['usia'],
            $row['jarak_tanam_x'],
            $row['jarak_tanam_y'],
            $row['jenis_tanaman']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM tbl_plot";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'tbl_plot_' , "w");
fputcsv($file, array(
    'id_plot',
    'id_klaster_plot',
    'nama_plot',
    'jarak_ke_klaster',
    'koordinat_LS',
    'koordinat_BT',
    'kode_foto'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_plot'],
            $row['id_klaster_plot'],
            $row['nama_plot'],
            $row['jarak_ke_klaster'],
            $row['koordinat_LS'],
            $row['koordinat_BT'],
            $row['kode_foto']
        ));
    }
}
fclose($file);

$query = "SELECT * FROM tbl_sifat_kimia_tanah";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $users[] = $row;
    }
}

$file = fopen($path . 'tbl_sifat_kimia_tanah_' , "w");
fputcsv($file, array(
    'id_parameter_kimia',
    'sifat_kimia'
));
if (count($users) > 0)
{
    foreach ($users as $row)
    {
        fputcsv($file, array(
            $row['id_parameter_kimia'],
            $row['sifat_kimia']
        ));
    }
}
fclose($file);

$query = "UPDATE `setting` SET `status` = '1', `maintenance_finish` = NOW() WHERE `setting`.`id` = '1';";

if (!$result = mysqli_query($con, $query))
{
    exit(mysqli_error($con));
}

?>
