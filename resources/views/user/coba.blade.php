{

  "data" : [

    @for($i=0;$i<$jumlah_data-1;$i++) {
      "id_tanaman" : "{{$data_kerusakan[$i]->id_tanaman_plot}}",
      "nama_pohon" : "{{$data_kerusakan[$i]->nama_tanaman}}",
      "nama_latin" : "{{$data_kerusakan[$i]->nama_latin}}",
      "kdDgL1" : "{{$data_kerusakan[$i]->kdDgL1}}",
      "kdDgT1" : "{{$data_kerusakan[$i]->kdDgT1}}",
      "kdSrVT1" : "{{$data_kerusakan[$i]->kdSrVT1}}",

      "kdDgL2" : "{{$data_kerusakan[$i]->kdDgL2}}",
      "kdDgT2" : "{{$data_kerusakan[$i]->kdDgT2}}",
      "kdSrVT2" : "{{$data_kerusakan[$i]->kdSrVT2}}",

      "kdDgL3" : "{{$data_kerusakan[$i]->kdDgL3}}",
      "kdDgT3" : "{{$data_kerusakan[$i]->kdDgT3}}",
      "kdSrVT3" : "{{$data_kerusakan[$i]->kdSrVT3}}",

      "tli" : "{{$data_kerusakan[$i]->tli}}"
    },
    @endfor

    {
    "id_tanaman" : "{{$data_kerusakan[$jumlah_data-1]->id_tanaman_plot}}",
    "nama_pohon" : "{{$data_kerusakan[$jumlah_data-1]->nama_tanaman}}",
    "nama_latin" : "{{$data_kerusakan[$jumlah_data-1]->nama_latin}}",
    "kdDgL1" : "{{$data_kerusakan[$jumlah_data-1]->kdDgL1}}",
    "kdDgT1" : "{{$data_kerusakan[$jumlah_data-1]->kdDgT1}}",
    "kdSrVT1" : "{{$data_kerusakan[$jumlah_data-1]->kdSrVT1}}",

    "kdDgL2" : "{{$data_kerusakan[$jumlah_data-1]->kdDgL2}}",
    "kdDgT2" : "{{$data_kerusakan[$jumlah_data-1]->kdDgT2}}",
    "kdSrVT2" : "{{$data_kerusakan[$jumlah_data-1]->kdSrVT2}}",

    "kdDgL3" : "{{$data_kerusakan[$jumlah_data-1]->kdDgL3}}",
    "kdDgT3" : "{{$data_kerusakan[$jumlah_data-1]->kdDgT3}}",
    "kdSrVT3" : "{{$data_kerusakan[$jumlah_data-1]->kdSrVT3}}",

    "tli" : "{{$data_kerusakan[$jumlah_data-1]->tli}}"
  }

  ]
}
