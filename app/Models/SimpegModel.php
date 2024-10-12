<?php

namespace App\Models;

use CodeIgniter\Model;

class SimpegModel extends Model
{
  protected $db;

  public function __construct()
  {
    $this->db = \Config\Database::connect('simpeg', false);

  }

  public function getRow($table,$where)
  {
    $builder = $this->db->table($table);
    $query = $builder->getWhere($where);

    return $query->getRow();
  }

  public function getArray($table,$where=false)
  {
    $builder = $this->db->table($table);

    if($where){
      $query = $builder->getWhere($where);
    }else{
      $query = $builder->get();
    }

    return $query->getResult();
  }

  public function setquery($query)
  {
    $query = $this->db->query($query);
    return $query;
  }

  public function getPegawai($nip)
  {
    $query = $this->db->query("SELECT * FROM TEMP_PEGAWAI WHERE NIP_BARU='$nip'")->getRow();
    return $query;
  }

  public function searchPegawai($nip,$satker)
  {
    $query = $this->db->query("SELECT * FROM TEMP_PEGAWAI WHERE NIP_BARU='$nip' AND KODE_SATUAN_KERJA LIKE '$satker%'")->getRow();
    return $query;
  }

  public function getParentSatker()
  {
    $query = $this->db->query("SELECT * FROM TM_SATUAN_KERJA WHERE JENIS_SATKER='PARENT'")->getResult();
    return $query;
  }

