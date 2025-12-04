// === FIX MODE GELAP / TERANG ===
function initDarkMode() {
  const themeBtn = document.getElementById("themeToggle");
  if (!themeBtn) return;

  let darkMode = localStorage.getItem("darkMode") === "true";
  document.body.classList.toggle("dark", darkMode);
  themeBtn.textContent = darkMode ? "☀️" : "🌙";

  themeBtn.addEventListener("click", () => {
    //animasi klik
    themeBtn.classList.add("pulse");
    setTimeout(() => themeBtn.classList.remove("pulse"), 500);

    // === logika dark mode ===
    darkMode = !darkMode;
    document.body.classList.toggle("dark", darkMode);
    localStorage.setItem("darkMode", darkMode);
    themeBtn.textContent = darkMode ? "☀️" : "🌙";

    if (typeof showToast === "function") {
      showToast(darkMode ? "Mode Gelap Aktif" : "Mode Terang Aktif", "info");
    }
  });
}

// Jalankan di semua kondisi load
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initDarkMode);
} else {
  initDarkMode();
}


// =============================
// TOAST / SNACKBAR HANDLER
// =============================
document.addEventListener("DOMContentLoaded", () => {
  let toastContainer = document.getElementById("toastContainer");
  if (!toastContainer) {
    toastContainer = document.createElement("div");
    toastContainer.id = "toastContainer";
    toastContainer.style.position = "fixed";
    toastContainer.style.bottom = "20px";
    toastContainer.style.right = "20px";
    toastContainer.style.zIndex = "9999";
    document.body.appendChild(toastContainer);
  }
window.showToast = function (message, type = "default", duration = 3000) {
  const toastContainer = document.getElementById("toastContainer");

  // Batasi maksimal 3 toast aktif
  const activeToasts = toastContainer.querySelectorAll(".toast");
  if (activeToasts.length >= 3) {
    // Hapus toast tertua biar tetap max 3
    activeToasts[0].remove();
  }

  const toast = document.createElement("div");
  toast.className = `toast ${type}`;
  toast.textContent = message;

  // Style inline (biar tetap tampil meski CSS belum termuat)
  toast.style.background = "#333";
  toast.style.color = "#fff";
  toast.style.padding = "10px 18px";
  toast.style.borderRadius = "6px";
  toast.style.marginTop = "10px";
  toast.style.boxShadow = "0 2px 5px rgba(0,0,0,0.3)";
  toast.style.opacity = "0";
  toast.style.transition = "opacity 0.3s ease";

  toastContainer.appendChild(toast);

  // Animasi muncul
  requestAnimationFrame(() => {
    toast.style.opacity = "1";
  });

  // Auto hilang
  setTimeout(() => {
    toast.style.opacity = "0";
    setTimeout(() => toast.remove(), 300);
  }, duration);
};
});


// =============================
// FILTER STATUS (DOM #3)
// =============================
const filterStatus = document.getElementById("filterStatus");
if (filterStatus) {
  filterStatus.addEventListener("change", function () {
  const filterValue = this.value.toLowerCase();
  const table = document.querySelector("#tabelKeluhan");
  const rows = table.querySelectorAll("tbody tr");

  let visibleCount = 0;

  rows.forEach(row => {
    const status = row.querySelector("td:last-child").textContent.toLowerCase();
    if (filterValue === "all" || status.includes(filterValue)) {
      row.style.display = "";
      visibleCount++;
    } else {
      row.style.display = "none";
    }
    
  });
  

  // Tampilkan toast sesuai hasil filter
  if (visibleCount === 0) {
    showToast("Tidak ada data dengan status tersebut.", "info");
  } else if (filterValue === "all") {
    showToast(`Menampilkan semua data (${visibleCount} baris)`, "info");
  } else {
    const text = filterValue.charAt(0).toUpperCase() + filterValue.slice(1);
    showToast(`Filter diubah ke: ${text} (${visibleCount} baris)`, "success");
  }
});

}
// =============================
// CETAK LAPORAN (DOM #4)
// =============================
const btnCetak = document.getElementById('btnCetak');
if (btnCetak) {
  btnCetak.addEventListener('click', (e) => {
    e.preventDefault();

    // Hapus semua toast yang masih tampil
    const existingToasts = document.querySelectorAll('.toast');
    existingToasts.forEach(t => t.remove());

    // Lanjut ke cetak
    window.print();
  });
}

// =============================
// POPUP BOXES (sesuai modul)
// =============================
const logoutBtn = document.querySelector(".logout-btn");
if (logoutBtn) {
  logoutBtn.addEventListener("click", (e) => {
    const konfirmasi = confirm("Apakah kamu yakin ingin logout?");
    if (!konfirmasi) {
      e.preventDefault();
      showToast("Logout dibatalkan.", "info");
    } else {
      localStorage.removeItem("namaUser");
      showToast("Berhasil logout!", "success");
    }
  });
}

// =============================
// EVENT TAMBAHAN
// =============================

// Event 1: Double Click (dblclick)
document.addEventListener("dblclick", () => {
  showToast("Kamu baru saja double click di halaman ini!", "info");
});

// Event 3: Keydown (tekan tombol keyboard)
document.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    showToast("Kamu menekan tombol Enter", "success");
  }
});

// =============================
// ASYNCHRONOUS + PROMISE + FETCH
// =============================
async function ambilCuaca() {
  try {
    // ambil API cuaca dari weatherapi.com
    const res = await fetch("https://api.weatherapi.com/v1/current.json?key=af059e52b7214a43bd1231314251510&q=Malang&lang=id");
    
    // Kalau gagal respons, lempar error
    if (!res.ok) throw new Error("Gagal mengambil data dari server");
    
    // Konversi hasilnya jadi JSON
    const data = await res.json();

    // Tampilkan di console untuk dicek
    console.log(data);

    // Tampilkan hasil ke HTML
    document.getElementById("quote").innerText =
      `Cuaca di ${data.location.name}: ${data.current.temp_c}°C, ${data.current.condition.text}`;
  } catch (err) {
    console.error(err);
    document.getElementById("quote").innerText = "Gagal memuat data cuaca";
  }
}
document.addEventListener("DOMContentLoaded", ambilCuaca);