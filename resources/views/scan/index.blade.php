<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scan QR Code</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

 <!-- Header -->
  <header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors" title="Kembali ke Beranda">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Scan Presensi QR Code</h1>
      </div>
      <i class="fas fa-qrcode text-green-500 text-xl"></i>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow max-w-2xl mx-auto w-full p-4">
    <div class="bg-white rounded-xl shadow-md p-6 space-y-6">

      @if(session('error'))
        <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center space-x-2">
          <i class="fas fa-exclamation-circle"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-1">Pemindai QR Code</h2>
        <p class="text-gray-600">Arahkan kamera ke QR Code untuk melakukan presensi</p>
      </div>

      <!-- Kamera dan Tombol Start -->
      <div>
        <label for="cameraSelect" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamera</label>
        <div class="flex space-x-2">
          <select id="cameraSelect" class="flex-grow p-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            <option value="">-- Pilih Kamera --</option>
          </select>
          <button onclick="startScan()" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors flex items-center">
            <i class="fas fa-play mr-2"></i> Mulai
          </button>
        </div>
      </div>

      <!-- Upload QR Image -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Atau unggah gambar QR Code</label>
        <input type="file" accept="image/*" onchange="scanFromImage(this)" 
          class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
      </div>

      <!-- Tampilan Kamera / Reader -->
      <div id="reader" class="border-4 border-green-500 rounded-lg w-full max-w-md aspect-square mx-auto overflow-hidden bg-gray-100 flex items-center justify-center">
        <div class="text-center p-4 text-gray-500">
          <i class="fas fa-camera text-4xl mb-2"></i>
          <p>Kamera belum diaktifkan</p>
        </div>
      </div>

      <!-- Hasil Scan -->
      <div id="result" class="p-4 bg-green-50 rounded-lg border border-green-200 text-center">
        <div class="flex items-center justify-center space-x-2 text-green-700">
          <i class="fas fa-qrcode"></i>
          <span>Menunggu scan QR Code...</span>
        </div>
      </div>

      <!-- Form Status Kehadiran -->
      <form id="presenceForm" method="POST" action="{{ route('scan.process') }}" class="hidden bg-white p-4 rounded-lg border border-gray-300 shadow-sm space-y-4">
        @csrf
        <input type="hidden" name="user_id" id="user_id" />

        <div>
          <label for="statusSelect" class="block text-sm font-medium text-gray-700 mb-1">Status Kehadiran</label>
          <select id="statusSelect" name="status" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
            <option value="hadir" selected>Hadir</option>
            <option value="izin">Izin</option>
            <option value="sakit">Sakit</option>
            <option value="tidak hadir">Tidak Hadir</option>
          </select>
        </div>

        <div>
          <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (opsional)</label>
          <textarea id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan..."
            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"></textarea>
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
          <i class="fas fa-check mr-2"></i> Simpan Presensi
        </button>
      </form>

    </div>
  </main>

  <script>
  let html5QrCode;
  let isScanning = false;
  let scanInProgress = false;
  let lastDetectedText = "";
  let detectionTimeout;

  // Mendapatkan daftar kamera
  Html5Qrcode.getCameras().then(devices => {
    const select = document.getElementById("cameraSelect");
    if (devices.length === 0) {
      const option = document.createElement("option");
      option.text = "Tidak ada kamera yang ditemukan";
      option.disabled = true;
      select.appendChild(option);
    } else {
      devices.forEach((device, index) => {
        const option = document.createElement("option");
        option.value = device.id;
        option.text = device.label || `Kamera ${index + 1}`;
        select.appendChild(option);
      });
    }
  }).catch(err => {
    console.error("Gagal mendapatkan kamera:", err);
    const select = document.getElementById("cameraSelect");
    const option = document.createElement("option");
    option.text = "Gagal mengakses kamera";
    option.disabled = true;
    select.appendChild(option);
  });

  function startScan() {
    const camId = document.getElementById("cameraSelect").value;
    if (!camId) {
      alert("Pilih kamera terlebih dahulu");
      return;
    }

    if (isScanning) {
      stopScan();
      setTimeout(() => startScanning(camId), 500);
    } else {
      startScanning(camId);
    }
  }

  function stopScan() {
    if (html5QrCode && isScanning) {
      html5QrCode.stop().then(() => {
        isScanning = false;
        document.getElementById("reader").innerHTML = `
          <div class="text-center p-4 text-gray-500">
            <i class="fas fa-camera text-4xl mb-2"></i>
            <p>Kamera belum diaktifkan</p>
          </div>
        `;
      }).catch(err => {
        console.error("Gagal menghentikan kamera:", err);
      });
    }
  }

  function startScanning(camId) {
    const readerElement = document.getElementById("reader");
    readerElement.innerHTML = "";

    html5QrCode = new Html5Qrcode("reader");
    isScanning = true;
    scanInProgress = false;
    lastDetectedText = "";

    document.getElementById("result").innerHTML = `
      <div id="scan-status" class="flex items-center justify-center space-x-2 text-green-700">
        <i class="fas fa-spinner fa-spin"></i>
        <span>Mendeteksi QR Code...</span>
      </div>
    `;
    document.getElementById("presenceForm").classList.add("hidden");

    const containerWidth = readerElement.offsetWidth;
    const qrboxSize = Math.min(300, containerWidth - 40);

    html5QrCode.start(
      camId,
      { fps: 10, qrbox: { width: qrboxSize, height: qrboxSize } },
      decodedText => {
        if (decodedText !== lastDetectedText) {
          lastDetectedText = decodedText;
          scanInProgress = true;

          document.getElementById("result").innerHTML = `
            <div class="flex items-center justify-center space-x-2 text-green-700">
              <i class="fas fa-check-circle"></i>
              <span>QR Terdeteksi: ${decodedText}</span>
            </div>
          `;

          document.getElementById("user_id").value = decodedText;
          document.getElementById("presenceForm").classList.remove("hidden");

          // Optional: stop scanning automatically
          stopScan();
        }
      },
      errorMessage => {
        if (!scanInProgress) {
          document.getElementById("result").innerHTML = `
            <div class="flex items-center justify-center space-x-2 text-gray-500">
              <i class="fas fa-spinner fa-spin"></i>
              <span>Mendeteksi QR Code...</span>
            </div>
          `;
        }
      }
    ).catch(err => {
      console.error("Gagal memulai kamera:", err);
      isScanning = false;
    });
  }

  function scanFromImage(input) {
    const file = input.files[0];
    if (!file) return;

    const html5QrCodeScanner = new Html5Qrcode("reader");

    html5QrCodeScanner.scanFile(file, true)
      .then(decodedText => {
        document.getElementById("result").innerHTML = `
          <div class="flex items-center justify-center space-x-2 text-green-700">
            <i class="fas fa-check-circle"></i>
            <span>QR Terdeteksi dari Gambar: ${decodedText}</span>
          </div>
        `;
        document.getElementById("user_id").value = decodedText;
        document.getElementById("presenceForm").classList.remove("hidden");
      })
      .catch(err => {
        document.getElementById("result").innerHTML = `
          <div class="flex items-center justify-center space-x-2 text-red-600">
            <i class="fas fa-times-circle"></i>
            <span>Gagal membaca QR Code dari gambar</span>
          </div>
        `;
        console.error("Error scanning from image:", err);
      });
  }

  function scanFromImage(input) {
  const file = input.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function () {
    const dataUrl = reader.result;

    const html5QrCode = new Html5Qrcode(/* element id */ "reader");
    html5QrCode
      .scanFile(file, true)
      .then(decodedText => {
        console.log("QR Code detected:", decodedText);
        showScanResult(decodedText);
        html5QrCode.clear(); // Clear scanner after result
      })
      .catch(err => {
        console.error("Gagal membaca gambar:", err);
        document.getElementById("result").innerHTML = `
          <div class="text-red-600 text-sm"><i class="fas fa-times-circle mr-1"></i> Gagal membaca QR Code dari gambar</div>
        `;
      });
  };
  reader.readAsDataURL(file);
}

function showScanResult(text) {
  lastDetectedText = text;
  document.getElementById("result").innerHTML = `
    <div class="flex items-center justify-center space-x-2 text-green-700">
      <i class="fas fa-check-circle"></i>
      <span>QR Code terdeteksi: <strong>${text}</strong></span>
    </div>
  `;

  document.getElementById("user_id").value = text;
  document.getElementById("presenceForm").classList.remove("hidden");
}


</script>


  
</body>
</html>