  public function getTempPegawai($kode)
  {
    $query = $this->db->query("SELECT NIP,NIP_BARU,NAMA_LENGKAP,AGAMA,TEMPAT_LAHIR,TANGGAL_LAHIR,JENIS_KELAMIN,PENDIDIKAN,JENJANG_PENDIDIKAN,LEVEL_JABATAN,PANGKAT,GOL_RUANG,TMT_CPNS,TMT_PANGKAT,
                              MK_TAHUN,MK_BULAN,TIPE_JABATAN,TAMPIL_JABATAN,TMT_JABATAN,SATKER_1,SATKER_2,SATKER_3,SATKER_4,SATKER_5,HARI_KERJA,USIA_PENSIUN,TMT_PENSIUN,STATUS_PEGAWAI,NO_HP,EMAIL,HARI_KERJA
                              FROM TEMP_PEGAWAI WHERE KODE_SATUAN_KERJA LIKE '$kode%'")->getResult();
    return $query;
  }

  public function query_row($query)
  {
    $query = $this->db->query($query)->getRow();
    return $query;
  }

  public function query_array($query)
  {
    $query = $this->db->query($query)->getResult();
    return $query;
  }

  public function getCount($table,$where=false)
  {
    $builder = $this->db->table($table);

    if($where){
      $query = $builder->getWhere($where);
    }else{
      $query = $builder->get();
    }

    return $query->countAllResults();
  }

  public function getAuth($nip)
  {
    $query = $this->db->query("exec sp_usermanager @nip='".$nip."', @appid='1'")->getRow();
    return $query;
  }

  public function getskp2022x($start,$limit)
  {
    $query = $this->db->query("SELECT * FROM TM_REKON_SKP WHERE PNS_DINILAI_ID IS NOT NULL ORDER BY
                              PNS_DINILAI_ID ASC
                              OFFSET $start ROWS FETCH NEXT $limit ROWS ONLY")->getResult();
    return $query;
  }

  public function getskp2022()
  {
    $query = $this->db->query("SELECT * FROM v_rekon_skp2022")->getResult();
    return $query;
  }

  public function updateskp2022($nip,$tahun,$status)
  {
    $query = $this->db->query("UPDATE TR_SKP SET SEND_BKN='$status' WHERE NIP='$nip' AND TAHUN='$tahun'");
    return $query;
  }

  public function getInfoKP($year,$month)
  {
    $query = $this->db->query("SELECT SATKER2 AS SATKER, COUNT(*) AS JUMLAH FROM TEMP_PEGAWAI_PANGKAT WHERE TMT_KP <> CAST('$month/01/$year' AS DATE)
                              GROUP BY SATKER2")->getResult();
    return $query;
  }

  public function getCountKP($year,$month)
  {
    $query = $this->db->query("SELECT COUNT(*) AS JUMLAH FROM TEMP_PEGAWAI_PANGKAT
    WHERE TMT_KP <> CAST('$month/01/$year' AS DATE)")->getRow();
    return $query;
  }

  public function pejabat($kode)
  {
    // $query = $this->db->query("exec sp_Linq_Pejabat @kode='".$kode."'")->getResult();
    $query = $this->db->query("exec sp_linq_pejabat_all @rp='".$kode."'")->getResult();
    return $query;
  }

  public function pensiun($kode)
  {
    $query = $this->db->query("exec sp_Linq_PegawaiPensiunPerTahun @kode='".$kode."'")->getResult();
    return $query;
  }

  public function pensiunPegawai($kode,$tahun)
  {
    $query = $this->db->query("exec sp_linq_Pegawai_pensiun_PerSatker @kode='".$kode."', @year='".$tahun."'")->getResult();
    return $query;
  }

  public function addRwJabatan($kode,$tahun)
  {
    $query = $this->db->query("exec spINSERT_RW_JABATAN @@NIP='".$nip."', @KODE_JABATAN='".$jabatan."', @KODE_JABATAN='".$jabatan."', @KODE_BIDANG_STUDI='".$null."', @KODE_SATUAN_KERJA='".$satker."', @NO_SK='".$null."', @TEST_TGL_SK='".$null."', @TGL_SK='".$null."', @TEST_TMT='".$null."', @TMT_SK='".$null."', @KODE_JABATAN_2='".$null."', @KODE_SATUAN_KERJA_2='".$null."', @NO_SK_2='".$null."', @TEST_TGL_SK_2='".$null."', @TGL_SK_2='".$null."', @TEST_TMT_SK_2='".$null."', @USERID='".$null."', @KETERANGAN='".$null."', @KODE_PANGKAT='".$null."'")->getResult();
    return $query;
  }

  public function get_news()
  {
    $query = $this->db->query("SELECT berita_id,tgl_berita, judul_berita FROM TM_BERITA WHERE status_berita='1' ORDER BY tgl_berita DESC");

    return $query->getResult();
  }

  public function get_map($kode)
  {
    $query = $this->db->query("SELECT SATUAN_KERJA, LAT, LON FROM TM_SATUAN_KERJA WHERE LAT IS NOT NULL AND LAT !='0' AND KODE_SATUAN_KERJA LIKE '$kode%' ORDER BY KODE_SATUAN_KERJA ASC");

    return $query->getResult();
  }

  public function subsatker($kodesatker)
  {
    $query = $this->db->query("SELECT * FROM TM_SATUAN_KERJA
                              WHERE KODE_ATASAN='$kodesatker'")->getResult();

    return $query;
  }

  public function temppegawailat($kodesatker)
  {
    $query = $this->db->query("SELECT * FROM TEMP_PEGAWAI_LATLON
                              WHERE KODE_SATKER='$kodesatker'")->getResult();

    return $query;
  }

  public function updatekoordinat($satker,$lat,$lon)
  {
    $query = $this->db->query("UPDATE TM_SATUAN_KERJA SET LAT='$lat', LON='$lon'
                              WHERE KODE_SATUAN_KERJA='$satker'");

    return $query;
  }

  public function dashboard_jk($kode)
  {
    if($kode == 0){
      $query = $this->db->query("SELECT JENIS_KELAMIN, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE JENIS_KELAMIN IS NOT NULL GROUP BY JENIS_KELAMIN");
    }else{
      $query = $this->db->query("SELECT JENIS_KELAMIN, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE KODE_SATUAN_KERJA LIKE '$kode%' GROUP BY JENIS_KELAMIN");
    }

    return $query->getResult();
  }

  public function report_jk()
  {
    $query = $this->db->query("SELECT JENIS_KELAMIN, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE STATUS_PEGAWAI != 'Non' GROUP BY JENIS_KELAMIN");

    return $query->getResult();
  }

  public function dashboard_jab($kode)
  {
    if($kode == 0){
      $query = $this->db->query("SELECT LEVEL_JABATAN, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE LEVEL_JABATAN IS NOT NULL GROUP BY LEVEL_JABATAN ORDER BY LEVEL_JABATAN");
    }else{
      $query = $this->db->query("SELECT LEVEL_JABATAN, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE LEVEL_JABATAN IS NOT NULL AND KODE_SATUAN_KERJA LIKE '$kode%' GROUP BY LEVEL_JABATAN ORDER BY LEVEL_JABATAN");
    }

    return $query->getResult();
  }

  public function report_jab()
  {
    $query = $this->db->query("SELECT LEVEL_JABATAN, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE STATUS_PEGAWAI != 'Non' GROUP BY LEVEL_JABATAN ORDER BY LEVEL_JABATAN");

    return $query->getResult();
  }

  public function dashboard_agama($kode)
  {
    if($kode == 0){
      $query = $this->db->query("SELECT AGAMA, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE AGAMA IS NOT NULL GROUP BY AGAMA ORDER BY AGAMA");
    }else{
      $query = $this->db->query("SELECT AGAMA, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE AGAMA IS NOT NULL AND KODE_SATUAN_KERJA LIKE '$kode%' GROUP BY AGAMA ORDER BY AGAMA");
    }

    return $query->getResult();
  }

  public function report_agama()
  {
    $query = $this->db->query("SELECT AGAMA, COUNT(NIP) AS JUMLAH FROM TEMP_PEGAWAI WHERE STATUS_PEGAWAI != 'Non' GROUP BY AGAMA ORDER BY AGAMA");

    return $query->getResult();
  }

  public function getPetabyJabatan($kode)
  {
    if($kode == 0){
      $query = $this->db->query("SELECT LEVEL_JABATAN AS JABATAN, COUNT(NIP_BARU) AS JML FROM TEMP_PEGAWAI WHERE LEVEL_JABATAN IS NOT NULL GROUP BY LEVEL_JABATAN");
    }else{
      $query = $this->db->query("SELECT LEVEL_JABATAN AS JABATAN, COUNT(NIP_BARU) AS JML FROM TEMP_PEGAWAI WHERE LEVEL_JABATAN IS NOT NULL AND KODE_SATKER_2='$kode' GROUP BY LEVEL_JABATAN");
    }

    return $query->getResult();
  }

  public function search_user($nip,$satker)
  {
    if(session('role') == 1){
      $query = $this->db->query("SELECT * FROM TS_USER WHERE NIP='$nip'");
    }else{
      $query = $this->db->query("SELECT * FROM TS_USER WHERE NIP='$nip' AND KODE_UNIT_KERJA LIKE '$satker%'");
    }

    return $query->getRow();
  }

  public function updatepassword($nip,$password)
  {
    $query = $this->db->query("UPDATE TS_USER SET PWD='$password' WHERE NIP='$nip'");
    $query = $this->db->query("UPDATE TEMP_PEGAWAI_SSO SET PWD='$password' WHERE NIP_USER='$nip'");

    return $query;
  }
}
